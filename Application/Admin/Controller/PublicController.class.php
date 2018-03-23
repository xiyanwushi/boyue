<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
	
	
	public function login(){
		$url = 'http://'.$_SERVER['SERVER_NAME'].'/index.php?m=Home&c=Mch&a=mch_login&rand='.session_id();
		$url = complete_url($url);
		$this->assign('url',$url);
		$this -> display();
	}
	
	public function login_ajax(){
		$info = M('mch_login') -> where(array(
			'session_id' => 'dv6hkkmov5qvtub5ee70o1a7k1',
			'status'=>1,
		)) -> find();
		$user = M('user')->find(intval($info['user_id']));
		if($info){
			if($user['ismch']!= 2){
				$this->error('您还不是商户，不能登录商户后台');
			}else{
				session('mch',M('user') -> find($info['user_id']));
				$this -> success('ok');
			}
		}
		else{
			$this -> error('登录失败');
		}
	}
	
	
   
}?>