<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends AdminController {
    // 通知列表
	public function index(){
		if(IS_POST){
			$_GET = $_REQUEST;
		}
		if(!empty($_GET['id'])){
			$where['id'] = intval($_GET['id']);
		}
		if(!empty($_GET['level'])){
			$where['level'] = intval($_GET['level']);
		}
		if($_GET['reset']!=''){
			$where['reset'] = intval($_GET['reset']);
		}
		
		if(!empty($_GET['parent1'])){
			$where['parent1'] = intval($_GET['parent1']);
		}
		if(!empty($_GET['parent2'])){
			$where['parent2'] = intval($_GET['parent2']);
		}
		if(!empty($_GET['parent3'])){
			$where['parent3'] = intval($_GET['parent3']);
		}
		
		
		// 组合排序方式
		if(in_array($_GET['order'], array('id','points', 'agent1','agent2','agent3','sub_time'))){
			$type = $_GET['type'] == 'asc' ? 'asc' : 'desc';
			$order = $_GET['order'].' '.$type;
		}
		$this -> _list('user', $where, $order);
	}
	
	// 用户详细信息
	public function detail(){
		$id = intval($_GET['id']);
		$info = M('user') -> find($id);
		$this -> assign('info', $info);
		
		// 查询上级信息
		if($info['parent1']){
			$this -> assign('parent', M('user') -> find($info['parent1']));
		}		
		// 查询分成总额
		$separate_points = M('separate_log') -> where(array('user_id'=>$info['id'],'status'=>3)) -> sum('points');
		$this -> assign('separate_points', $separate_points);
		$this -> display();
	}
	
	
	//设置金额
	public function setMoney(){
		$post = I('post.');
		M('user')->where(array('id'=>$post['user_id']))->save(array(
			'money' => array('exp', 'money+'.$post['money']),
		));
		$this->success('充值成功');
	}
	
	//设置积分
	public function setPoints(){
		$post = I('post.');
		M('user')->where(array('id'=>$post['user_id']))->save(array(
			'points' => array('exp', 'points+'.$post['points']),
		));
		$this->success('充值成功');
	}
	
	//设置重销
	public function setcx_Points(){
		$post = I('post.');
		M('user')->where(array('id'=>$post['user_id']))->save(array(
			'cx_points' => array('exp', 'cx_points+'.$post['cx_points']),
		));
		$this->success('充值成功');
	}
	// 赠送分红
	public function reward(){
		$user_id = intval($_POST['user_id']);
		$money = floatval($_POST['money']);
		$type = intval($_POST['type']);
		
		if($user_id < 1 || $money <=0 ){
			$this -> error('操作错误');
		}
		
		$data = array(
			'expense_avail' => array('exp', 'expense_avail+'.$money)
		);
		if($type==1){
			$data['reward'] = array('exp', 'reward+'.$money);
			$tips = "绩效分红";
		}else{
			$data['reward_global'] = array('exp', 'reward_global+'.$money);
			$tips = "全球分红";
		}
		$rs = M('user') -> where('id='.$user_id) -> save($data);
		flog($user_id, 'expense', $money, $tips); // 财务记录
		
		if($rs){
			$this -> success('操作成功！');
			exit;
		}
	}
	
	// 校准下级代理数
	public function correct_agent(){
		$user_id = intval($_GET['id']);
		$agent1 = M('user') -> where('parent1='.$user_id) -> count();
		$agent2 = M('user') -> where('parent2='.$user_id) -> count();
		$agent3 = M('user') -> where('parent3='.$user_id) -> count();
		M('user') -> where('id='.$user_id) -> save(array(
			'agent1' => $agent1,
			'agent2' => $agent2,
			'agent3' => $agent3
		));
		
		$this -> success('操作成功！', $_SERVER['HTTP_REFERER']);
	}
	
	//更改用户上级
	public function editParent(){
		$user_id = I('post.user_id');
		$parent = I('post.parent');
		EditParent($user_id,$parent);
		$this->success('修改成功');
	}
}