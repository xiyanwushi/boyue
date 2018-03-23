<?php
namespace Admin\Controller;
use Think\Controller;
class MchController extends Controller {
	public function _initialize(){
		if(!session('mch')){
			redirect('./mch.php');
		}
		$this->mch = session('mch');
		// 从数据读取配置参数
		$config = M('config') -> select();
		foreach($config as $v){
			$key = '_'.$v['name'];
			$this -> $key = unserialize($v['value']);
			$_CFG[$v['name']] = $this -> $key;
		}
		$this -> assign('_CFG', $_CFG);
		$GLOBALS['_CFG'] = $_CFG;
	}	
	
	public function index(){
		//商户不能发布积分商品
		
		// 查询分类信息
		$title = I('post.title');
		if($title){
				$where['title']=array('like','%'.$title.'%') ;
			}
			
		$cates = M('product_cate')->where(array('pid'=>0)) -> select();
		$this -> assign('cates', $cates);
		
		
		$model = M('product');
		$where['user_id'] = $this->mch['id'];
		$count = $model -> where($where) -> count();
		$page = new \Think\Page($count, 10);
		if(!$order){
			$order = "id desc";
		}	
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order($order) -> select();
		$this->assign('list',$list);
		$this->assign('page',$page->show());
		$this->display();

	}
	
	
	public function edit(){
		$model = M('product');
		$id = intval($_GET['id']);
		
		$mseparate = explode('-',$this->_mch['mpseparate']);
		$this->assign('mseparate',$mseparate);
		
		$mplv = explode('-',$this->_mch['mplv']);
		$this->assign('mplv',$mplv);
		
		if($id>0){
			$info = $model -> find($id);
			if(!$info || $info['user_id'] != $this->mch['id']) die('信息不存在');
			$bar = explode('|',$info['banner']);
			foreach($bar as $k=>$v){
				$banner[$k+1] = $v;
			}
			$info['banner'] = $banner;
			$info['feature'] = explode(',',$info['feature']);
			$this -> assign('info', $info);
		}

		
		if(IS_POST){
			$pcount = M('product')->where(array('user_id'=>$this->mch['id'],'status'=>1))->count();
			if($pcount>=$this->_mch['mnums']){
				$this->error('您添加的商品超过数量了');
				exit;
			}
			
			$points = $_POST['points']*$this->_site['points_rate']/100;
			$price = $points + $_POST['price'];
	
			if($price > $this->_mch['mprice']){
				$this->error('设置的商品总价超出范围');
				exit;
			}
			if($_POST['separate']<$mseparate[0] || $_POST['separate']>$mseparate[1]){
				$this->error('设置的返佣比例不在范围内');
				exit;
			}
			
			
			$lv = $points/$price*100;
			if($lv<$mplv[0] || $lv>$mplv[1]){
				$this->error('设置的商品积分不在范围内');
				exit;
			}
			
			for($i=1;$i<6;$i++){
				if($_POST['pic'.$i]){
					$array[] = $_POST['pic'.$i];
				}
			}
			$_POST['user_id'] = $this->mch['id'];
			$_POST['banner'] = implode('|',$array);
			$_POST['feature'] = implode(',',$_POST['feature']);
			if($id>0){
				$_POST['id'] = $id;
				$_POST['status'] = 0;
				$model -> save($_POST);
				$this -> success('操作成功！', U('index'));
				exit;
			}else{
				$_POST['status'] = 0;
				$model -> add($_POST);
				$this -> success('添加成功！', U('index'));
				exit;
			}
		}
		
		foreach($this->_feature['config'] as $k=>$v){
			if(!$v['checked']){
				$feature[$k]=$v['name'];
			}
		}
		
		$this->assign('feature',$feature);
		$this->display();
	}
	
	
	public function order(){
		$where = $this -> _get_where();
		$where_paid = $where;
		$where_paid['status'] = array('gt',1);// array_merge(array('status' => ),$where);

		$where['mch_id'] = $this->mch['id'];

		// 总订单数
		$this -> assign('orders', M('mch_order') -> where($where) -> count());

		// 已支付订单数
		$this -> assign('orders_paid', M('mch_order') -> where($where_paid) -> count());
		// 总额
		$this -> assign('total', M('mch_order') -> where($where) -> sum('total'));
		// 已支付总额
		$this -> assign('total_paid', M('mch_order') -> where($where_paid) -> sum('total'));

		// 微信支付
		$this -> assign('wxpay', M('mch_order') -> where($where) -> sum('wxpay'));
		// 余额支付
		$this -> assign('moneypay', M('mch_order') -> where($where) -> sum('moneypay'));
		// 积分支付
		$this -> assign('pointspay', M('mch_order') -> where($where) -> sum('pointspay'));
		$this -> assign('cxpointspay', M('mch_order') -> where($where) -> sum('cxpointspay'));
		
		$this -> _list('mch_order',$where);
	}
	
	
	private function _get_where(){
		if(IS_POST){
			$_GET  = array_merge($_GET, $_POST);
			$_GET['p'] = 1; //如果是post的话回到第一页
		}
		if(!empty($_GET['status'])){
			$where['status'] = intval($_GET['status']);
		}
		
		if(!empty($_GET['user_id'])){
			$where['user_id'] = intval($_GET['user_id']);
		}
		
		
		if(!empty($_GET['time1']) && !empty($_GET['time2'])){
			$where['create_time'] = array(
				array('gt', strtotime($_GET['time1'])),
				array('lt', strtotime($_GET['time2']) + 86400)
			);
		}
		elseif(!empty($_GET['time1'])){
			$where['create_time'] = array('gt', strtotime($_GET['time1']));
		}
		elseif(!empty($_GET['time2'])){
			$where['create_time'] = array('lt', strtotime($_GET['time2'])+86400);
		}
		return $where;
	}
	
