<?php
namespace Admin\Controller;
use Think\Controller;
class RewardController extends AdminController {
    // 记录列表
	public function index(){
		$this -> assign('level', get_level_name_arr($this -> _level));
		$this -> _list('reward');
	}
	
	// 编辑、添加
	public function edit(){		
		$config = $this->_reward_setting;		
		$user = M('user')->where(array('parent1'=>0))->select();
		$list = array();
		if($user){
			foreach($config as $k=>$v){
				$child = array();
				foreach($user as $key=>$val){
					if( ($val['separate']+$val['tward']) > $v['min'] ){
						$val['lv'] = $v['lv'];
						$val['reward'] = $k;
						$money_count = ($val['separate'] + $val['tward'])*$v['lv']/100;
						$child = $this->getChildren($val['id']);						
						if($child){
							foreach($child as $c=>$d){
								if( ($d['separate']+$d['tward']) < $v['min'] ){
									unset($child[$c]);
								}
							}
						}
						$nums = count($child);
						foreach($child as $a=>$b){
							$b['reward'] = $k;
							$b['lv'] = $v['lv'];
							$b['total'] = $money_count;
							$b['reward_money'] =  sprintf("%.2f",$money_count/$nums);
							$list[] = $b;
						}
					}
				}
			}
		}
	
		if(IS_POST){
			if(empty($list)){
				$this->error('没有可发放的用户');
				exit;
			}
			foreach($list as $k=>$v){
				$money = ($v['separate']+$v['tward'])*$v['lv']/100;
				$data = array(
					'user_id'=>$v['id'],
					'level'=>$v['reward'],
					'total'=>$v['total'],
					'money'=>$v['reward_money'],
					'create_time'=>time(),
				);
				M('reward')->add($data);
				M('user')->where(array('id'=>$v[id]))->save(array(
					'points' => array('exp', 'points+'.$money),
				));
				flog($v['id'],'points',"+".$money,13);
				//清空所有人的团队奖励和分销奖励
				M('user')->where('1=1')->save(array(
					'separate'=>0,
					'tward'=>0,
				));
			}
			$this->success('发放成功',U('index'));
			exit;
		}
		
		$this->assign('list',$list);
		$this -> display();
	}
	
	//查询上级的所有下级人数
	//config为tward_setting的单个数组
	public function getChildren($pid,&$data = array()){
		if(!$pid){
			return $data;
		}
		$parent = M('user')->find($pid);
		$data[] = $parent;
		$user = M('user')->where(array('parent1'=>$pid))->select();
		if($user){
			foreach($user as $v){
				$this->getChildren($v['id'],$data);
			}
		}		
		return $data;
	}
	
	
	public function reward_setting(){
		if(IS_POST){
			$config = array();
			foreach($_POST['min'] as $key => $val){
				if(empty($val) && $val !=0){
					continue;
				}else{
					empty($_POST['lv'][$key]) && $_POST['lv'][$key] = 0;
				}
				
				$config[] = array(
					'min' => $val,
					'lv' => $_POST['lv'][$key],
				);
			}
			unset($_POST);
			$_POST = $config;
			// 有此配置则更新,没有则新增
			if(array_key_exists(ACTION_NAME, $this -> _CFG)){
				M('config') -> where(array('name' => ACTION_NAME)) -> save(array(
					'value' => serialize($_POST)
				));
			}else{
				M('config') -> add(array(
					'name' => ACTION_NAME,
					'value' => serialize($_POST)
				));
			}
			$this -> success('操作成功！');
			exit;
		}

		$this->display();
	}
	
	
	// 删除
	public function del(){
		$this -> _del('notice', intval($_GET['id']));
		$this -> success('操作成功！', $_SERVER['HTTP_REFERER']);
	}
	
	// 获取用户数量
	public function get_user_count(){
		$level = intval($_POST['level']);
		$count = M('user') -> where(array('level' => $level)) -> count();
		$this -> ajaxReturn(array(
			'nums' => $count
		));
	}
}