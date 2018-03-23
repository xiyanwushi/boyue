<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		// 入口，已登录调到首页，未登录跳转到登陆
		if(session('?admin'))
			redirect(U('Admin/welcome'));
		else
			redirect(U('Index/login'));
    }
	
	//登录
	public function login(){
		if(IS_POST){
			if(empty($_POST['name']) || empty($_POST['pass'])){
				$this -> assign('errmsg', '账号密码不能为空');
			}else{
				$find = M('admin') -> where(array(
					'name' => $_POST['name'],
					'pass' => xmd5($_POST['pass'])
				)) -> find();
				
				
				
				if(!$find){
					$this -> error('帐号或者密码错误');
				}
				
				if($find['status'] == '0'){
					$this -> error('你的帐号正在审核，请耐心等待');
				}
				elseif($find['status'] == '-1'){
					$this -> error('您的帐号已被禁用，请联系客服');
				}
				
				session('admin', $find);
				
				if(isset($_POST['remember'])){
					cookie('admin_user', $_POST['name']);
				}
						
				redirect(U('Admin/welcome'));
				exit;
			}
		}
		$this -> display();	
	}
	
	//  退出
	public function logout(){
		session('admin',null);
		redirect(U('login'));		
	}
	
}