	// 订单详情
	public function detail(){
		$id = intval($_GET['id']);
		$order_info = M('mch_order') -> find($id);
		if(!$order_info){
			$this -> error('订单不存在');
		}
		$this -> assign('info', $order_info);
		
		//查询商品信息
		$product_list_zq = M('cart') -> where(array('id' => array('in',$order_info['cart_id']),'is_zq'=>1)) -> select();
		$product_list = M('cart') -> where(array('id' => array('in',$order_info['cart_id']),'is_zq'=>0)) -> select();
		$this -> assign('zq_product', $product_list_zq);
		$this -> assign('product', $product_list);
		
		$this -> display();
	}
	
	
	// ajax设置快递信息,发货
	public function set_express(){
		$name = I('post.name');
		$no = I('post.no');
		$order_id = intval($_POST['order']);
		$order_info = M('mch_order') -> find($order_id);
		
		if($order_info['status'] == -2){
			$this->error('该订单不允许发货');
		}
		//查询是否有申请退款的商品，若有则不允许发货
		$cart = M('cart')->where(array('id'=>array('in',$order_info['cart_id']),'status'=>-1))->find();
		
		if($cart && !empty($cart)){
			$this->error('存在退货商品，请先操作退货商品后进行发货');
		}
		M('mch_order') -> where(array("id"=>$order_id)) -> save(array(
			'express' => $name,
			'express_no' => $no,
			'delivery_time' => NOW_TIME, //发货时间
			'status' => 3 // 已发货状态
		));
		M('cart')->where(array('id'=>array('in',$order_info['cart_id']),'status'=>2))->save(array(
			'express' => $name,
			'express_no' => $no,
			'status'=>3,
		));
		
		$this->success('发货成功');
	}
	
