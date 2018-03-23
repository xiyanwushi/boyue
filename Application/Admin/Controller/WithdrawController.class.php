<?php
namespace Admin\Controller;
use Think\Controller;
class WithdrawController extends AdminController {
    // 列表
	public function index(){
		if(IS_POST){
			$_GET = $_REQUEST;
		}
		
		if(!empty($_GET['status'])){
			$where['status'] = intval($_GET['status']);
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
		
		$list = $this -> _get_list('withdraw', $where);
		
		// 银行转账才需要显示银行卡信息
		if($this -> _site['withdraw'] == 1){
			foreach($list as &$v){
				$v['bank'] = unserialize($v['bank']);
			}
		}

		$this -> assign('list', $list);
		$this -> assign('page', $this -> data['page']);
		$this -> display();
	}
	
	// 拒绝
	public function refuse(){
		$id = intval($_GET['id']);
		$info = M('withdraw') -> find($id);
		if($info['status'] !=1){
			$this -> error('不能进行该操作');
		}
		M('withdraw') -> where('id='.$id) -> save(array(
			'status' => -1,
			'confirm_time' => NOW_TIME
		));
		
		// 拒绝后需要把余额退回到账户
		//若是积分则退回积分
		if($info['type'] == 1){
			M('user') -> where('id='.$info['user_id']) -> save(array(
				'money' => array('exp', 'money+'.$info['total'])
			));
			flog($info['user_id'],'money',"+".$info['total'], 9); // 记录财务日志
		}else{
			M('user') -> where('id='.$info['user_id']) -> save(array(
				'points' => array('exp', 'points+'.$info['total'])
			));
			flog($info['user_id'],'points',"+".$info['total'], 9); // 记录财务日志
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	// 审核
	public function audit(){
		$id = intval($_GET['id']);
		$info = M('withdraw') -> find($id);
		if($info['status'] !=1){
			$this -> error('不能进行该操作');
		}
		M('withdraw') -> where('id='.$id) -> save(array(
			'status' => 2,
			'audit_time' => NOW_TIME
		));
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	// 确认完成
	public function confirm(){
		$id = intval($_GET['id']);
		$info = M('withdraw') -> find($id);
		if($info['status'] !=2){
			$this -> error('不能进行该操作');
		}
		M('withdraw') -> where('id='.$id) -> save(array(
			'status' => 3,
			'confirm_time' => NOW_TIME
		));
		$withdraw = M('withdraw') -> where('id='.$id)->find();
		//若是积分，则加入重销积分
		if($info['type'] ==2){
			//增加重销积分，根据进入重销积分的百分比
			$cx_points = $this->_withdraw['points_cx_lv']*$info['total']/100;
			M('user')->where(array('id'=>$withdraw['user_id']))->setInc('cx_points',$cx_points);
			flog($info['user_id'],'cx_points',"+".$cx_points,14);
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}