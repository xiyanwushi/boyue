<?php
namespace Admin\Controller;
use Think\Controller;
class FinanceController extends AdminController {
	
	// 给用户付款
	public function pay(){
		$user_id = intval($_GET['user_id']);
		$user_info = M('user') -> find($user_id);		
		$wid = I('get.wid');
		$withdraw = M('withdraw')->where(array('id'=>$wid))->find();
		if(IS_POST){
			$order_id = $user_id.time();
			$data = array(
				'order_id' => $order_id,
				'user_id' => $user_id,
				'openid' => $user_info['openid'],
				'nickname' => $user_info['nickname'],
				'money' => intval($_POST['money']*100),
				'remark' => $_POST['remark'],
				'status' => 1,
				'op' => session('admin'),
				'create_time' => NOW_TIME
			);

			$id = M('mch_pay') -> add($data);
			if(!$id){
				$this -> error('支付失败！');
			}
			
			$param = array(
				'mch_appid' => $this -> _mp['appid'],
				'mchid' => $this -> _mp['mch_id'],
				'partner_trade_no' => $order_id,
				'openid' => $user_info['openid'],
				'check_name' => 'NO_CHECK', // 不验证名字
				//'re_user_name' => '',
				'amount' => intval($_POST['money']*100), // 金额，分
				'desc' => $_POST['remark'],
			);
			
			$dd = new \Common\Util\ddwechat;
			$dd -> setParam($this -> _mp);
			$ssl = array(
					'sslcert' => $_SERVER['DOCUMENT_ROOT'] .__ROOT__. $this -> _mp['cert'].'apiclient_cert.pem',
					'sslkey'  => $_SERVER['DOCUMENT_ROOT'] .__ROOT__. $this -> _mp['cert'].'apiclient_key.pem',
				);
			$rt = $dd -> mch_pay($param, $ssl);
			if($rt['return_code'] == 'SUCCESS' && $rt['result_code'] == 'SUCCESS'){
				M('mch_pay') -> where('id='.$id) -> save(array(
					'status' => 2,
					'payment_no' => $rt['payment_no'],
					'msg' => '支付成功'
				));
				M('withdraw')->where(array('id'=>$wid))->save(array('status'=>3));
				
				//积分提现返重销积分
				if($withdraw['type'] == 2){
					$lv = $this->_withdraw['points_cx_lv'];
					if($lv>0){
						$cx_points = $withdraw['total'] * $lv /100;
						M('user')->where(array('id'=>$withdraw['user_id']))->setInc('cx_points',$cx_points);
						flog($withdraw['user_id'], 'cx_points', "+".$cx_points,14);
					}
				}
				
				$this -> success('支付成功！',U('Withdraw/index'));
				exit;
			}
			else{
				M('mch_pay') -> where('id='.$id) -> save(array(
					'status' => -1,
					'msg' => $rt['err_code'].$rt['err_code_des']
				));
				
				$this -> error('支付失败:'.$rt['err_code_des'],U('Withdraw/index'));
			}
		}
		
		$this -> assign('user_info', $user_info);
		$this -> display();
	}
	
	// 转币记录
	public function deposit_log(){
		if(IS_POST){
			$_GET = $_REQUEST;
		}
		
		
		if(!empty($_GET['deposit_user'])){
			$where['deposit_user'] = intval($_GET['deposit_user']);
		}
		if(!empty($_GET['accept_user'])){
			$where['accept_user'] = intval($_GET['accept_user']);
		}
		if(!empty($_GET['time1']) && !empty($_GET['time2'])){
			$where['create_time'] = array(
				array('gt', strtotime($_GET['time1'])),
				array('lt', strtotime($_GET['time2'])+86400)
			);
		}elseif(!empty($_GET['time1'])){
			$where['create_time'] = array('gt', strtotime($_GET['time1']));
		}elseif(!empty($_GET['time2'])){
			$where['create_time'] = array('lt', strtotime($_GET['time2'])+86400);
		}
		$this -> _list('sk_points', $where);
	}
	
	// 分成记录
	public function separate_log(){
		$type = I('get.type');
		if(IS_POST){
			$_GET = $_REQUEST;
		}
		if(!empty($_GET['status'])){
			$where['status'] = intval($_GET['status']);
		}
		if(!empty($_GET['user_id'])){
			$where['user_id'] = intval($_GET['user_id']);
		}
		if(!empty($_GET['self_id'])){
			$where['self_id'] = intval($_GET['self_id']);
		}
		if(!empty($_GET['order_id'])){
			$where['order_id'] = intval($_GET['order_id']);
		}
		if(!empty($_GET['order_sn'])){
			$where['order_sn'] = $_GET['order_sn'];
		}
		if(!empty($_GET['level'])){
			$where['level'] = intval($_GET['level']);
		}
		$where['type'] = $type;
		if(!empty($_GET['time1']) && !empty($_GET['time2'])){
			$where['create_time'] = array(
				array('gt', strtotime($_GET['time1'])),
				array('lt', strtotime($_GET['time2'])+86400)
			);
		}elseif(!empty($_GET['time1'])){
			$where['create_time'] = array('gt', strtotime($_GET['time1']));
		}elseif(!empty($_GET['time2'])){
			$where['create_time'] = array('lt', strtotime($_GET['time2'])+86400);
		}
		$this -> _list('separate_log', $where);
	}
	
	// 帐户变动记录
	public function finance_log(){
		if(IS_POST){
			$_GET = $_REQUEST;
		}
		if(!empty($_GET['action'])){
			$where['action'] = intval($_GET['action']);
		}
		if(!empty($_GET['user_id'])){
			$where['user_id'] = intval($_GET['user_id']);
		}
		if(!empty($_GET['type'])){
			$where['type'] = $_GET['type'];
		}
		
		if(!empty($_GET['time1']) && !empty($_GET['time2'])){
			$where['create_time'] = array(
				array('gt', strtotime($_GET['time1'])),
				array('lt', strtotime($_GET['time2'])+86400)
			);
		}elseif(!empty($_GET['time1'])){
			$where['create_time'] = array('gt', strtotime($_GET['time1']));
		}elseif(!empty($_GET['time2'])){
			$where['create_time'] = array('lt', strtotime($_GET['time2'])+86400);
		}
		$this -> _list('finance_log', $where);
	}
	
	
	
}