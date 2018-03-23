<?php
namespace Home\Controller;
use Think\Controller;
class AjaxController extends HomeController {
	
	//商品详情增加购买数量判断是否超过库存
	public function checkSold(){
		if(IS_POST){
			$num = I('post.num');
			$pid = I('post.pid');
			$product = M('product')->find(intval($pid));
			if($num>$product['stock']){
				$this->error('没有更多的库存了');
			}else{
				$this->success($num.'-'.$product['stock']);
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	//增加购物车
	public function addCart(){
		if(IS_POST){
			$pid = I('post.pid');
			$nums = I('post.nums');
			$is_zq = I('post.is_zq')?I('post.is_zq'):0;
			$product = M('product')->find(intval($pid));
			$data = array(
				'mch_id'=>$product['user_id'],
				'user_id'=>$this->user['id'],
				'product_id'=>$pid,
				'nums'=>$nums,
				'title'=>$product['title'],
				'pic'=>$product['pic'],
				'market_price'=>$product['market_price'],
				'price'=>$product['price'],
				'points'=>$product['points'],
				'zq_points'=>$product['zq_points'],
				'weight'=>$product['weight'],
				'create_time'=>time(),
				'is_zq'=>$is_zq,
			);
				
			$cart = M('cart')->where(array('user_id'=>$this->user['id'],'product_id'=>$pid,'is_zq'=>$is_zq,'order_id'=>0))->find();
				
			if($cart){
				$add = M('cart')->where(array('user_id'=>$this->user['id'],'product_id'=>$pid,'is_zq'=>$is_zq,'order_id'=>0))->setInc('nums',$nums);	
			}else{
				$add = M('cart')->add($data);
			}
			if($add){
				$this->success('加入购物车成功!',U('Index/cart'));
			}else{
				$this->error('加入购物车失败!');
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	//操作购物车数量
	public function setCartNums(){
		if(IS_POST){			
			$post = I('post.');
			//$this->success($post);
			$cart = M('cart')->find(intval($post['cid']));
			$product = M('product')->find(intval($cart['product_id']));
			if(!$cart){
				$this->error('购物车信息错误');
			}
			if($post['type'] == 1){//减少数量
				if($cart['nums'] == 1){
					$this->ajaxReturn(array('status'=>2));//数量为1，不减少
				}
				$nums = $cart['nums'] - 1;
				M('cart')->where(array('id'=>$post['cid']))->save(array('nums'=>$nums));
				$logis_fee = $this->_get_one_logis($post['cid'],$post['addr_id']);
				$info = array('nums'=>$nums,'logis_fee'=>$logis_fee);
				$this->success($info);
			}elseif($post['type'] == 2){
				$nums = $cart['nums'] + 1;
				if($nums>$product['stock']){
					$this->error('没有更多的库存了');
				}
				M('cart')->where(array('id'=>$post['cid']))->save(array('nums'=>$nums));
				$logis_fee = $this->_get_one_logis($post['cid'],$post['addr_id']);
				$info = array('nums'=>$nums,'logis_fee'=>$logis_fee);
				$this->success($info);
				$this->success($nums);
			}elseif($post['type'] == 3){
				if($post['nums']>$product['stock']){
					$this->error('该商品没有'.$post['nums'].'件库存了');
				}
				M('cart')->where(array('id'=>$post['cid']))->save(array('nums'=>$post['nums']));
				$logis_fee = $this->_get_one_logis($post['cid'],$post['addr_id']);
				$info = array('nums'=>$post['nums'],'logis_fee'=>$logis_fee);
				$this->success($info);
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	//删除购物车
	public function delCart(){
		if(IS_POST){
			$cids = I('post.cids');
			$where['id'] = array('in',$cids);
			if(M('cart')->where($where)->delete()){
				$this->success('删除成功！');
			}else{
				$this->error('删除失败！');
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	//获取勾选购物车的总价格（包括运费）
	public function get_cart_total(){
		if(IS_POST){
			$cids = I('post.cids');
			$addr = I('post.addr');
			$where['id'] = array('in',$cids);
			$cart = M('cart')->where($where)->select();
			if($cart && !empty($cart)){
				$total = 0;
				foreach($cart as $k=>$v){
					if($v['is_zq'] == 1){
						$points += $v['nums'] * $v['zq_points'];
					}else{
						$total += $v['nums'] * $v['price'];
						$points += $v['nums'] * $v['points'];
					}
				}
				$logis_fee = $this->_get_list_logis(2,$cart,$addr);
				$info = array('total'=>$total,'logis_fee'=>$logis_fee,'points'=>$points);
				$this->success($info);
			}else{
				$info = array('total'=>'0.00','logis_fee'=>'0.00','points'=>'0');
				$this->success($info);
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	
	//添加关注
	public function Favorite(){
		$pid = I('post.pid');
		$product = M('product')->find(intval($pid));
		$data = array(
					'user_id'=>$this->user['id'],
					'product_id'=>$pid,
					'title'=>$product['title'],
					'pic'=>$product['pic'],
					'price'=>$product['price'],
					'create_time'=>time(),
					'status'=>1,
				);
		if(!$product || empty($product)){
			$this->error('没有关注的商品');
		}
		$favorite = M('favorite')->where(array('user_id'=>$this->user['id'],'product_id'=>$pid))->find();
		if($favorite){
			if($favorite['status'] == 1){
				M('favorite')->where(array('user_id'=>$this->user['id'],'product_id'=>$pid))->save(array('status'=>0));
				$ajax = array('status'=>2,'info'=>'取消关注成功');
				$this->ajaxReturn($ajax);
			}else{
				M('favorite')->where(array('user_id'=>$this->user['id'],'product_id'=>$pid))->save($data);
				$ajax = array('status'=>1,'info'=>'关注成功');
				$this->ajaxReturn($ajax);
			}
		}else{
			if(M('favorite')->add($data)){
				$ajax = array('status'=>1,'info'=>'关注成功');
				$this->ajaxReturn($ajax);
			}else{
				$this->error('关注失败');
			}
		}
	}
	
	//创建订单结算
	public function createOrder(){
		if(IS_POST){
			$cids = I('post.cids');
			$addr_id = I('post.addr');
			$payway = I('post.payway');
			
			//查询购物车
			$where['id'] = array('in',$cids);
			$where['order_id'] = 0;
			$cart = M('cart')->where($where)->select();
			$addr = M('addr')->find(intval($addr_id));
			if(!$cart || empty($cart)){
				$this->error('购物车信息错误');
			}else{
				//查询购物车所属不同商户
				$mchs = M('cart')->distinct(true)->field('mch_id')->where($where)->select();
				foreach($cart as $v){
					$product = M('product')->where(array('id'=>$v['product_id']))->find();
					if($product['stock']<$v['nums']){
						$this->error($product['title'].'的库存不足');
						exit;
					}
					if( ($v['price']+$v['points'] ) != ($product['price']+$product['points']) ){
						$this->error('您购买的'.$product['title'].'商品已下架，请重新选购');
						exit;
					}
					if($v['is_zq'] == 1){
						$points_total += $v['nums'] * $v['zq_points'];
					}else{
						$total += $v['nums'] * $v['price'];
						$points_total += $v['nums'] * $v['points'];
					}
				}
				$logis_fee = $this->_get_list_logis(2,$cart,$addr);
				$total = $total + $logis_fee;
				$user = M('user')->find(intval($this->user['id']));
				
				//调用积分支付计算方法确定支付分摊额度
				$points_pay = $this->_points($points_total);
				
				
				//获取计算后返回的微信支付/余额支付等额度
				$pay_total = $this->_getPay($points_pay,$total,$payway);

				$status = 1;
				//如果是余额支付 而且余额支付的时候 微信支付的金额等于0，说明余额足够
				if($payway == 2 && (!$pay_total['wxpay'] || $pay_total['wxpay']==0)){
					$status = 2;
				}
				
				$data = array(
					'sn'=>Sn($this->user['id']),
					'user_id'=>$this->user['id'],
					'name'=>$addr['name'],
					'mobile'=>$addr['mobile'],
					'addr'=>str_replace('||',' ', $addr['district']).' '.$addr['addr'],
					'addr_id'=>$addr_id,
					'msg'=>I('post.msg'),
					'logis_fee'=>$logis_fee,
					'total'=>$total,
					'points_total'=>$points_total,
					'create_time'=>time(),
					'status'=>$status,
					'payway'=>$payway,
					'cxpointspay'=>$pay_total['cxpointspay'],
					'pointspay'=>$pay_total['pointspay'],
					'moneypay'=>$pay_total['moneypay'],
					'wxpay'=>$pay_total['wxpay'],
				);
			
				$id = M('order')->add($data);
				$order = M('order')->find(intval($id));
				if($id){
					
					//添加商品销量和减少库存
					foreach($cart as $vs){
						M('product')->where(array('id'=>$vs['product_id']))->setInc('sold',$vs['nums']);
						M('product')->where(array('id'=>$vs['product_id']))->setDec('stock',$vs['nums']);	
					}

					
					//往商户订单表里插入数据
					foreach($mchs as $k=>$v){
						$where['mch_id'] = $v['mch_id'];
						$mch_cart = M('cart')->where($where)->select();
						//每次累加前清除上一次数据
						$ids = array();
						$mch_total = 0;
						$mch_points_total = 0;
						foreach($mch_cart as $v){
							$ids[] = $v['id'];
							if($v['is_zq'] == 1){
								$mch_points_total += $v['nums'] * $v['zq_points'];
							}else{
								$mch_total += $v['nums'] * $v['price'];
								$mch_points_total += $v['nums'] * $v['points'];
							}
						}

						$mch_logis_fee = $this->_get_list_logis(2,$mch_cart,$addr);
						$mch_total = $mch_total + $mch_logis_fee;
						//调用积分支付计算方法确定支付分摊额度
						$mch_points_pay = $this->_points($mch_points_total);
						//获取计算后返回的微信支付/余额支付等额度
						$mch_pay_total = $this->_getPay($mch_points_pay,$mch_total,$payway);
						
						$mdata = array(
							'mch_id'=>$v['mch_id'],
							'sn'=> Sn($v['mch_id']),
							'order_id'=>$order['id'],
							'cart_id'=>implode(',',$ids),
							'user_id'=>$this->user['id'],
							'name'=>$addr['name'],
							'mobile'=>$addr['mobile'],
							'addr'=>str_replace('||',' ', $addr['district']).' '.$addr['addr'],
							'addr_id'=>$addr_id,
							'msg'=>I('post.msg'),
							'logis_fee'=>$mch_logis_fee,
							'total'=>$mch_total,
							'points_total'=>$mch_points_total,
							'create_time'=>time(),
							'status'=>$status,
							'payway'=>$payway,
							'cxpointspay'=>$mch_pay_total['cxpointspay'],
							'pointspay'=>$mch_pay_total['pointspay'],
							'moneypay'=>$mch_pay_total['moneypay'],
							'wxpay'=>$mch_pay_total['wxpay'],
						);
						unset($where['mch_id']);
						$mid = M('mch_order')->add($mdata);
						//添加分成记录
						separate($mid);
						//添加团队奖了激烈
						tward($mid);
						//如果余额支付完成,更新分成状态(未满足条件的不更新)
						if($status == 2){
							M('separate_log')->where(array('order_id'=>$mid,'status'=>1))->setField('status',2);
						}	
					}

					//更新购物车
					M('cart')->where($where)->save(array('order_id'=>$order['id']));
					
					//添加个人余额和积分消费日志
					if($pay_total['pointspay']>0){
						flog($this->user['id'],'points',"-".$pay_total['pointspay'],1);
					}
					if($pay_total['cxpointspay']>0){
						flog($this->user['id'],'cx_points',"-".$pay_total['cxpointspay'],1);
					}
					if($pay_total['moneypay']>0){
						flog($this->user['id'],'money',"-".$pay_total['moneypay'],1);
					}
					
					//如果是余额支付 而且余额支付的时候 微信支付的金额等于0，说明余额足够
					if($payway == 2 && (!$pay_total['wxpay'] || $pay_total['wxpay']==0)){
						//更新用户的积分和余额
						M('user')->where(array('id'=>$this->user['id']))->save(array(
							'money' => array('exp', 'money-'.$pay_total['moneypay']),
							'points' => array('exp', 'points-'.$pay_total['pointspay']),
							'cx_points' => array('exp', 'cx_points-'.$pay_total['cxpointspay']),
						));
						
						//更新购物车和商户订单状态
						M('mch_order') -> where(array('id'=>$order['id'])) -> save(array('status'=>2,'pay_time'=>time()));
						M('cart')->where(array('order_id'=>$id))->setField('status',2);					
						$this->success('',U('Index/orderDetail',array('order_id'=>$id)));
					}else{
						//更新用户的积分和余额
						M('user')->where(array('id'=>$this->user['id']))->save(array(
							'points' => array('exp', 'points-'.$pay_total['pointspay']),
							'cx_points' => array('exp', 'cx_points-'.$pay_total['cxpointspay']),
							'money'=>array('exp','money-'.$pay_total['moneypay']),
						));
						$this->success('',U('Index/pay',array('order_id'=>$id)));
					}

				}else{
					$this->error('生成订单错误');
				}	
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	
	public function pay(){
		$order_id = I('post.order_id');
		$order = M('order')->find(intval($order_id));
		if(!$order || $order['status']!=1){
			$this->error('该订单不能进行支付');
		}		
		$jsapi = new \Common\Util\wxjspay;
		$param = $this -> _mp;
		$param['key'] = $this -> _mp['key'];
		$param['openid'] = $this -> user['openid'];
		$param['body'] = $this -> _site['name'].'在线支付';
		$param['out_trade_no'] = $order['sn'];
		$param['total_fee'] = $order['wxpay'] * 100;
		$param['attach'] = json_encode(array(
				'order_id' => $order['id'],
				'user_id' => $this -> user['id'],
				'type' => 1,
		));
		$param['notify_url'] = "http://".$_SERVER['HTTP_HOST'].__ROOT__.'/notify.php';
		$jsapi -> set_param($param);
		$uo = $jsapi -> unifiedOrder();
		$jsapi_params = $jsapi -> get_jsApi_parameters();
		$this->success($jsapi_params);
	}
	
	
	
	
	
	
	//提现
	public function withdraw(){
		
		if(IS_POST){
			$val = I('post.value');
			$type = I('post.type');
			if($type == 1){
				$ext = $this->_withdraw['money_ext'];//满足多少才可以提现
				$per = $this->_withdraw['money_per'];//某个值的倍数
				$lv = $this->_withdraw['money_lv'];//手续费百分比
				$max = $this->_withdraw['money_max'];
				$money = $val - ($val*$lv/100);
			}else if($type == 2){
				$ext = $this->_withdraw['points_ext'];
				$per = $this->_withdraw['points_per'];
				$lv = $this->_withdraw['points_lv'];
				$max = $this->_withdraw['points_max'];
				$cx_lv = $this->_withdraw['points_cx_lv'];//重销百分比
				$money = $val - ($lv*$val/100) - ($val*$cx_lv/100);
				$money = $this->_site['points_rate']*$money/100;
				
			}
			if($type == 1){
				if($this->user['money']<$ext){
					$this->error('需满'.$ext.'的额度方可提现');
				}
			}else{
				if($this->user['points']<$val){
					$this->error('您的积分不足');
				}
			}
			
			if($val%$per!=0){
				$this->error('提现额度必须为'.$per.'的倍数');
			}
			
			$shouxu = $val*$lv/100;
			if($shouxu>$max){
				$shouxu = $max;
			}
			$data = array(
				'user_id'=>$this->user['id'],
				'money'=>$money,
				'ext'=> $shouxu,
				'total'=>$val,
				'create_time'=>time(),
				'type'=>$type
			);
			
			if(M('withdraw')->add($data)){
				if($type == 1){
					M('user')->where(array('id'=>$this->user['id']))->setDec('money',$val);
					//增加扣除记录
					flog($this -> user['id'],'money',"-".$val, 8); // 记录财务日志
				}else if($type == 2){
					M('user')->where(array('id'=>$this->user['id']))->setDec('points',$val);
					flog($this -> user['id'],'points',"-".$val, 8); // 记录财务日志
					
				}
				$this->success('提交申请成功，请等待平台管理员进行审核');
			}else{
				$this->error('提交申请失败');
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	
	//积分转让
	public function deposit(){
		if(IS_POST){
			$mobile = I('post.mobile');
			$points = I('post.points');
			$points_type = I('post.points_type');
			$user = M('user')->where(array('mobile'=>$mobile))->find();
			if(!$user){
				$this->error('没有该收款人信息!');
			}
			if($user['id'] == $this->user['id']){
				$this->error('收款人不能为自己!');
			}
			if($user['level']<1){
				$this->error('接收者等级不够，不能接收转让');
			}
			if($points_type == 1){
				if($this->user['cx_points']<$points){
					$this->error('转让积分额度超出范围!');
				}
				if(M('user')->where(array('id'=>$this->user['id']))->setDec('cx_points',$points)){
					flog($this -> user['id'],'cx_points',"-".$points, 4); // 记录财务日志
					M('sk_points')->add(array(
						'user_id'=>$user['id'],
						'self_id'=>$this->user['id'],
						'points'=>$points,
						'create_time'=>time(),
						'type'=>'cx_points',
					));
					M('user')->where(array('id'=>$user['id']))->save(array(
						'cx_points'=>array('exp','cx_points+'.$points),
					));
					flog($user['id'],'cx_points',"+".$points,11);
					$this->success('积分转让成功');	
				}else{
					$this->error('积分转让失败');
				}
			}else{
				if($this->user['points']<$points){
					$this->error('转让积分额度超出范围!');
				}
				if(M('user')->where(array('id'=>$this->user['id']))->setDec('points',$points)){
					flog($this -> user['id'],'points',"-".$points, 4); // 记录财务日志
					M('sk_points')->add(array(
						'user_id'=>$user['id'],
						'self_id'=>$this->user['id'],
						'points'=>$points,
						'create_time'=>time(),
						'type'=>'points',
					));
					M('user')->where(array('id'=>$user['id']))->save(array(
						'points'=>array('exp','points+'.$points),
					));
					flog($user['id'],'points',"+".$points,11);
					$this->success('积分转让成功');	
				}else{
					$this->error('积分转让失败');
				}
			}
		}else{
			$this->error('非法请求');
		}
	}
	

	//删除订单中的单个商品信息
	public function deleteOneCart(){
		if(IS_POST){
			$cart_id = I('post.cart_id');
			$order_id = I('post.order_id');
			$cart = M('cart')->find(intval($cart_id));
			$order = M('mch_order')->find(intval($order_id));
			if(!$cart['status'] && $cart['status'] == -2){
				$this->error('商品信息错误，不能取消');
			}else{
				//把这个商品设置为申请取消状态(若订单为待付款状态，则直接取消，若是已付款，则先申请)
				if($order['status']>1){
					M('cart')->where(array('id'=>$cart_id))->setField('status',-1);
					$this->success('申请取消商品成功，请等待管理员审核');
				}else{
					//直接退掉(还要把订单商品的积分和现金支付返还给用户)
					M('cart')->where(array('id'=>$cart_id))->setField('status',-2);
					//如果是订单只有这一个商品，则直接取消订单
					$count = M('cart')->where(array('order_id'=>$order['order_id'],'status'=>array('gt',-2)))->count();
					if($count == 0){
						$this->success('已经取消了整个订单了',U('My/order'));
					}else{
						$this->success('取消商品成功');
					}
				}
			}
			
		}else{
			$this->error('非法请求');
		}
	}
	
	//取消整个订单
	public function cancleOrder(){
		if(IS_POST){
			$order_id = I('post.order_id');
			$order = M('mch_order')->find(intval($order_id));
			
			if(!$order || $order['status'] == -1 || $order['status'] == -2){
				$this->error('订单信息错误!');
			}
			//若未支付，则直接取消并且把积分支付和现金支付的钱返还给用户
			if($order['status'] == 1){
				M('mch_order')->where(array('id'=>$order['id']))->setField('status',-2);
				M('cart')->where(array('id'=>array('in',$order['cart_id'])))->setField('status',-2);
				M('user')->where(array('id'=>$order['user_id']))->save(array(
					'points' => array('exp', 'points+'.$order['pointspay']),
					'cx_points' => array('exp', 'cx_points+'.$order['cxpointspay']),
					'money'=>array('exp','money+'.$order['moneypay']),
				));
				if($order['pointspay']>0){
					flog($order['user_id'],'points',"+".$order['pointspay'],6);
				}
				if($order['cxpointspay']>0){
					flog($order['user_id'],'cx_points',"+".$order['cxpointspay'],6);
				}
				if($order['moneypay']>0){
					flog($order['user_id'],'money',"+".$order['money'],6);
				}
				
				//取消分成
				M('separate_log')->where(array('order_id'=>$order['id']))->setField('status',-1);
				$this->success('取消订单成功!',U('My/order'));
			}else{
				M('mch_order')->where(array('id'=>$order['id']))->setField('status',-1);
				M('cart')->where(array('id'=>array('in',$order['cart_id'])))->setField('status',-1);
				$this->success('申请取消订单成功,请等待管理员审核',U('My/order'));
			}
			
		}else{
			$this->error('非法请求');
		}
	}
	
	// 确认收货
	public function confirm_order(){
		if(IS_POST){
			$order_id = I('post.order_id');
			$order = M('mch_order') -> where(array('id' => $order_id, 'user_id' => $this -> user['id'])) -> find($order_id);
			if(!$order || $order['status']!=3){
				$this -> error('订单信息错误!');
			}
			confirm_order($order);
			$this -> success('收货成功！');
		}else{
			$this->error('非法请求');
		}
		
	}
	
	//商品评价
	public function assess(){
		if(IS_POST){
			$product_id = I('post.product_id');
			$score = I('post.score');
			$content = I('post.content');
			$cart_id = I('post.cart_id');
			$cart = M('cart')->where(array('id'=>$cart_id))->find();
			$data = array(
				'user_id'=>$this->user['id'],
				'order_id'=>$cart['order_id'],
				'product_id'=>$product_id,
				'content'=>$content,
				'score'=>$score,
				'create_time'=>time(),
			);

			if(M('assess')->add($data)){
				M('cart')->where(array('id'=>$cart_id))->setField('status',5);
				//若全部商品都评价完，则更新订单状态
				$c = M('cart')->where(array('order_id'=>$cart['order_id'],'status'=>4))->find();
				if(!$c){
					M('mch_order')->where(array('order_id'=>$cart['order_id']))->setField('status',5);
				}
				//计算该商品的评分
				$count = M('assess')->where(array('product_id'=>$product_id))->count();
				$sum = M('assess')->where(array('product_id'=>$product_id))->sum('score');
				$lv = ceil($sum/$count);
				M('product')->where(array('id'=>$product_id))->setField('score',$lv);
				$this->success('评价成功');
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	//加载评论
	public function loadAssess(){
		if(IS_POST){
			$product_id = I('post.product_id');
			$page = I('post.page')?I('post.page'):0;
			$pagesize = 10;
			$start = ($page-1)*$pagesize;
			
			$list = M('assess')->where(array('product_id'=>$product_id))->order('create_time desc')->limit($start,$pagesize)->select();
			if($list){
				$html = '';
				foreach($list as $k=>$v){
					$user = M('user')->find(intval($v['user_id']));
					$html.='<li class="dtcmc-li">';
					$html.='<p class="dtcmcl-p">'.$v['content'].'</p>';
					$html.='<div class="dtcmcl-d3 lgray">用户:'.$user['nickname'].'<em>&nbsp;&nbsp;</em>';
					$html.='<span>'.date('Y-m-d H:i:s',$v['create_time']).'<span>';
					$html.='</span></span>';
					$html.='</div>';
					$html.='</li>';
				}
				$this->ajaxReturn(array('status'=>1,'info'=>$html));
			}else{
				if($page == 1){
					$html='<li class="dtcmc-li" style="margin-top:10px;">';
					$html.='<div style="height: 30px;line-height: 30px;text-align: center;">没有评价内容！</div>';
					$html.='</li>';
					$this->ajaxReturn(array('status'=>2,'info'=>$html));
				}else{
					$this->ajaxReturn(array('status'=>3,'info'=>'已经加载所有评价内容！'));
				}
			}
		}else{
			$this->error('非法请求');
		}
	}
	
	
	// 统计昨日全站数据报告
	public function data(){
		$date = date('Ymd', strtotime('-1 day'));
		$info = M('data') -> where('date='.$date) -> find();
		// 如果有昨天的记录则结束
		if($info){
			exit;
		}
		
		$etime = strtotime('today');
		$stime = $etime - 86400;
		
		$where['create_time'] = array('between', array($stime, $etime));
		$mp['pay_time'] = array('between', array($stime, $etime));
		$mp['status'] = array('gt',1);
		$data['orders'] = M('mch_order') -> where($where) -> count();		
		$data['points']  = M('mch_order') -> where($mp) -> sum('points_total'); 
		$data['wxpay']  = M('mch_order') -> where($mp) -> sum('wxpay');
		$data['moneypay']   = M('mch_order') -> where($mp) -> sum('moneypay');
		$data['date'] = $date;
		M('data') -> add($data);
	}
	
	
	//64位上传图片
	public function upload_64(){
        $base64_image_content = I("post.img");
        $image_name = I("post.name");
        $len = I("post.size");
        $baseLen = strlen($base64_image_content);
        if($len!=$baseLen)  $this->error("上传图片不完整");
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $uploadFolder  = './Uploads/images/'.date("Ymd")."/";

            if (!is_dir($uploadFolder)) {
                mkdir($uploadFolder, 0755, true);
            }
            $type = $result[2];
            if(empty($image_name)){
                $new_file = $uploadFolder.date("His")."_".mt_rand(0, 1000).".{$type}";
            }else{
                $new_file = $uploadFolder.$image_name."_".date("mdHis").".{$type}";
            }
            
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                $this->success($new_file);
            }
        }else{
            $this->error("图片不存在");
        } 
    }
	
	
		
}?>