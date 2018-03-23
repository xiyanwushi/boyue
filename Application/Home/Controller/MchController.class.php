<?php
namespace Home\Controller;
use Think\Controller;
class MchController extends HomeController {
	public function _initialize(){
		parent::_initialize();
		if($this->user['level']<1){
			$this->error('您还不是代理！');
		}
	}
    public function index(){
		//预收佣金
		$this->assign('points',M('separate_log')->where(array('user_id'=>$this->user['id'],'status'=>3))->sum('points'));		
		$this->assign('yj_points',M('separate_log')->where(array('user_id'=>$this->user['id'],'status'=>0))->sum('points'));
		
		$this->assign('points1',M('separate_log')->where('(status=0 or status =3) and type=1 and user_id='.$this->user['id'])->sum('points'));
		$this->assign('points2',M('separate_log')->where('(status=0 or status =3) and type=2 and user_id='.$this->user['id'])->sum('points'));
		
		$son = getChildren($this->user['id']);
		$i = 0;
		foreach($son as $v){
			if($v['sales']>=$this->_site['valid']){
				$i++;
			}
		}
		$this->assign('son',$i);
		$this->display();
    }
	
	
	//我的订单
	public function order(){
		$this->display();
	}
	
	//获取我的订单
	public function getOrder(){
		$page = I('post.page')?I('post.page'):1;
		$status = I('post.stats')?I('post.stats'):0;
		if(!$order){
			$order = 'create_time desc';
		}
		if($status){
			$where['status'] = $status;
		}
		$where['mch_id'] = $this->user['id'];
		$pagesize = 10;
		$start = ($page - 1)*$pagesize;
		$list = M('mch_order')->where($where)->order($order)->limit($start,$pagesize)->select();
		if($list){
			foreach($list as $k=>$v){
				$list[$k]['cart'] = M('cart')->where(array('id'=>array('in',$v['cart_id'])))->select(); 
			}
		}		
		$this->assign('list',$list);
		$this->assign('page',$page);
		$html = $this->fetch();
		if($page!=1 && !$list){
			$this->error($html);
		}else{
			$this->success($html);
		}
	}
	
	// ajax设置快递信息,发货
	public function send_express(){
		if(IS_POST){
			$name = I('post.name');
			$no = I('post.no');
			$order_id = I('post.order_id');
			$order_info = M('mch_order') -> find($order_id);
			//$this->error(I('post.'));
			if($order_info['status'] == -2){
				$this->error('该订单不允许发货');
			}
			//查询是否有申请退款的商品，若有则不允许发货
			$cart = M('cart')->where(array('id'=>array('in',$order_info['cart_id']),'status'=>-1))->find();
			
			if($cart && !empty($cart)){
				$this->error('存在退货商品，请先操作退货商品后进行发货');
			}
			M('mch_order') -> where(array("id"=>$order_id)) -> save(array(
				'express' => $name,
				'express_no' => $no,
				'delivery_time' => NOW_TIME, //发货时间
				'status' => 3 // 已发货状态
			));
			M('cart')->where(array('id'=>array('in',$order_info['cart_id']),'status'=>2))->save(array(
				'express' => $name,
				'express_no' => $no,
				'status'=>3,
			));
			M('order')->where(array('id'=>$order_info['order_id'],'status'=>2))->save(array(
				'delivery_time' => NOW_TIME, //发货时间
				'status' => 3 // 已发货状态
			));
			$this->success('发货成功',U('Mch/order'));
		}else{
			$this->error('非法请求');
		}
	}
	
