<?php
namespace Admin\Controller;
use Think\Controller;
class OrderController extends AdminController {
    // 通知列表
	public function index(){
		$where = $this -> _get_where();
		$where_paid = $where;
		$where_paid['status'] = array('gt',1);// array_merge(array('status' => ),$where);
		//var_dump($where_paid);
		if($_GET['mch'] == 0){
			$where['mch_id'] = 0;
		}elseif($_GET['mch'] == 1){
			$where['mch_id'] = array('gt',1);
		}
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
		$model = M('mch_order');
		$count = $model -> where($where) -> count();
		$page = new \Think\Page($count, 25);
		if(!$order){
			$order = "id desc";
		}
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order($order) -> select();
		foreach($list as $k=>$v){
			$cart = M('cart')->where(array('id'=>array('in',$v['cart_id'])))->select();
			foreach($cart as $key=>$val){
				$list[$k]['product'][] = M('product')->find(intval($val['product_id']));
			}
		}
		$this->assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
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
		if(!empty($_GET['sn'])){
			$where['sn'] = array('like','%'.$_GET['sn'].'%');
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
		//
		M('order')->where(array('id'=>$order_info['order_id'],'status'=>2))->save(array(
			'delivery_time' => NOW_TIME, //发货时间
			'status' => 3 // 已发货状态
		));
		$this->success('发货成功');
	}
	
	//取消单个商品
	public function cancleOne(){
		$cart_id = I('get.cart_id');
		$order_id = I('get.order_id');
		if($_GET['jujue'] && $_GET['jujue']==1){
			$order = M('mch_order')->find(intval($order_id));
			$porder = M('order')->find(intval($order['order_id']));
			M('cart')->where(array('id'=>$cart_id))->save(array('status'=>$porder['status']));
			$count = M('cart')->where(array('id'=>$cart_id))->count();
			if($count == 1){
				M('mch_order')->where(array('id'=>$order_id))->save(array('status'=>$porder['status']));
			}
			$this->success('拒绝成功!!');
		}else{
			cancleOneCart($cart_id,$order_id,true);
			$this->success('取消单个商品成功!');
		}
		
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
		if($order['wxpay']>0){
			$data['money'] = array('exp','money+'.$order['wxpay']);
			flog($order['user_id'],'money', "+".$order['wxpay'],6);
		}
		
		if(count($data) > 0){
			M('user') -> where(array('id'=>$order['user_id'])) -> save($data);
		}
		
		$this -> success('操作成功！');
	}
	
	// 删除
	public function del(){
		$order_id = intval($_GET['id']);
		$order_info = M('order') -> find($order_id);
		if($order_info['status'] != -1){
			$this -> error('只有已关闭的订单才能删除');
		}
		
		// 删除订单
		M('order') -> delete($order_id);
		// 删除订单商品
		M('order_product') -> where(array('order_id' => $order_id)) -> delete();
		// 删除相关分成记录
		M('separate_log') -> where(array('order_id' => $order_id)) -> delete();
		
		$this -> success('订单删除成功', $_SERVER['HTTP_REDERER']);
	}
}