	//取消单个商品
	public function cancleOne(){
		$cart_id = I('get.cart_id');
		$order_id = I('get.order_id');
		if($_GET['jujue'] && $_GET['jujue']==1){
			$order = M('mch_order')->find(intval($order_id));
			M('cart')->where(array('id'=>$cart_id))->save(array('status'=>$order['status']));
			$this->success('拒绝单个商品退货!');
		}else{
			cancleOneCart($cart_id,$order_id,true);
			$this->success('取消单个商品成功!');
		}
		
	}
	
	
	// 实时数据
	public function report(){
		$data = array();
		
		// 所有订单数
		$data['orders'] = M('mch_order') -> count();
		
		// 已完成订单
		$data['order_5'] = M('mch_order') -> where(array('status' => 5,'mch_id'=>$this->mch['id'])) -> count();
		
		// 已取消订单
		$data['order_22'] = M('mch_order') -> where(array('status' => -2,'mch_id'=>$this->mch['id'])) -> count();
		
		// 代发货订单
		$data['order_2'] = M('mch_order') -> where(array('status' => 2,'mch_id'=>$this->mch['id'])) -> count();
		
		// 待支付订单
		$data['order_1'] = M('mch_order') -> where(array('status' => 1,'mch_id'=>$this->mch['id'])) -> count();
		
		// 总营业额
		$data['money_total'] = M('mch_order') -> where(array('status' => array('gt' , 0),'mch_id'=>$this->mch['id'])) -> sum('total');
		$data['money_points_total'] = M('mch_order') -> where(array('status' => array('gt' , 0),'mch_id'=>$this->mch['id'])) -> sum('points_total');
		
		// 余额支付总入账
		$data['money_moneypay'] = M('mch_order') -> where(array('status' => array('gt' , 0))) -> sum('moneypay');
		
		// 今日销售额
		$data['total_total'] = M('mch_order') -> where(array(
			'create_time' => array('gt', strtotime('today')),
			'status' => array('gt', 1),
			'mch_id'=>$this->mch['id']
			)) -> sum('total');
		$data['total_points'] = M('mch_order') -> where(array(
			'create_time' => array('gt', strtotime('today')),
			'status' => array('gt', 1),
			'mch_id'=>$this->mch['id']
			)) -> sum('total');
			
		
		// 今日现金支付
		$data['money_today'] = M('mch_order') -> where(array(
			'create_time' => array('gt', strtotime('today')),
			'status'=>array('gt',1),
			'mch_id'=>$this->mch['id']
			)) -> sum('wxpay');
		
		// 会员总积分
		$data['user_points'] = M('user') -> sum('points');
		
		// 分成总额
		$data['separate_points_total'] = M('separate_log')->where(array('user_id'=>$this->mch['id'])) -> sum('points');
		// 未发放分成
		$data['separate_points_no'] = M('separate_log') -> where(array('user_id'=>$this->mch['id'],'status'=>1)) -> sum('points');
		// 待发放分成
		$data['separate_points_wait'] = M('separate_log') -> where(array('user_id'=>$this->mch['id'],'status'=>0)) -> sum('points');		
		// 已发放金额
		$data['separate_points_done'] = M('separate_log') -> where(array('user_id'=>$this->mch['id'],'status'=>3)) -> sum('points');
		
		$this -> assign('info', $data);
		$this -> display();
	}
	
	
	// 取消订单
	public function cancle_order(){
		$order_id = intval($_POST['order_id']);	
		$order = M('mch_order') -> find($order_id);
		
		// 订单状态设置为-1
		M('mch_order') -> where(array('id'=>$order_id)) -> save(array(
			'status' => -2,
			'confirm_time' => NOW_TIME
		));

		// 分成状态设置为-1
		M('separate_log') -> where(array('order_id'=>$order['order_id'])) -> setField('status', -1);
		
		// 如果是已完成状态，则表示分成已到帐，需要扣除
		if($order_info['status'] == 3){
			$slog = M('separate_log') -> where(array('order_id'=>$order['order_id'])) -> select();
			foreach($slog as $log){
				M('user') -> where(array('id'=>$log['user_id'])) -> save(array(
					'points' => array('exp', 'points-'.$log['points']),
				));
				if($log['points'] >0){
					flog($log['user_id'],'points',"-".$log['points'],7);
				}
			}
		}
		
		$data = array();
		//将已支付的费用原路返回
		if($order['cxpointspay'] >0){
			$data['cx_points'] = array('exp','cx_points+'.$order['cxpointspay']);
			flog($order['user_id'],'cx_points', "+".$order['cxpointspay'],6);
		}
		if($order['pointspay'] >0){
			$data['points'] = array('exp','points+'.$order['pointspay']);
			flog($order['user_id'],'points', "+".$order['pointspay'],6);
		}
		if($order['moneypay'] >0){
			$data['money'] = array('exp','money+'.$order['moneypay']);
			flog($order['user_id'],'money', "+".$order['moneypay'],6);
		}
		if($order_info['wxpay']>0){
			$data['money'] = array('exp','money+'.$order['wxpay']);
			flog($order['user_id'],'money', "+".$order['wxpay'],6);
		}
		
		if(count($data) > 0){
			M('user') -> where(array('id'=>$order['user_id'])) -> save($data);
		}
		$this -> success('操作成功！');
	}
	
	
	// 根据分类获得子分类
	public function get_child_cates(){
		$pid = intval($_REQUEST['id']);
		$cates = M('product_cate') -> where(array('pid' => $pid)) -> select();
		$data = array();
		foreach($cates as $cate){
			$data[$cate['id']] = array('name' => $cate['name']);
		}
		$this -> ajaxReturn($data);
	}
	
	
	// 上传图片
	public function upload(){
		if(!empty($_GET['url']))
			$this -> assign('url', $_GET['url']);
		if(IS_POST){
			
			if($_GET['field'])
				$field = $_GET['field'];
			if(empty($field))
				$field = 'file';
			
			if($_FILES[$field]['size'] < 1 && $_FILES[$field]['size']>0){
				$this -> assign('errmsg', '上传错误！');
			}else{
				$ext = $this -> _get_ext($_FILES[$field]['name']);
				if(!in_array(strtolower($ext),array('jpg','jpeg','gif','png'))){
					$this -> error('请上传正确的图片');
				}
				$new_name = $this -> _get_new_name($ext, 'images');
				if(move_uploaded_file($_FILES[$field]['tmp_name'], $new_name['fullname'])){
					$this -> assign('url', $new_name['fullname']);
				}else
					$this -> assign('errmsg', '文件保存错误！');
				
				
			}
		}
		C('LAYOUT_ON', false);
		$this -> display();
	}
	
