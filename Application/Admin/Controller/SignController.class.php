<?php
namespace Admin\Controller;
use Think\Controller;
class SignController extends AdminController {
    // 通知列表
	public function index(){
		$this -> _list('user',array('ismch'=>array('neq',0)));
	}
	
	public function audio(){
		$ismch = I('get.ismch');
		$id = I('get.id');
		M('user')->where(array('id'=>$id))->save(array('ismch'=>$ismch));
		$this->success('操作成功');
	}
}