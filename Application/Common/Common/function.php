<?php

// 对字符串进行加盐散列加密
function xmd5($str){
	return md5(md5($str).C('SAFE_SALT'));
}

// 获得当前的url
function get_current_url(){
	$url = "http://" . $_SERVER['SERVER_NAME'];
	$url .= $_SERVER['REQUEST_URI'];
	return $url;
}

// 补全url
function complete_url($url){
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	if(substr($url,0,1) == '.'){
		return $protocol . $_SERVER['SERVER_NAME'].__ROOT__.substr($url,1);
	}
	elseif(substr($url,0,7) != 'http://' && substr($url,0,8) != 'https://'){
		return $protocol . $_SERVER['SERVER_NAME'].$url;
	}
	else{
		return $url;
	}
	
}
//截取字符串
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
    if(function_exists("mb_substr")){
        if($suffix)
            return mb_substr($str, $start, $length, $charset)."...";
        else
            return mb_substr($str, $start, $length, $charset);
    }
    elseif(function_exists('iconv_substr')) {
        if($suffix)
            return iconv_substr($str,$start,$length,$charset)."...";
        else
            return iconv_substr($str,$start,$length,$charset);
    }
    $re['utf-8']   = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef]
                  [x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
    $re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
    $re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}
//获取自身的二维码推广图片
function getqrcode($user){
	if(!is_array($user)){
		$user = M('user')->find(intval($user));
	}
	if(is_file('./Public/qrcode/'.$user['id'].'_qrcode.jpg')){
		return './Public/qrcode/'.$user['id'].'_qrcode.jpg';
	}else{
		return false;
	}
}

// 将列表变成树形结构
function list_to_tree($list, $parent=0){
	$data = array();
	foreach($list as $v){
		if($v['pid'] == $parent){
			$data[] = array_merge(array(
				'_child' => list_to_tree($list, $v['id'])
			),$v);
		}
	}
	return $data;
}


function get_admin_name($role_id){
	return M('role')->where(array('id'=>$role_id))->getField('name');
}


//修改上级
function EditParent($user,$parent){
	if(!$user){
		return false;
	}else{
		if(!is_array($user)){
			$user = M('user')->find(intval($user));
		}
		if(!is_array($parent)){
			$parent = M('user')->find(intval($parent));
		}
	}
	
	M('user')->where(array('id'=>$user['id']))->save(array(
		'parent1'=>$parent['id'],
		'parent2'=>$parent['parent1'],
		'parent3'=>$parent['parent2'],
	));
	$son = M('user')->where(array('parent1'=>$user['id']))->select();
	if(!empty($son)){
		foreach($son as $k=>$v){
			EditParent($v['id'],$user['id']);
		}
	}
	
}


//发送短信:$con 为数据库存储的字段名称
function sms($mobile, $contents){
	$sms = $GLOBALS['_CFG']['sms'];
	$content = '【'.$sms['sms_sign'].'】'.$contents;
	$url = "http://api.smsbao.com/sms?u=".$sms['sms_user']."&p=".md5($sms['sms_psw'])."&m=".$mobile."&c=".urlencode($content);
	$rt = file_get_contents($url);
}



// 将数变成列表
function tree_to_list($tree ,$level = 0){
	$data = array();
	foreach($tree as $v){
		$temp = $v['_child'];
		unset($v['_child']);
		$data[] = array_merge(array('_level' => $level),$v);
		if(is_array($temp) && count($temp) >0){
			$data = array_merge($data, tree_to_list($temp,$level+1));
		}		
	}
	return $data;
}

//获取商品标签
function get_feature($str){
	$return = '';
	$feature = $GLOBALS['_CFG']['feature']['config'];
	if($str !=''){
		$arr = explode(',',$str);
		foreach($arr as $v){
			$return.='&nbsp;&nbsp'.$feature[$v]['name'].'&nbsp;&nbsp;|';
		}
		$return = substr($return,0,-1);
	}
	return $return;
}