	/**
	*	根据文件名获取后缀
	*/
	private function _get_ext($file_name){
        return substr(strtolower(strrchr($file_name, '.')),1);
    }

    /**
	*	根据文件类型(后缀)生成文件名和路径
	*	@param return array('name', 'fullname' )
	*	* 文件名取时间戳和随机数的36进制而不是62进制是为了防止windows下大小写不敏感导致文件重名
	*/
	private function _get_new_name($ext, $dir = 'default'){
        $name 		= date('His') . substr(microtime(),2,8) . rand(1000,9999) . '.' . $ext;
        $path 		= './Public/upload/' . $dir . date('/ym/d') .'/';

        // 如果路径不存在则递归创建
        if(!is_dir($_SERVER['DOCUMENT_ROOT'].__ROOT__ . $path)){
        	mkdir($_SERVER['DOCUMENT_ROOT'] .__ROOT__. $path, 0777, 1);
        }

        return array(
        		'name'		=> $name,
        		'fullname'	=> $path . $name
        	);
    }
	
	// 通用简单列表方法
	protected function _list($table, $where= null, $order = null){
		$list = $this -> _get_list($table, $where, $order);
		$this -> assign('list', $list);
		$this -> assign('page', $this -> data['page']);
		$this -> display();
	}
	
	// 获得一个列表,返回而不输出
	protected function _get_list($table, $where= null, $order = null){
		$model = M($table);
		$count = $model -> where($where) -> count();
		$page = new \Think\Page($count, 25);
		if(!$order){
			$order = "id desc";
		}
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order($order) -> select();
		//echo M()->getLastSql();
		
		// 将数据保存到成员变量
		$this -> data = array(
			'list' => $list,
			'page' => $page -> show(),
			'count' => $count
		);
		
		return $list;
	}
	
	//  退出
	public function logout(){
		M('mch_login')->where(array('user_id'=>$this->mch['id']))->setField('status',0);
		session('mch',null);
		redirect('./mch.php');		
	}
   
    public function del(){
		if(M('product')->where(array('id'=>$_GET['id']))->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
}?>