	//订单详情 
	public function orderDetail(){
		$order_id = I('get.order_id');
		$order = M('mch_order')->find(intval($order_id));
		if(!$order || $order['status'] == -2){
			$this->error('没有该订单信息',U('My/order'));
		}
		$cart = M('cart')->where(array('id'=>array('in',$order['cart_id']),'status'=>array('neq',-2)))->select();
		$cart = $this->_get_list_logis(1,$cart,$order['addr_id']);
		foreach($cart as $v){
			$nums+=$v['nums'];
		}
		//查询是否有退货订单
		$status_1 = M('cart')->where(array('status'=>-1,'id'=>array('in',$order['cart_id'])))->find();
		$this->assign('status_1',$status_1);
		$order['cart'] = $cart;
		$addr = M('addr')->find(intval($order['addr_id']));
		$this->assign('addr',$addr);
		$this->assign('nums',$nums);
		$this->assign('info',$order);
		$this->display();
	}
	
	
	//取消单个商品
	public function cancleOne(){
		if(IS_POST){
			$cart_id = I('post.cart_id');
			$order_id = I('post.order_id');
			$choose = I('post.choose');
			$order = M('mch_order')->find(intval($order_id));
			if($choose == 1){
				cancleOneCart($cart_id,$order_id,true);
				$this->success('取消单个商品成功!' ,U('Mch/order'));
			}else{
				M('cart')->where(array('id'=>$cart_id))->save(array('status'=>$order['status']));
				$this->success('拒绝单个商品退货!',U('Mch/orderDetail',array('order_id'=>$order_id)));
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	
	//分销和团队
	public function money(){
		$type = I('get.type');
		$this->assign('separate',M('separate_log')->where(array('type'=>$type,'user_id'=>$this->user['id'],'status'=>3))->sum('points'));
		$this->assign('yj_separate',M('separate_log')->where(array('type'=>$type,'user_id'=>$this->user['id'],'status'=>0))->sum('points'));
		$this->display();
	}
	
	//获取分销或团队奖励
	public function getMoney(){
		if(IS_POST){
			$type = I('post.type');
			$where= 'type='.$type.' and user_id='.$this->user['id'].' and (status=3 or status=0)';
			$page = I('post.page')?I('post.page'):1;
			$pagesize = 10;
			$start = ($page-1)*$pagesize;
			$list = M('separate_log')->where($where)->order('create_time desc')->limit($start,$pagesize)->select();
			foreach($list as $k=>$v){
				$list[$k]['user'] = M('user')->find(intval($v['self_id']));
				$list[$k]['product'] = M('product')->find(intval($v['product_id']));
			}
			$this->assign('list',$list);
			$this->assign('page',$page);
			$html = $this->fetch();
			if($page!=1 && !$list){
				$this->error($html);
			}else{
				$this->success($html);
			}			
		}else{
			$this->error('非法请求');
		}
	}
	
	
	// 商户登陆PC 
	public function mch_login(){
		if(IS_POST){
			if($this->user['level']<1){
				$this->error('您还不是代理！');
				exit;
			}
			M('mch_login') -> add(array(
				'user_id' => $this -> user['id'],
				'session_id' => $_POST['rand'],
				'create_time' => NOW_TIME,
				'status' => 1
			));
			
			$this -> redirect(U('Admin/Mch/index'));
		}
		$this -> display();
	}
	
	public function sign(){
		if(IS_POST){
			$post = I('post.');
			$code = session('code.value');
			if($this->user['ismch']>0){
				$this->error('您已经提交了申请');
			}
			if($post['code'] != $code){
				$this->error('手机短信码错误！');
			}
			$post['ismch'] = 1;
			unset($post['code']);
			if(M('user')->where(array('id'=>$this->user['id']))->save($post)){
				$this->success('申请成功，请等待管理员审核',U('index'));
			}else{
				$this->error('申请失败');
			}
			exit;
		}
		$this->display();
	}
	
	
	//发送短信验证码
    public function SendSms(){
	   if(IS_POST){
		    $mobile = I('post.mobile');
		    $code = rand(100000,999999);
		    session('code',array('value'=>$code,'expire'=>1800));
			$content = '您的验证码为:'.$code.'请在三十分钟内及时认证!';
		    $return = sms($mobile,$content);
		    $this->success('发送成功,请注意手机查收！');
	   }else{
		   $this->error('非法请求');
	   }
    }
   
	
}