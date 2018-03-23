<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends HomeController {
	// 商城首页
    public function index(){
		$feature = $this->_feature['config'];
		foreach($feature as $k=>$v){
			$sql = "SELECT * FROM dd_product WHERE status=1 and  find_in_set(".$k.",feature) order by sort desc";
			$list = M()->query($sql);
			if(!$list){
				unset($feature[$k]);
			}else{
				$feature[$k]['list'] = $list;	
			}
		}
		$this->assign('feature',$feature);
		//查询ad广告位
		$this->assign('ad1',M('ad')->where(array('ad'=>1))->find());
		$this->assign('ad23',M('ad')->where(array('ad'=>array('in',array(2,3))))->select());
		$this->assign('ad46',M('ad')->where(array('ad'=>array('in',array(4,5,6))))->select());
		
    	$this -> display();
    }
	
	
	//商城分类
	public function cates(){
		$cates = M('product_cate')->order('sort desc')->select();
		$cates = list_to_tree($cates);
		
		$this->assign('cates',$cates);
		$this->display();
	}
	
	//商品详情
	public function product(){
		$id = I('get.id');
		$info = M('product')->find(intval($id));
		if(!$info){
			$this->error('没有该商品信息');
		}
		$info['banner'] = explode('|',$info['banner']);
		if($info['user_id']){
			$this->assign('userp',M('user')->find(intval($info['user_id'])));
		}
		$info['user'] = M('user')->find(intval($info['user_id']));
		//总评论数
		$count = M('assess')->where(array('product_id'=>$info['id']))->count();
		$this->assign('assess_count', ceil($count/10));
		//是否关注
		$this->assign('favorite',M('favorite')->where(array('user_id'=>$this->user['id'],'product_id'=>$id,'status'=>1))->find());
		//购物车数量
		$this->assign('cartNums',M('cart')->where(array('user_id'=>$this->user['id'],'order_id'=>0))->sum('nums'));
		$this->assign('qrcode',getqrcode($this->user));
		
		$this->assign('info',$info);
		$this->display();
	}
	
	//购物车
	public function cart(){
			
		//dump(isValid(1761501,1));
		//购物车数据
		$list = M('cart')->where(array('user_id'=>$this->user['id'],'order_id'=>0))->select();
		
		//推荐数据
		if($this->_site['sendProduct'] && $list){
			foreach($list as $v){
				$ids[] = $v['id'];
			}
			$where['id'] = array('not in',implode(',',$ids));
		}
		$send = M('product')->where($where)->order('rand()')->limit($this->_site['sendProduct'])->select();	
		$this->assign('send',$send);
		//查询默认地址
		$addr = M('addr')->where(array('user_id'=>$this->user['id'],'is_default'=>1))->find();
		if(I('get.addr') && I('get.addr')>0){
			$addr = M('addr')->where(array('id'=>I('get.addr')))->find();
		}
	
		$list = $this->_get_list_logis(1,$list,$addr['id']);
		$this->assign('list',$list);
		$this->assign('addr',$addr);
		$this->display();
	}
	
	//订单
	public function order(){
		$addr_id = I('get.addr');
		$cids = I('get.cids');
		$where['id'] = array('in',$cids);
		$where['order_id'] = 0;
		$cart = M('cart')->where($where)->select();
		if(!$cart || empty($cart)){
			$this->error('购物车商品以被创建订单了');
		}
		$addr = M('addr')->find(intval($addr_id));
		if(!$cart || empty($cart)){
			$this->error('收货地址错误');
		}
		$total = 0;
		foreach($cart as $v){
			if($v['is_zq'] == 1){
				$points += $v['nums'] * $v['zq_points'];
			}else{
				$total += $v['nums'] * $v['price'];
				$points += $v['nums'] * $v['points'];
			}
			$nums +=$v['nums'];
		}
		$logis_fee = $this->_get_list_logis(2,$cart,$addr_id);
		$cart = $this->_get_list_logis(1,$cart,$addr_id);
		
		//重新查询下自身的数据，不能读取缓存中的余额等信息
		$users = M('user')->find(intval($this->user['id']));
		
		$this->assign('users',$users);
		$this->assign('list',$cart);
		$this->assign('logis_fee',$logis_fee);
		$this->assign('nums',$nums);
		$this->assign('total',$total);
		$this->assign('points',$points);
		$this->assign('addr',$addr);
		$this->display();
	}
	
	
	public function orderDetail(){
		$order_id = I('get.order_id');
		$order = M('order')->find(intval($order_id));
		if(!$order || $order['status'] == -2){
			$this->error('没有该订单信息');
		}
		$cart = M('cart')->where(array('order_id'=>$order_id,'status'=>array('neq',-2)))->select();
		$cart = $this->_get_list_logis(1,$cart,$order['addr_id']);
		foreach($cart as $v){
			$nums+=$v['nums'];
		}
		$order['cart'] = $cart;
		$addr = M('addr')->find(intval($order['addr_id']));
		$this->assign('addr',$addr);
		$this->assign('nums',$nums);
		$this->assign('info',$order);
		$this->display();
	}
	
	//支付订单页面
	public function pay(){
		$order_id = I('get.order_id');
		$order = M('order')->find(intval($order_id));
		if(!$order || $order['status']!=1){
			$this->error('该订单不能进行支付');
		}	
		$this->assign('info',$order);
		$this->display();
	}
	
	//
	
	
	//所有商品
	public function all(){
		$order = I('get.order');
		$this->assign('order',$order);
		$this->display();
	}
	
	//获取商品
	public function getAll(){
		$page = I('post.page')?I('post.page'):1;
		$order = I('post.order');
		$type = I('post.type')? I('post.type'):'desc';
		$cate_id = I('post.cate_id');
		$feature = I('post.feature');
		$keyword = I('post.keyword');
		if($order){
			$order = $order.' '.$type;
		}else{
			$order = "sold desc";
		}
		if($cate_id){
			$where['cate_id|p_cate_id'] = $cate_id;
		}
		if($keyword){
			$where['title'] = array('like','%'.$keyword.'%');
		}
		$where['status'] = 1;
		$pagesize = 100;
		$start = ($page - 1)*$pagesize;
		if($feature){
			$sql = "SELECT * FROM dd_product WHERE status = 1 and find_in_set(".$feature.",feature) limit ".$start.",".$pagesize;	
			$list = M()->query($sql); 
		}else{
			$list = M('product')->where($where)->order($order)->limit($start,$pagesize)->select();
		}
		$this->assign('list',$list);
		$html = $this->fetch();
		if($page!=1 && !$list){
			$this->error($html);
		}else{
			$this->success($html);
		}
	}
	
	
	
	
	
	
}?>