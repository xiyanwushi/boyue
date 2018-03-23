<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends AdminController {
    // 商品列表
	public function index(){
		$user_id = I('post.user_id');
		$title = I('post.title');
		if(IS_POST){
			if($user_id){
				$where['user_id'] = $user_id;
			}
			elseif($title){
				$where['title']=array('like','%'.$title.'%') ;
			}
			$_GET['user_id'] = $user_id;
			if($_POST['feature']){
				$where['feature'] = array('like','%'.$_POST['feature'].'%');
				$_GET['feature'] = $_POST['feature'];
			}
			
		}
		$where['status'] = I('get.status');
		$this -> _list('product',$where, 'sort desc');
	}
	
	// 编辑、添加商品
	public function edit(){		
		$model = M('product');
		$id = intval($_GET['id']);
		if($id>0){
			$info = $model -> find($id);
			if(!$info)die('信息不存在');
			$bar = explode('|',$info['banner']);
			foreach($bar as $k=>$v){
				$banner[$k+1] = $v;
			}
			$info['user'] = M('user')->find(intval($info['user_id']));
			$info['banner'] = $banner;
			$info['feature'] = explode(',',$info['feature']);
			$this -> assign('info', $info);
		}
		if(IS_POST){
			for($i=1;$i<6;$i++){
				if($_POST['pic'.$i]){
					$array[] = $_POST['pic'.$i];
				}
			}	
			$_POST['banner'] = implode('|',$array);
			$_POST['feature'] = implode(',',$_POST['feature']);
			if($id>0){
				$_POST['id'] = $id;
				$model -> save($_POST);
				$this -> success('操作成功！', U('index',array('status'=>1)));
				exit;
			}else{
				$model -> add($_POST);
				$this -> success('添加成功！', U('index',array('status'=>1)));
				exit;
			}
		}
		// 查询分类信息
		$cates = M('product_cate')->where(array('pid'=>0)) -> select();
		$this -> assign('cates', $cates);
		//轮播图信息
		
		$this -> display();
		
	}
	
	// 根据分类获得子分类
	public function get_child_cates(){
		$pid = intval($_REQUEST['id']);
		$cates = M('product_cate') -> where(array('pid' => $pid)) -> select();
		$data = array();
		foreach($cates as $cate){
			$data[$cate['id']] = array('name' => $cate['name']);
		}
		$this -> ajaxReturn($data);
	}
	
	
	// 删除商品
	public function del(){
		$this -> _del('product', $_GET['id']);
		// 删除相关的属性
		M('product_attr') -> where(array('product_id'=>intval($_GET['id']))) -> delete();
		$this -> success('操作成功！', $_SERVER['HTTP_REFERER']);
	}
	
	/***以下是分类管理***/
	
	// 列表
	public function cate(){
		if($_GET['pid']){
			$where['pid'] = intval($_GET['pid']);
		}
		else{
			$where['pid'] = 0;
		}		
		$list = M('product_cate') -> order('sort desc') -> where($where) -> select();
		
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 编辑
	public function cate_edit(){
		if($_GET['pid']){
			// 检查pid是否有效
			$where = array('id' => intval($_GET['pid']));
			$find = M('product_cate') -> where($where) -> find();
			if(!$find){
				$this -> error('访问错误');
			}
			$_POST['pid'] = $_GET['pid'];
		}
		
		$this -> _edit('product_cate',U('cate?pid='.$_GET['pid']));
	}
	
	// 删除
	public function cate_del(){
		$this -> _del('product_cate', $_GET['id']);
		$this -> success('操作成功！', U('cate'));
	}
	
	
	//商品审核
	public function audit(){		
		$id = I('get.id');
		$info = M('product')->find(intval($id));
		if(!$info || $info['status']!=0){
			$this->error('商品信息错误');
		}
		if(IS_POST){
			$status = I('post.status');
			$reson = I('post.reson');
			M('product')->where(array('id'=>$id))->save(array('status'=>$status,'reson'=>$reson));
			$this->success('审核成功',U('Product/index',array('status'=>0)));
			exit;
		}
		
		$bar = explode('|',$info['banner']);
		foreach($bar as $k=>$v){
			$banner[$k+1] = $v;
		}
		$info['banner'] = $banner;
		$info['feature'] = explode(',',$info['feature']);
		
		$this->assign('info',$info);
		$this->display();
	}
	
	public function test(){
		confirm_order(62);
	}
}