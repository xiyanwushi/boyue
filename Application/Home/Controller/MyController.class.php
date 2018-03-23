<?php
namespace Home\Controller;
use Think\Controller;
class MyController extends HomeController {
    public function index(){
		//我关注的总数
		$this->assign('favorite',M('favorite')->where(array('user_id'=>$this->user['id'],'status'=>1))->count());
		$this->display();
    }
	

	// 收货地址
	public function addr(){
		$act = empty($_GET['act']) ? '' : $_GET['act'];
		$list = M('addr') -> where(array('user_id' => $this -> user['id']))->order('is_default desc') -> select();

		// 如果没有地址且是选择地址则直接跳转到添加地址
		if(!$list && $act == 'select'){
			header("location:".U('My/addr_add',array('act'=>$act,'is_default'=>$_GET['is_default'])));
			exit;
		}
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 添加收货地址
	public function addr_add(){
		if(IS_POST){
			if(empty($_POST['name']) || empty($_POST['mobile']) || empty($_POST['addr']) || empty($_POST['district'])){
				$this -> error('请填写完整');
			}
			$mobile = I('post.mobile');
			if(!isPhone($mobile)){
				$this->error('手机号码错误');
			}
			$addr = M('addr');
			$arr = explode('||',I('post.district'));
			$rs = $addr -> add(array(
				'user_id' => $this -> user['id'],
				'name' => I('post.name'),
				'mobile' => I('post.mobile'),
				'provice' => $arr[0],
				'addr' => I('post.addr'),
				'district' => I('post.district'),
				'is_default'=>$_GET['is_default'],
			));
			if(!$rs){
				$this -> error('地址保存失败');
			}
			
			// 如果没有默认地址就设置为默认地址
			if($this -> user['default_addr'] == '0'){
				M('user') -> where('id='.$this -> user['id']) -> setField('default_addr', $rs);
			}
			
			// 如果是选择地址的时候添加地址则直接跳转回购物车页面,否则跳转到列表页
			if($_GET['act'] == 'select'){
				redirect(U('Index/cart?addr='.$rs));
				exit;
			}else{
				
				$this -> show("
					<script>
					layer.msg('地址添加成功');
					location.href='".U('addr')."';
					</script>
				");
				exit;
			}
		}
		
		$this -> display();
	}
	
	//删除地址
	public function delAddr(){
		$id = I('post.id');
		if(M('addr')->delete($id)){
			$this->success('删除成功!',U('My/addr',array('act'=>I('post.act'))));
		}else{
			$this->error('删除失败!');
		}
	}
	
	//设置默认地址
	public function default_addr(){
		$addr_id = I('id');
		if(!M('addr')->where(array('id'=>$addr_id))->find()){
			$this->error('没有该地址');
		}
		M('user')->where(array('id'=>$this->user['id']))->save(array('default_addr'=>$addr_id));
		M('addr')->where(array('id'=>$this->user['id'],'id'=>$addr_id))->save(array('is_default'=>1));
		M('addr')->where(array('id'=>$this->user['id'],'id'=>array('neq',$addr_id)))->save(array('is_default'=>0));
		if(I('post.act')){
			$this->success('设置成功!',U('Index/cart',array('act'=>I('post.act'),'addr'=>$addr_id)));
		}else{
			$this->success('设置成功!',U('My/addr'));
		}
	}
	
	
	//我的关注
	public function Favorite(){
		$this->display();
	}
	
	//获取我的关注
	public function getFavorite(){
		$page = I('post.page')?I('post.page'):1;
		$pagesize = 6;
		$start = ($page - 1)*$pagesize;
		$list = M('favorite')->where(array('user_id'=>$this->user['id'],'status'=>1))->order('create_time desc')->limit($start,$pagesize)->select();
		$this->assign('list',$list);
		$html = $this->fetch();
		if($page!=1 && !$list){
			$this->error($html);
		}else{
			$this->success($html);
		}
	}
	
	//我的订单
	public function order(){
		$this->display();
	}
	
	//获取我的订单
	public function getOrder(){
		$page = I('post.page')?I('post.page'):1;
		$status = I('post.stats')?I('post.stats'):0;
		if(!$order){
			$order = 'create_time desc';
		}
		if($status){
			$where['is_cancle'] = 0;
			$where['status'] = $status;
		}else{
			$where['status'] = array('gt',-2);
		}
		$where['user_id'] = $this->user['id'];
		$pagesize = 10;
		$start = ($page - 1)*$pagesize;
		$list = M('mch_order')->where($where)->order($order)->limit($start,$pagesize)->select();
		//$this->error(M()->getLastSql());
		if($list){
			foreach($list as $k=>$v){
				$list[$k]['cart'] = M('cart')->where(array('id'=>array('in',$v['cart_id']),'status'=>array('neq',-2)))->select(); 
			}
		}		
		$this->assign('list',$list);
		$this->assign('page',$page);
		$html = $this->fetch();
		if($page!=1 && !$list){
			$this->error($html);
		}else{
			$this->success($html);
		}
	}
	
	//订单详情 
	public function orderDetail(){
		$order_id = I('get.order_id');
		$order = M('mch_order')->find(intval($order_id));
		if(!$order || $order['status'] == -2){
			$this->error('没有该订单信息',U('My/order'));
		}
		$cart = M('cart')->where(array('id'=>array('in',$order['cart_id']),'status'=>array('neq',-2)))->select();
		$cart = $this->_get_list_logis(1,$cart,$order['addr_id']);
		foreach($cart as $v){
			$nums+=$v['nums'];
		}
		$order['cart'] = $cart;
		$addr = M('addr')->find(intval($order['addr_id']));
		$this->assign('addr',$addr);
		$this->assign('nums',$nums);
		$this->assign('info',$order);
		$this->display();
	}
	
	
	
	// 充值
	public function recharge(){
		$values = explode('|', $this -> _site['charge']);
		foreach($values as &$v){
			if(intval($v)<1){
				unset($v);
			}
		}
		$this -> assign('values', $values);
		$this -> display();
	}
	
	//充值提交
	public function doRecharge(){
		$money = I('post.money');
		if(!$money || $money<0.01){
			$this->error('充值金额错误,不能少于一块钱哟！');
		}
		$data = array(
			'sn' => date("ymdHi").mt_rand(100,999).$this -> user['id'],
			'user_id'=>$this->user['id'],
			'money'=>$money,
			'create_time'=>NOW_TIME,
		);
		$data['id'] = M('recharge')->add($data);
		if($data['id']){
			$jsapi = new \Common\Util\wxjspay;
			$param = $this -> _mp;
			$param['key'] = $this -> _mp['key'];
			$param['openid'] = $this -> user['openid'];
			$param['body'] = $this -> _site['name'].'在线支付';
			$param['out_trade_no'] = $data['sn'];
			$param['total_fee'] = $data['money'] * 100;
			$param['attach'] = json_encode(array(
					'user_id' => $this -> user['id'],
					'order_id'=>$data['id'],
					'type' => 2 // 充值金额
				));
			$param['notify_url'] = "http://".$_SERVER['HTTP_HOST'].__ROOT__.'/notify.php';
			$jsapi -> set_param($param);
			$uo = $jsapi -> unifiedOrder();
			if(!$uo){
				$this -> error($jsapi -> uoerror);
			}
			$jsapi_params = $jsapi -> get_jsApi_parameters();
			$this -> success($jsapi_params);
		}
	}
	
	//我的余额
	public function money(){
		$this->display();
	}
	
	//我的乐币
	public function points(){
		//已结算乐币/未结算乐币
		$this->assign('separate_done',M('separate_log')->where(array('user_id'=>$this->user['id'],'status'=>3))->sum('points'));
		$this->assign('separate_no',M('separate_log')->where(array('user_id'=>$this->user['id'],'status'=>array('in','0,2')))->sum('points'));
		$this->display();
	}
	
	
	//获取余额或积分的记录
	public function getRecord(){
		if(IS_POST){
			$type = I('post.type');
			if($type == 'points'){
				$where = '(type= "points" or type= "cx_points" ) and user_id='.$this->user['id'];
			}else{
				$where['type'] = $type;
				$where['user_id'] = $this->user['id'];
			}
			$page = I('post.page')?I('post.page'):1;
			$pagesize = 10;
			$start = ($page-1)*$pagesize;
			$list = M('finance_log')->where($where)->order('create_time desc')->limit($start,$pagesize)->select();
			
			$this->assign('list',$list);
			$this->assign('page',$page);
			$html = $this->fetch();
			if($page!=1 && !$list){
				$this->error($html);
			}else{
				$this->success($html);
			}			
		}else{
			$this->error('非法请求');
		}
	}
	
	//获取的分拥记录
	public function getSeparate(){
		if(IS_POST){
			$status = I('post.done');
			$page = I('post.page')?I('post.page'):1;
			$pagesize = 10;
			$start = ($page-1)*$pagesize;
			if($status == 3){
				$where['status'] = $status;
			}else{
				$where['status'] = array('in','0,2');
			}
			
			$where['user_id'] = $this->user['id'];
			$list = M('separate_log')->where($where)->order('create_time desc')->limit($start,$pagesize)->select();
			$sql = M()->getLastSql();
			$this->assign('status',$status);
			$this->assign('list',$list);
			$this->assign('page',$page);
			$html = $this->fetch();
			if($page!=1 && !$list){
				$this->error($html);
			}else{
				$this->success($html,$sql);
			}			
		}else{
			$this->error('非法请求');
		}
	}
	
	
	//修改资料
	public function profile(){
		if(IS_POST){			
			$post = I('post.');	
			if(M('user')->where(array('mobile'=>$post['mobile']))->find()){
				$this->error('手机号码已经被注册了');
			}
			M('user')->where(array('id'=>$this->user['id']))->save($post);
			$this->success('修改成功',U('index'));
			exit;
		}
		$this->display();
	}
	
	
	
	//我的团队
	public function team(){
		//我的下级人数
		for($i=1;$i<=3;$i++){
			$son[$i] = M('user')->where(array("parent{$i}"=>$this->user['id'],'sales'=>array('egt',$this->_site['valid'])))->count();
		}
		//所有下级
		$sons = getChildren($this->user['id']);
		foreach($sons as $k=>$v){
			$separate += $v['separate'];
			$tward += $v['tward'];
		}
		$separate = $separate+$this->user['separate'];
		$tward = $tward + $this->user['tward'];
		$this->assign('separate',$separate);
		$this->assign('tward',$tward);
		$this->assign('son',$son);
		$this->display();
	}
	
	public function getTeam(){
		if(IS_POST){
			$stats = I('post.stats');
			$page = I('post.page')?I('post.page'):1;
			$where['parent'.$stats] = $this->user['id'];
			$pagesize = 10;
			$start = ($page-1)*$pagesize;
			$list = M('user')->where($where)->order('id desc')->limit($start,$pagesize)->select();
			foreach($list as $k=>$v){
				$list[$k]['separate'] = M('separate_log')->where(array('self_id'=>$v['id'],'user_id'=>$this->user['id'],'status'=>3))->sum('points');
				$mp['parent1|parent2|parent3'] = $v['id'];
				$list[$k]['team'] = M('user')->where($mp)->count();
				if($v['sales']>=$this->_site['valid']){
					$list[$k]['isvalid'] = true;
				}
			}
			$this->assign('list',$list);
			$this->assign('page',$page);
			$html = $this->fetch();
			if($page!=1 && !$list){
				$this->error($html);
			}else{
				$this->success($html);
			}			
		}else{
			$this->error('非法请求');
		}
	}
	
	//支付商户订单页面
	public function pay(){
		$order_id = I('get.order_id');
		$order = M('mch_order')->find(intval($order_id));
		if(!$order || $order['status']!=1){
			$this->error('该订单不能进行支付');
		}	
		$this->assign('info',$order);
		$this->display();
	}
	
	public function dopay(){
		$order_id = I('post.order_id');
		$order = M('mch_order')->find(intval($order_id));
		if(!$order || $order['status']!=1){
			$this->error('该订单不能进行支付');
		}		
		$jsapi = new \Common\Util\wxjspay;
		$param = $this -> _mp;
		$param['key'] = $this -> _mp['key'];
		$param['openid'] = $this -> user['openid'];
		$param['body'] = $this -> _site['name'].'在线支付';
		$param['out_trade_no'] = $order['sn'];
		$param['total_fee'] = $order['wxpay'] * 100;
		$param['attach'] = json_encode(array(
				'order_id' => $order['orer_id'],
				'user_id' => $this -> user['id'],
				'type' => 1,
		));
		$param['notify_url'] = "http://".$_SERVER['HTTP_HOST'].__ROOT__.'/notify.php';
		$jsapi -> set_param($param);
		$uo = $jsapi -> unifiedOrder();
		$jsapi_params = $jsapi -> get_jsApi_parameters();
		$this->success($jsapi_params);
	}
	
	
	// 我的推广二维码
	public function qrcode(){
		$img = $this->get_qrcode();
		$this->assign('img',$img);
		$this -> display();
	}
	
	
	
	
	public function sync_profile(){
		$dd = new \Common\Util\ddwechat;
		$dd -> setParam($this -> _mp);
		$user_info = $dd -> getuserinfo($this -> user['openid']);
		if(!$user_info){
			$msg = APP_DEBUG ? $dd -> errmsg : '同步失败';
			$this -> error($msg);
		}
		
		M('user') -> save(array(
			'id' => $this -> user['id'],
			'nickname' => $user_info['nickname'],
			'sex' => $user_info['sex'],
			'headimg' => $user_info['headimgurl']
		));
		$this -> success('更新成功！');
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
}