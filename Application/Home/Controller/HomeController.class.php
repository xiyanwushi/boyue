<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller {
    public function _initialize(){
		// 加载配置
		$config = M('config') -> select();
		if(!is_array($config)){
			die('请先在后台设置好各参数');
		}
		foreach($config as $v){
			$key = '_'.$v['name'];
			$this -> $key = unserialize($v['value']);
			$_CFG[$v['name']] = $this -> $key;
		}
		$this -> assign('_CFG', $_CFG);
		$GLOBALS['_CFG'] = $_CFG;
		
		//print_r($this -> _level);
		
		if(APP_DEBUG && $_GET['user_id'])
			session('user', M('user') -> find(intval($_GET['user_id'])));

		$this -> tplmsg = new \Common\Util\tplmsg;
		
		
		if(session('?user')){
			// 不能直接从session获取数据，不是最新的 
			$this -> user = M('user') -> find(session('user.id'));
		}else{
			// 网页认证授权
			if (!isset($_GET['code'])){
				$custome_url = get_current_url();
				$scope = 'snsapi_userinfo';
				$oauth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this -> _mp['appid'] . '&redirect_uri=' . urlencode($custome_url) . '&response_type=code&scope=' . $scope . '&state=ljaixiao#wechat_redirect';
				header('Location:' . $oauth_url);
				exit;
			}
			//dump($_GET['code']);
			if(isset($_GET['code']) && isset($_GET['state']) && isset($_GET['state']) == 'ljaixiao'){
				$rt = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this -> _mp['appid'] . '&secret=' . $this -> _mp['appsecret'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code');
				$jsonrt = json_decode($rt, 1);
				//dump($jsonrt);
				if(empty($jsonrt['openid'])){
					$this -> error('用户信息获取失败!');
				}
				$this -> openid = $jsonrt['openid'];
				
				//从数据库获取信息
				$user_info = M('user') -> where(array('openid' => $this -> openid)) -> find();
				if(!$user_info){
					// 拉取用户信息
					$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$jsonrt['access_token']."&openid=".$jsonrt['openid']."&lang=zh_CN";
					$rt = file_get_contents($url);
					$jsonrt = json_decode($rt ,1);
					if(empty($jsonrt['openid'])){
						$this -> error('获取用户详细信息失败');
					}
					$user_info = array(
						'nickname' => $jsonrt['nickname'],
						'openid' => $this -> openid,
						'sex' => $jsonrt['sex'],
						'headimg' => $jsonrt['headimgurl'],
						'parent1' => intval($_GET['parent'])
					);
					if($_GET['parent']){
						$parent_info = M('user') -> find(intval($_GET['parent']));
						if($parent_info){
							$user_info = array_merge(array(
								'parent1' => $parent_info['id'],
								'parent2' => $parent_info['parent1'],
								'parent3' => $parent_info['parent2']
							), $user_info);
						}
					}
					$user_info['id'] = M('user') -> add($user_info);
					if($user_info['id']){
						// 增加上级的统计
						M('user') -> where(array('id'=>$parent_info['id'])) -> setInc('agent1');
						M('user') -> where(array('id'=>$parent_info['parent1'])) -> setInc('agent2');
						M('user') -> where(array('id'=>$parent_info['parent2'])) -> setInc('agent3');
					}
				}
				session('user', $user_info);
				$this -> user = $user_info;
			}
		}
		$this -> assign('user', $this -> user);	
		
		$this->get_qrcode();
			
		// 自动确认收货
		$this -> _auto_confirm();	
		
		// 需要提现权限的模块
		$action_arr = array( 'withdraw','deposit','ground','qrcode');
		if(in_array(ACTION_NAME, $action_arr) && !$this -> _can(ACTION_NAME)){
			$this -> error('您没有权限！');
		}
		// 调用jssdk
		$dd = new \Common\Util\ddwechat();
		$dd -> setParam($this -> _mp);
		$jssdk = $dd -> getsignpackage();
		$this -> assign('jssdk', $jssdk);
	}
	
	
	// 判断权限
	private function _can($type){
		return $this -> _level[$this->user['level']][$type] ? true : false ;
	}
	
	
	//获取单个商品的运费;list:购物车单个数据
	public function _get_one_logis($cid,$addr){
		$logis_fee = 0;
		if($cid){
			if(!is_array($cid)){
				$list = M('cart')->find(intval($cid));
			}else{
				$list = $cid;
			}	
			if(!$addr){
				$addr = M('addr')->where(array('user_id'=>$this->user['id'],'is_default'=>1))->find();
			}else{
				if(!is_array($addr)){
					$addr = M('addr')->find(intval($addr));
				}
			}
			if($addr){
				$logis = M('logis')->where(array('provice'=>$addr['provice']))->find();
				if($logis){
					$fkg = $logis['fkg'];
					$ekg = $logis['ekg'];
				}else{
					$fkg = $this->_site['fkg'];
					$ekg = $this->_site['ekg'];
				}
				$weight = $list['weight'];
				if($weight>1){
					$ext = ceil($weight-1);
					$logis_fee = $fkg + ($ext*$ekg);
				}elseif($weight == 0){
					$logis_fee = 0;
					$list[$k]['logis_fee'] = 0;
				}else{
					$logis_fee = $fkg;
				}
			}
		}
		return $logis_fee;
	}
	
	//获取一个购物车数组并根据参数type返回金额或者数组
	public function _get_list_logis($type,$list,$addr){
		$logis_fee=0;
		if(!$addr){
			$addr = M('addr')->where(array('user_id'=>$this->user['id'],'is_default'=>1))->find();
		}else{
			if(!is_array($addr)){
				$addr = M('addr')->find(intval($addr));
			}
		}
		
		if($list){
			foreach($list as $k=>$v){
				$cart = M('cart')->find(intval($v['id']));	
				if($addr){
					$logis = M('logis')->where(array('provice'=>$addr['provice']))->find();
					
					if($logis){
						$fkg = $logis['fkg'];
						$ekg = $logis['ekg'];
					}else{
						$fkg = $this->_site['fkg'];
						$ekg = $this->_site['ekg'];
					}
					
					$weight = $cart['weight'];
					if($weight>=1){
						$ext = ceil($weight-1);
						$logis_fee += $fkg + ($ext*$ekg);
						$list[$k]['logis_fee'] = $fkg + ($ext*$ekg);
					}elseif($weight == 0){
						$logis_fee = 0;
						$list[$k]['logis_fee'] = 0;
					}else{
						$logis_fee += $fkg;
						$list[$k]['logis_fee'] = $fkg;
					}
				}
			}
		}
		if($type == 1){
			return $list;
		}elseif($type == 2){
			return $logis_fee;
		}
	}
	
	
	/*
	*计算重销积分和自有积分抵扣情况，返回三类支付数组
	*$points_total = 总积分
	*/
	protected function _points($points_total){
		$data = array();
		if($points_total){
			//积分现金比率
			$rate = $this->_site['points_rate']/100;
			$user = M('user')->find(intval($this->user['id']));			
			if(!$user['cx_points'] || $user['points'] == 0){//重销积分为0
				if(!$user['points'] || $user['points'] == 0){//自由积分为0
					$money = $points_total * $rate;					
					$data = array(
						'money'=>$money,
						'cxpointspay'=>0,
						'pointspay'=>0,
					);
				}elseif($user['points']>0 && $user['points']<$points_total){
					$money = ($points_total - $user['points']) * $rate;
					$data = array(
						'money'=>$money,
						'cxpointspay'=>0,
						'pointspay'=>$user['points'],
					);
				}elseif($user['points']>=$points_total){
					$data = array(
						'money'=>0,
						'cxpointspay'=>0,
						'pointspay'=>$points_total,
					);
				}
			}else{//若有重销积分			
				if($user['cx_points']<$points_total){//若重销积分不足
					$ext = $points_total - $user['cx_points'];
					//剩余判断用自有积分
					if(!$user['points']){
						$money = $ext * $rate;
						$data = array(
							'money'=>$money,
							'cxpointspay'=>$user['cx_points'],
							'pointspay'=>0,
						);
					}elseif($user['points']>0 && $user['points']<$ext){
						$money = ($ext - $user['points'])*$rate;
						$data = array(
							'money'=>$money,
							'cxpointspay'=>$user['cx_points'],
							'pointspay'=>$user['points'],
						);
					}elseif($user['points']>=$ext){
						$data = array(
							'money'=>0,
							'cxpointspay'=>$user['cx_points'],
							'pointspay'=>$ext,
						);
					}
				}else{
					$data = array(
						'money'=>0,
						'cxpointspay'=>$points_total,
						'pointspay'=>0
					);
				}
			}
		}
		return $data;
	}
	
	/*
	*计算统计余额或微信支付要支付的金额
	*$point_pay = 积分支付返回的三类信息额度，way=支付方式
	*返回数组
	*/
	protected function _getPay($points_pay,$total,$way){
		$data = array();
		if($points_pay && $way && $total){
			$user = M('user')->find(intval($this->user['id']));
			if($way == 1){//微信支付
				$data = array(
					'wxpay'=>$points_pay['money'] + $total,
					'moneypay'=>0,
					'pointspay'=>$points_pay['pointspay'],
					'cxpointspay'=>$points_pay['cxpointspay'],
				);
			}else{
				if($user['money']>=($total+$point_pay)){
					$data = array(
						'wxpay'=>0,
						'moneypay'=>$points_pay['money'] + $total,
						'pointspay'=>$points_pay['pointspay'],
						'cxpointspay'=>$points_pay['cxpointspay'],
					);
				}else{
					$ext = $total + $points_pay['money'] - $user['money'];
					$data = array(
						'wxpay'=>$ext,
						'moneypay'=>$user['money'],
						'pointspay'=>$points_pay['pointspay'],
						'cxpointspay'=>$points_pay['cxpointspay'],
					);
				}
			}
		}
		return $data;
	}



	// 自动确认收货
	private function _auto_confirm(){
		if(!empty($this -> _site['auto_confirm']) && $this -> _site['auto_confirm'] >0){
			$time = strtotime('-'.$this -> _site['auto_confirm'].'days');
			// 所有发货时间超过制定时间的待收货的订单
			$orders = M('mch_order') -> where(array(
				'delivery_time' => array('lt', $time),
				'status' => 3
			)) -> select();
			foreach($orders as $order_info){
				confirm_order($order_info);
			}
		}
	}



	
	// 显示/获取推广二维码图片
	protected function get_qrcode(){
		// 忽略用户取消，限制执行时间为90s
		ignore_user_abort();
		set_time_limit(90);	
		$path_info = get_qrcode_path($this -> user);		
		// 已生成则直接返回
		if(is_file($path_info['new'])){
			return $path_info['new'];
		}		
		// 目录不存在则创建
		if(!is_dir($path_info['path'])){
			mkdir($path_info['path'], 0777,1);
		}		
		$dd = new \Common\Util\ddwechat($this -> _mp);		
		if(!is_file($path_info['qrcode'])){				
			$accesstoken = $dd -> getaccesstoken();
			$rs = $dd -> createqrcode('user_'.$this -> user['id'],null,$accesstoken);
			if(!$rs){
				if(APP_DEBUG){
					$this -> error($dd -> errmsg);
				}else{
					$this -> error('推广二维码生成失败，请稍后重试！');
				}
			}
			$qrcode_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$rs['ticket'];
			$qrcode_img = $dd -> exechttp($qrcode_url, 'get', null , true); //file_get_contents($qrcode_url);
			if(!$qrcode_img){
				$this -> error('获取二维码失败');
			}
			// 保存图片	
			$save = file_put_contents($path_info['qrcode'],$qrcode_img);

			if(!$save){
				$this -> error('二维码保存失败！');
			}
		}
		// 合成
		if($this->_site['qrcode']){
			$im_dst = imagecreatefromjpeg($this->_site['qrcode']);
		}else{
			$im_dst = imagecreatefromjpeg("./Public/images/tpl.jpg");
		}		
		$im_src = imagecreatefromjpeg($path_info['qrcode']);		
		// 合成二维码（二维码大小230*230)
		imagecopyresized ( $im_dst, $im_src,240, 790, 0, 0, 320, 320, 430, 430);		
		// 保存
		imagejpeg($im_dst, $path_info['new']);
		// 销毁
		imagedestroy($im_src);
		imagedestroy($im_dst);
		return $path_info['new'];
	}












}