/**
 * 二维数组根据字段进行排序
 * @params array $array 需要排序的数组
 * @params string $field 排序的字段
 * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
 */
function arraySequence($array, $field, $sort = 'SORT_DESC'){
    $arrSort = array();
    foreach ($array as $uniqid => $row) {
        foreach ($row as $key => $value) {
            $arrSort[$uniqid][$key] = $value;
        }
    }
    array_multisort($arrSort[$field], constant($sort), $array);
    return $array;
}


//创建订单号
function Sn($user){
	if(is_array($user)){
		$sn = $user['id'].date('YmdHis').rand(100000,999999);
	}else{
		$sn = $user.date('YmdHis').rand(100000,999999);
	}
	return $sn;
}

//获得用户团队有效用户数目
function getValid($user){
	if(!is_array($user)){
		$user = M('user')->find(intval($user));
	}
	$site = $GLOBALS['_CFG']['site'];
	$num = 0;
	$team = getChildren($user['id']);	
	if($team){
		foreach($team as $k=>$v){
			
			if($v['sales']>$site['valid']){
				$num++;
			}
		}
	}
	return $num;
}


/*
*判断用户是否可以获得佣金//不能获得，则佣金进行封存
*返回true/false
*/
function isValid($user,$i){
	if(!is_array($user)){
		$user = M('user')->find(intval($user));
	}
	$num = getValid($user);
	$dist = $GLOBALS['_CFG']['dist'];	
	if($user && $i){	
		if((int)$num>=$dist["level{$i}_valid"]){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

/*
*获得用户直推有效会员数量
*/
function getZhiValid($user,$type){
	if(!is_array($user)){
		$user = M('user')->find(intval($user));
	}
	$team = array();
	$count = 0;
	$site = $GLOBALS['_CFG']['site'];
	$where['sales'] = array('egt',$site['valid']);
	$where['parent1'] = $user['id'];
	$team = M('user')-> where($where) -> select();
	$count = count($team);
	return $count;
	
}


function getChildren($pid,&$data = array()){
	if(!$pid){
		return $data;
	}
	$user = M('user')->where(array('parent1'=>$pid))->select();
	if($user){
		foreach($user as $v){
			$data[]=$v;
			getChildren($v['id'],$data);
		}
	}		
	return $data;
}

// 更改用户等级
function update_level($user, $config,$j=1){
	// 如果用户参数是id则查询用户信息
	if(!is_array($user)){
		$user = M('user') -> find(intval($user));
		if(!$user){
			return false;
		}
	}
	
	if(!$config)$config = $GLOBALS['_CFG']['level'];
	// 获得团队总数
	$team = getValid($user['id']);
	//获得直推团队有效代理人数
	$valid = getZhiValid($user);
	//查询多少个有效会员，发放未满足条件的分拥
	//$j最高为3
	if($j>3){
		$j = 3;
	}
	if($valid>=$j){	
		send_separate($user['id']);
	} 
	
	//等级树组
	$level = $GLOBALS['_CFG']['level'];
	//发放未满足条件的分拥结束
	$level = $user['level'];
	// 从高等级到低等级判断
	$updated = false;
	for($i = count($config)-1; $i>$level; $i--){
		//echo $user['id'];
		$tcount = M('user')->where(array("id"=>$user["id"],"tlevel".$config[$i]['have']=>array('gt',0)))->count();
		if(($tcount || $tcount>0) && $i!=$level && $level>2 && $team>=$config[$i]['team'] && $valid>=$config[$i]['valid']){
			M('user') -> where(array('id'=>$user['id'])) -> save(array('level' => $i));			
			$updated = true;		
			break;
		}else{
			if($team >= $config[$i]['team'] && $valid>=$config[$i]['valid'] && $i!=$level && $i<3){	
				M('user') -> where(array('id'=>$user['id'])) -> save(array('level' => $i));
				$updated = true;
				break;
			}
		}
	}	
	//更新上级拥有2等级和3等级数量
	$parent = $user;	
	if(($i == 2 || $i == 3 || $i == 4) && $updated){		
		while($parent['parent1']>0){
			$filed = "tlevel{$i}";
			M('user')->where(array('id'=>$parent['parent1']))->setInc($filed,1);
			$parent = M('user')->find($parent['parent1']);
		}
	}
	$j++;
	update_level($user['parent1'],'',$j);
	return;
}


/*生成分拥记录;
*分单表查询，查询mch_order
*/
function separate($order){
	$separate = 0;
	if(!is_array($order)){
		$order = M('mch_order')->find(intval($order));
	}
	$dist = $GLOBALS['_CFG']['dist'];
	$site = $GLOBALS['_CFG']['site'];
	//每个商品进行分销，因为退款可对单个商品进行退款
	if($order && $order['separate']==0){
		$user = M('user')->find(intval($order['user_id']));
		$cart = M('cart')->where(array('id'=>array('in',$order['cart_id'])))->select();
		foreach($cart as $v){
			if($v['is_zq'] !=1){
				$product = M('product')->find(intval($v['product_id']));
				$separate = $v['nums']*((($product['price'] + $product['points']) * $product['separate'])/100);
				if($separate && $separate>0){
					for($i=1;$i<=3;$i++){
						
						// 检查是否设置该级分成信息
						if(empty($dist["level{$i}_per"])){
							var_dump($dist);
							break;
						}
						// 检查是否有这一级别的上级
						$parent = M('user')->find(intval($user["parent{$i}"]));
						if(empty($user['parent'.$i]) || $user['parent'.$i] <1){
							break;
						}
						$separate_points = $dist["level{$i}_per"]*$separate/100;
						
						if(isValid($parent,$i)){
							$status = 1;
						}else{
							$status = 0;
						}
						
						//判断自身是否购买
						if($parent['sales']<$site['valid']){
							$status = 0;
						}
						M('separate_log') -> add(array(
							'user_id' => $user["parent{$i}"],
							'order_id' => $order['id'],
							'self_id' => $order['user_id'],
							'order_sn'=>$order['sn'],
							'product_id' => $product['id'],
							'level' => $i,
							'points' => $separate_points,
							'status' => $status,
							'create_time' => NOW_TIME,
							'type'=>1,
						));
						M('order') -> where(array('id'=>$order['id'])) -> setInc('separate' , 1 );	
					}
				}
			}
		}
	}
}

/*
*生成团队奖了分拥
*$total：剩余团队奖比例，首次进入获取系统设置的总比例
*/
function tward($order){
	if(!is_array($order)){
		$order = M('mch_order')->find(intval($order));
	}	
	$tward = $GLOBALS['_CFG']['tward'];
	$level = $GLOBALS['_CFG']['level'];
	if($order){
		$cart = M('cart')->where(array('id'=>array('in',$order['cart_id'])))->select();
		foreach($cart as $v){
			if($v['is_zq'] !=1){
				$product = M('product')->find(intval($v['product_id']));
				$separate = $v['nums']*((($product['price'] + $product['points']) * $product['separate'])/100);
				$user = M('user')->find(intval($order['user_id']));
				$parent = M('user')->find(intval($user['parent1']));
				$max = array_search(end($level), $level);//4
				$level = 0;
				while($parent && $level<=$max){
					if($tward[$parent['level']] && !empty($tward[$parent['level']])){
						$jc = 0;		
						//循环对上一次父级+1的等级开始
						for($i=$level+1;$i<=$parent['level'];$i++){
							$jc += $tward[$i];
						}
						if($jc>0){
							M('separate_log') -> add(array(
								'user_id' => $parent["id"],
								'order_id' => $order['id'],
								'self_id' => $order['user_id'],
								'order_sn'=>$order['sn'],
								'product_id' => $product['id'],
								'level' => $parent['level'],
								'points' => $separate*$jc/100,
								'status' => 1,
								'create_time' => NOW_TIME,
								'type'=>2,
							));
						}
					}
					$level = $parent['level'];
					if($parent['parent1']){
						$parent = M('user')->find(intval($parent['parent1']));
					}else{
						$parent = false;
					}
				}
			}
		}
	}
}



// 根据订单状态返回状态信息
function get_separate_status($status){
	$status_str = '';
	switch($status){
		case -1: $status_str = '取消分成'; break;
		case 0: $status_str = '未满足条件'; break;
		case 1: $status_str = '未支付'; break;
		case 2: $status_str = '待收货'; break;
		case 3: $status_str = '已分成'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}



// 根据订单状态返回状态信息
function get_order_status($status){
	$status_str = '';
	switch($status){
		case -2: $status_str = '已关闭'; break;
		case -1: $status_str = '申请退款'; break;
		case 1: $status_str = '待支付'; break;
		case 2: $status_str = '待发货'; break;
		case 3: $status_str = '待收货'; break;
		case 4: $status_str = '待评价'; break;
		case 5: $status_str = '已完成'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}

// 根据购物车状态返回状态信息
function get_cart_status($status){
	$status_str = '';
	switch($status){
		case -2: $status_str = '已关闭'; break;
		case -1: $status_str = '申请退款'; break;
		case 1: $status_str = '待支付'; break;
		case 2: $status_str = '待发货'; break;
		case 3: $status_str = '待收货'; break;
		case 4: $status_str = '待评价'; break;
		case 5: $status_str = '已完成'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}

// 根据订单提现申请返回状态信息
function get_withdraw_status($status){
	$status_str = '';
	switch($status){
		case -1: $status_str = '已拒绝'; break;
		case 1: $status_str = '待审核'; break;
		case 2: $status_str = '待确认'; break;
		case 3: $status_str = '已完成'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}

//获得财务记录动作名称
function get_finance_action($action){
	$return = '';
	switch($action){
		case 1: $return = '订单支付';break;
		case 2: $return = '订单分销';break;
		case 3: $return = '团队绩效';break;
		case 4: $return = '余额转出';break;
		case 5: $return = '转出退回';break;
		case 6: $return = '订单退回';break;
		case 7: $return = '分销退回';break;
		case 8: $return = '申请提现';break;
		case 9: $return = '提现退回';break;
		case 10: $return = '在线充值 ';break;
		case 11: $return = '转额度增加';break;
		case 12: $return = '商品出售';break;
		case 13: $return = '领导奖';break;
		case 14: $return = '提现重销积分';break;
		case 15: $return = '购买返重销积分';break;
		default : $return = '未知状态';	
	}
	return $return;
}


// 根据等级获取等级名称数组
function get_level_name_arr($config){
	if(!is_array($config)){
		$config = unserialize($config);
	}
	$arr = array();
	foreach($config['config'] as $v){
		$arr[] = $v['name'];
	}
	return $arr;
}


// 根据自定义菜单类型返回名称
function get_selfmenu_type($type){
	$type_name = '';
	switch($type){
		case 'click':
			$type_name = '点击推事件';
			break;
		case 'view':
			$type_name = '跳转URL';
			break;
		case 'scancode_push':
			$type_name = '扫码推事件';
			break;
		case 'scancode_waitmsg':
			$type_name = '扫码推事件且弹出“消息接收中”提示框';
			break;
		case 'pic_sysphoto':
			$type_name = '弹出系统拍照发图';
			break;
		case 'pic_photo_or_album':
			$type_name = '弹出拍照或者相册发图';
			break;
		case 'pic_weixin':
			$type_name = '弹出微信相册发图器';
			break;
		case 'location_select':
			$type_name = '弹出地理位置选择器';
			break;
		default : $type_name = '不支持的类型';
	}
	return $type_name;
}





//用户升级需要把分销未达到的奖励发放
function send_separate($user){
	if(!is_array($user)){
		$user = M('user')->find(intval($user));
	}
	$separate = M('separate_log')->where(array('status'=>0,'user_id'=>$user['id']))->select();
	if($separate){
		foreach($separate as $k=>$log){
			if($log['type'] == 1){
				M('user') -> where(array('id'=>$log['user_id'])) -> save(array(
					'points' => array('exp', 'points+'.$log['points']),
					'separate' => array('exp', 'separate+'.$log['points']),
				));		
				flog($log['user_id'], 'points', "+".$log['points'],2);
			}else if($log['type'] == 2){
				M('user') -> where(array('id'=>$log['user_id'])) -> save(array(
					'points' => array('exp', 'points+'.$log['points']),
					'tward' => array('exp', 'tward+'.$log['points']),
				));	
				flog($log['user_id'], 'points', "+".$log['points'],3);
			}	
		}
	}
	M('separate_log')->where(array('status'=>0,'user_id'=>$user['id']))->setField('status',3);
}

// 根据用户信息取得推广二维码路径信息
function get_qrcode_path($user){
	if(!is_array($user)){
		$user = M('user') -> find($user);
	}
	
	$path = './Public/qrcode/';
	return array(
			'path'		=> $path,
			'new'		=> $path.$user['id'].'_dragondean.jpg',
			'head' 		=> $path.$user['id'].'_head.jpg',
			'qrcode'	=> $path.$user['id'].'_qrcode.jpg',
			'full_path' => $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . substr($path,1)
		);
}



//获得财务记录动作名称
function get_finance_type($type){
	$return = '';
	$site = $GLOBALS['_CFG']['site'];
	switch($type){
		case 'money': $return = '账户余额记录';break;
		case 'cx_points': $return = '账户重销'.$site['points_name'].'记录';break;
		case 'points': $return = '账户'.$site['points_name'].'记录';break;
		default : $return = '未知状态';	
	}
	return $return;
}


/** 添加财务日志
*	type => value:余额记录,points:自有积分记录,cx_points:积分记录
*/
function flog($user_id, $type, $value, $action){
	M('finance_log') -> add(array(
		'user_id' => $user_id,
		'type' => $type,
		'value' => $value,
		'action' => $action,
		'create_time' => NOW_TIME
	));
}

// 确认订单
function confirm_order($order){
	if(!is_array($order)){
		$order = M('mch_order') -> find($order);
	}
	$site = $GLOBALS['_CFG']['site'];
	//if($order['status'] != 3)return;	
	
	$points = $order['points_total']*$site['points_rate']/100;
	$total = $order['total'] + $points;
	
	// 循环对分成添加到分销商账户
	$separate_logs = M('separate_log') -> where(array('order_id'=>$order['id'],'status'=>2)) -> select();
	
	if($separate_logs){
		foreach((array)$separate_logs as $log){	
			if($log['type'] == 1){
				M('user') -> where(array('id'=>$log['user_id'])) -> save(array(
					'points' => array('exp', 'points+'.$log['points']),
					'separate' => array('exp', 'separate+'.$log['points']),
				));

				flog($log['user_id'], 'points', "+".$log['points'],2);
			}else if($log['type'] == 2){
				M('user') -> where(array('id'=>$log['user_id'])) -> save(array(
					'points' => array('exp', 'points+'.$log['points']),
					'tward' => array('exp', 'tward+'.$log['points']),
				));	
				flog($log['user_id'], 'points', "+".$log['points'],3);
			}		
		}
	}
	
	//把商户的钱返回给商户
	$cart = M('cart')->where(array('status'=>3,'id'=>array('in',$order['cart_id'])))->select();
	
	if($cart){
		foreach($cart as $k=>$v){
			if($v['is_zq']!=1){
				$product = M('product')->find(intval($v['product_id']));
				$separate = ($product['price'] + $product['points'])*$product['separate']/100;
				if($separate>$product['points']){
					$ext = $separate - $product['points'];
					$mch['separate_money'] += ($product['price'] - $ext)*$v['nums'];
					$mch['separate_points'] = 0;
				}else{
					$ext = $product['points'] - $separate;
					$mch['separate_points'] += $ext*$v['nums'];
					$mch['separate_money'] +=$product['price']*$v['nums'];
				}
			}
			//返给自身的冲销积分
			$self_separate += $v['nums']*((($product['price'] + $product['points']) * $product['separate'])/100);
		}
		
		//还要返回物流费
		$mch['separate_money'] = $mch['separate_money'] + $order['logis_fee'];
	}
	
	//返给自身的冲销积分
	$cx_points = 0;
	if($site['s_points']>0 && $self_separate>0){
		$cx_points = $site['s_points'] * $self_separate / 100;
	}
	
	if($order['mch_id']>0){
		
		if($mch['separate_points']>0){
			M('user')->where(array('id'=>$order['mch_id']))->save(array(
				'points' => array('exp', 'points+'.$mch['separate_points']),
			));
			flog($order['mch_id'],'points',"+".$mch['separate_points'],12);
		}
		if($mch['separate_money']>0){
			M('user')->where(array('id'=>$order['mch_id']))->save(array(
				'money' => array('exp', 'money+'.$mch['separate_money']),
			));
			flog($order['mch_id'],'money',"+".$mch['separate_money'],12);
		}		
	}
	
	//更改订单状态
	M('mch_order') -> where(array('id' => $order['id'])) -> save(array(
		'status' => 4,
		'confirm_time' => NOW_TIME
	));
	//更改购物车状态
	M('cart') -> where(array('id' =>array('in',$order['cart_id']))) -> save(array(
		'status' => 4,
	));
	M('order')->where(array('id'=>$order['order_id']))->save(array(
		'status' => 4 // 已发货状态
	));
	
	//更新用户购买额
	M('user') -> where(array('id'=>$order['user_id'])) -> save(array(
		'sales' => array('exp', 'sales+'.$total), // 总购买额
		'cx_points' =>array('exp','cx_points+'.$cx_points),
	));
	if($cx_points>0){
		flog($order['user_id'],'cx_points','+'.$cx_points,15);
	}
	// 将分成状态设置为已完成
	 M('separate_log') -> where(array('order_id'=>$order['id'],'status'=>2)) -> setField('status', 3);
	// 更新用户登记
	update_level($order['user_id'], $GLOBALS['_CFG']['level']);
}


//退款单个商品
function cancleOneCart($cart,$order,$flag=false){
	if($cart && $order){
		if(!is_array($cart)){
			$cart = M('cart')->find(intval($cart));
		}
		if(!is_array($order)){
			$order = M('mch_order')->find(intval($order));
		}
		$site = $GLOBALS['_CFG']['site'];
		//运费
		$porder = M('order')->find($cart['order_id']);
		$addr = M('addr')->find(intval($porder['addr_id']));
		$logis_fee = 0;
		if($addr){
			$logis = M('logis')->where(array('provice'=>$addr['provice']))->find();
			if($logis){
				$fkg = $logis['fkg'];
				$ekg = $logis['ekg'];
			}else{
				$fkg = $site['fkg'];
				$ekg = $site['ekg'];
			}
			$weight = $cart['nums']*$cart['weight'];
			if($weight>1){
				$ext = ceil($weight-1);
				$logis_fee = $fkg + ($ext*$ekg);
			}elseif($weight>0 && $weight<=1){
				$logis_fee = $fkg;
			}
		}
		
		$total = $order['total'];
		$points_total = $order['points_total'];
		
		if($cart['is_zq'] == 0){
			$points = $cart['nums'] * $cart['points'];
			$price = $logis_fee + ($cart['price']*$cart['nums']);
			$total = $total - $price;			
		}else{
			$points = $cart['nums'] * $cart['zq_points']; 
			$price = $logis_fee;
			$total = $total - $logis_fee;
		}
		$points_total = $points_total - $points;
		//初始化订单数据
		$cxpointspay = (float)$order['cxpointspay'];
		$pointspay = (float)$order['pointspay'];
		$wxpay = (float)$order['wxpay'];
		$moneypay = (float)$order['moneypay'];
		//初始化用户数据
		$user_cxpoints = 0;
		$user_points = 0;
		//初始化积分需要付的钱
		$points_need = 0;
		//若重销积分大于0,先用重销积分扣除
		if($order['cxpointspay']>0){
			if($order['cxpointspay']>=$points){//若重销积分足够
				$cxpointspay = $cxpointspay - $points;
				$user_cxpoints = $points;
			}else{//重销积分不足，先减去重销积分
				$ext = $points - $cxpointspay;
				$user_cxpoints = $cxpointspay;
				$cxpointspay = 0;
				if($pointspay >=$ext){	
					$pointspay = $pointspay - $ext;
					$user_points = $ext;						
				}else{
					$points_need = ($ext - $pointspay) * $site['points_rate']/100;
					$user_points = $pointspay;
					$pointspay = 0;
				}
			}
		}else{

			if($pointspay>0){
				if($pointspay >= $points){
					$pointspay = $pointspay - $points;
					$user_points = $points;
				}else{
					$ext = $points - $pointspay;
					$points_need = $ext * $site['points_rate']/100;
					$user_points = $pointspay;						
					$pointspay = 0;	
				}
			}else{
				$points_need = $points * $site['points_rate']/100;
			}
		}			
		$price = $price + $points_need;
		if($moneypay == 0){//如果余额支付==0，则是微信支付
			$wxpay = $wxpay - $price;				
		}else{//余额支付
			if($moneypay>=$price){
				$moneypay = $moneypay-$price;
			}else{
				$moneypay = 0;
				$ext = $price - $moneypay;
				$wxpay =$wxpay - $ext;
			}
		}
		M('cart')->where(array('id'=>$cart['id']))->setField('status',-2);
		
		//如果是订单只有这一个商品，则直接取消订单
		$count = M('cart')->where(array('order_id'=>$order['order_id'],'mch_id'=>$order['mch_id'],'status'=>array('gt',-2)))->count();
		$sql = M()->getLastSql();
		file_put_contents('a.txt',$sql);
		if($count == 0 || !$count){
			M('mch_order')->where(array('id'=>$order['id']))->save(array('status'=>-2));
		}
		//取消分成
		M('separate_log')->where(array('product_id'=>$cart['product_id'],'self_id'=>$order['user_id'],'order_id'=>$order['id']))->setField('status',-1);
		
		if($flag){
			//更改订单和返回账户信息
			M('mch_order')->where(array('id'=>$order['id']))->save(array(
				'cxpointspay'=>$cxpointspay,
				'pointspay'=>$pointspay,
				'moneypay'=>$moneypay,
				'wxpay'=>$wxpay,
				'total'=>$total,
				'points_total'=>$points_total,
			));
			M('user')->where(array('id'=>$order['user_id']))->save(array(
				'cx_points' => array('exp', 'cx_points+'.$user_cxpoints),
				'points' => array('exp', 'points+'.$user_points),
				'money'=>array('exp', 'money+'.$price),
			));
			
			if($user_cxpoints >0){
				flog($order['user_id'],'cx_points', "+".$user_cxpoints,6);
			}
			if($user_points >0){
				flog($order['user_id'],'points', "+".$user_points,6);
			}
			if($price >0){
				flog($order['user_id'],'money', "+".$price,6);
			}
		}	
	}
}


//验证手机号码
function isPhone($phone) {
    if (strlen ( $phone ) != 11 || ! preg_match ( '/^1[3|4|5|7|8][0-9]\d{4,8}$/', $phone )) {
        return false;
    } else {
        return true;
    }
}
