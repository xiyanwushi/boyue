<?php
namespace Home\Controller;
use Think\Controller;
class PointsController extends HomeController {
    public function index(){
		$list = M('product')->where(array('is_points'=>1))->order('sort desc')->select();
		//dump($list);
		$this->assign('list',$list);
		$this->display();
    }
	
	
	
}