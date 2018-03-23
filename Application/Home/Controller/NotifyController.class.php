<?php
namespace Home\Controller;
use Think\Controller;
class NotifyController extends Controller {
	public function _initialize(){
		// 加载配置
		$config = M('config') -> select();
		if(!is_array($config)){
			die('请先在后台设置好各参数');
		}
		foreach($config as $v){
			$key = '_'.$v['name'];
			$this -> $key = unserialize($v['value']);
			$_CFG[$v['name']] = $this -> $key;
		}
		$GLOBALS['_CFG'] = $_CFG;
	}
    
	// 支付通知异步页面
	public function index(){
		$jsapi = new \Common\Util\wxjspay;
		$jsapi -> set_param('key', $this -> _mp['key']);		
		// 验证签名之前必须调用get_notify_data方法获取数据
		$data = $jsapi -> get_notify_data();
		if(!$jsapi->check_sign()){
			// 签名验证失败
			die('FAIL');
		}		
		if($data['return_code'] != 'SUCCESS' || $data['result_code'] != 'SUCCESS'){
			die('FAIL');
		}	
		$attach = json_decode($data['attach'], 1);		
		$order_id = intval($attach['order_id']);
		$type = $attach['type'];	
		// 查询此支付是否已处理
		if(M('pay_log') -> where(array('transaction_id' => $data['transaction_id'])) -> find()){
			die('SUCCESS');
		}else{
			$data['log_time'] = NOW_TIME;
			// 记录支付日志
			M('pay_log') -> add($data);
		}		
		// 获取用户信息，异步通知不执行网页认证授权，需要获取用户信息
		$this -> user = M('user') -> find(intval($attach['user_id']));
		if(!$this -> user){
			die('Fail');
		}			
		// 购物订单支付
		if($type == 1){
			$order = M('order') -> find(intval($order_id));
			
			if($order['status'] !=1){
				die('FAIL');
			}
			$paid_fee =  $data['total_fee']/100;	
			// 已支付全部费用
			if($paid_fee >= $order['wxpay']){
				$save['status'] = 2;
				$save['pay_time'] = NOW_TIME;
				$mch_order = M('mch_order')->where(array('order_id'=>$order_id))->find();
				file_put_contents('a.txt',var_export($mch_order,1),FILE_APPEND);
				// 更新分成状态为待确认
				M('separate_log') -> where(array('order_id'=>$mch_order['id'],'status'=>array('gt',0))) -> setField('status', 2);	
				file_put_contents('a.txt',M()->getLastSql(),FILE_APPEND);
				M('order') -> where(array('id'=>$order_id)) -> save($save);
				M('mch_order') -> where(array('order_id'=>$order_id)) -> save($save);
				M('cart') -> where(array('order_id'=>$order_id)) -> save(array('status'=>2));
				die('SUCCESS');				
			}
			
		}
		// 在线充值支付
		elseif($type == 2){
			M('user') -> where('id='.$attach['user_id']) -> save(array('money' => $this -> user['money'] + $data['total_fee']/100));
			M('recharge')->where(array('id'=>$order_id))->save(array('pay_time'=>time(),'status'=>2));
			flog($this -> user['id'],'money',"+".$data['total_fee']/100, 10); // 记录财务日志
			die('SUCCESS');
		}
		else{
			die('SUCCESS');
		}	
	}// index
}