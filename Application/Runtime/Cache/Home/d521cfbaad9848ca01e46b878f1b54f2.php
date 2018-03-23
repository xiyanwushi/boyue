<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html data-dpr="1" style="font-size: 15px;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo ($_site['name']); ?></title>
<meta name="keywords" content=""> 
<meta name="description" content="">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta name="data-spm" content="a215s">
<meta content="telephone=no,email=no" name="format-detection">
<meta content="fullscreen=yes,preventMove=no" name="ML-Config">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"> 
<link rel="shortcut icon" href="/Public/m/images/favicon.ico" type="image/x-icon">
<link href="/Public/m/css/newall.css" rel="stylesheet" type="text/css">
<link href="/Public/layer/skin/layer.css" rel="stylesheet" type="text/css">
<script src="/Public/js/jquery-1.7.min.js"></script>
<script src="/Public/layer/layer.js"></script>
</head>
<body style="font-size: 12px; background: rgb(255, 255, 255);">
<link rel="stylesheet" type="text/css" href="/Public/m/css/buy.css">
<link rel="stylesheet" type="text/css" href="/Public/m/css/orderdetail.css">
<header>
	<div class="m_common_new_top">
		<div id="m_common_header">
			<header class="header">
				<div class="header-new-bar">
					<div id="m_common_header_goback" class="header-icon-back">
						<a href="javascript:history.go(-1)"><span></span></a>
					</div>
					<div class="header-title" id="headerTitle">产品详情</div>
					<div id="m_common_header_jdkey" class="header-icon-shortcut L_ping">
						<a class="click" id="click_common_header_shortcut" onclick="headerShortcut();">
							<span></span>
						</a>
					</div>
					<div class="header-bar-border"></div>
				</div>
				<ul id="m_common_header_shortcut" class="header-shortcut" style="display: none;">
					<li id="m_common_header_shortcut_m_index">
						<a class="L_ping" href="<?php echo U('Index/index');?>">
							<span class="shortcut-home"></span>
							<strong>首页</strong>
						</a>
					</li>
					<li class="L_ping" id="m_common_header_shortcut_category_search">
						<a href="<?php echo U('Index/cates');?>">
							<span class="shortcut-categories"></span>
							<strong>分类</strong>
						</a>
					</li>
					<li class="L_ping" report-eventid="MCommonHead_Cart" id="">
						<a href="<?php echo U('Index/cart');?>">
							<span class="shortcut-cart"></span>
							<strong>购物车</strong>
						</a>
					</li>
					<li id="m_common_header_shortcut_h_home" class=" current">
						<a class="L_ping" href="<?php echo U('My/index');?>">
							<span class="shortcut-my-account"></span>
							<strong>个人中心</strong>
						</a>
					</li>
				</ul>
			</header>
		</div>
	</div>
</header>
<script>
	var title ="订单详情";
	if(title!=''){
		$('#headerTitle').html(title);
	}
	function headerShortcut(){
		$('.header-shortcut').toggle();
	}
</script>
<style>
.wul {
    position: absolute!important;
    right: 18%;
    width: 60px;
    background: #D48A1D;
    line-height: 20px;
    text-align: center;
    color: #fff;
    border-radius: 4px;
    top: 28%;
    font-size: 12px;
}
.item .price {
    font-size: 1.45rem;
}
.status-2{
	float: right;
    position: absolute;
    right: 0;
    bottom: 15px;
    width: 120px;
    text-align: center;
    line-height: 22px;
    background: #FF5722;
    color: #fff;
    border-radius: 3px;
    font-size: 12px;
}
</style>
<section class="content">
	<div class="active">
		<div class="wrap order-buy">
			<div class="mainCont" id="checkMain">
				<section class="order " id="order15">
					<section class="order-info" style="border-bottom:none">
						<div class="b-box">
							<p class="title">订单号：<?php echo ($info['sn']); ?> </p>
							<p class="title">下单时间：<?php echo (date("Y-m-d H:i:s",$info['create_time'])); ?></p>
						</div>
						<div class="order-list">
							<ul class="order-list-info">
								<?php if(is_array($info['cart'])): foreach($info['cart'] as $key=>$v): ?><li class="item " id="item14">
									<?php if($v['status'] != 1 and $v['status'] < 4): ?><span class="cart-checkbox" onclick="deleteOrder(<?php echo ($v['id']); ?>,<?php echo ($info['id']); ?>);"></span><?php endif; ?>
									<div class="itemInfo list-info" id="itemInfo13">	
										<div class="list-img" style="position:relative;">
											<a href="<?php echo U('Index/product',array('id'=>$v['product_id']));?>">
												<img src="<?php echo ($v['pic']); ?>">
											</a>
										</div>
										
										<div class="list-cont" style="position:relative;">
											<h5 class="goods-title"><?php echo ($v['title']); ?></h5>
											<p class="godds-specification">运费:<?php echo ($v['logis_fee']); ?> 
												<?php if($v['is_zq'] != 1): ?><br>单件最高抵扣积分:<?php echo ($v['points']); endif; ?>
											</p>
											<div class="itemPay list-price-nums" id="itemPay6">
												<?php if($v['is_zq'] != 1): ?><p class="price">¥<?php echo ($v['price']+($v['points']*$_site['points_rate']/100)); ?></p>
												<?php else: ?>
													<p class="price">∮<?php echo ($v['zq_points']); ?></p><?php endif; ?>												
												<p class="nums">x<?php echo ($v['nums']); ?></p>
												<?php if($v['status'] == -1): ?><span class="status-2">申请退货，等待审核</span><?php endif; ?>
												<?php if($v['status'] == 4): ?><span class="status-2" onclick="popShow(<?php echo ($v['product_id']); ?>,<?php echo ($v['id']); ?>);" style="width:70px;">评价该商品</span><?php endif; ?>
											</div>
										</div>
									</div>
								</li><?php endforeach; endif; ?>
							</ul>
							
							<div class="b-box">
								<div class="interpret multi-select">
									<span class="total-text">共</span>
									<em><?php echo ($nums); ?></em>
									<span class="total-text" style="margin-right:12px;">件商品</span> 
									
									<?php echo ($_site['points_name']); ?>：<?php echo ($info['points_total']); ?>
										价格：<strong class="price red">￥<?php echo ($info['total']); ?></strong>
								</div>
								
							</div>
							<section class="address noarrow" id="address7" style="background:none; border-bottom:1px solid #e0e0e0; margin-bottom:0">
								<div class="address-info" id="J_address">
										<p class="address-name"><?php echo ($addr['name']); ?></p>
										<p class="address-phone"><?php echo ($addr['mobile']); ?></p>
								</div>
								<div class="address-details"><?php echo str_replace('||',' ', $addr['district']);?> <?php echo ($addr["addr"]); ?></div>
							</section>
							<div class="b-box">
								<p class="title">支付方式</p>
								<div class="interpret multi-select">
								<?php if($info['payway'] == 1): ?>微信支付
								<?php else: ?>
									余额支付<?php endif; ?>
								</div>
							</div>
							<div class="b-box">
								<p class="title">订单状态</p>
								<div class="interpret multi-select">
									<?php if($info['status'] > 2): ?><div class="wul" onclick="wuliu(this);" _express="<?php echo ($info['express']); ?>" _expressno="<?php echo ($info['express_no']); ?>">物流信息</div><?php endif; ?>	
									<?php echo get_order_status($info['status']);?>
								</div>
							</div>
							<script>
								function wuliu(ob){
									var express = $(ob).attr("_express");
										expressno = $(ob).attr('_expressno');
									location.href="https://m.kuaidi100.com/index_all.html?type="+express+"&postid="+expressno;
								}
							</script>
							<div class="b-box">
								<p class="title">留言</p>
								<div class="interpret multi-select"><?php echo ($info['msg']); ?></div>
							</div>
							<?php if($info['status'] == 1): ?><!--未支付时显-->
								<div class="b-box">
									<a class="c-btn-oran  c-btn-r" href="javascript:cancleOrder(<?php echo ($info['id']); ?>);">取消订单</a>
									<a class="c-btn-oran" href="<?php echo U('My/pay',array('order_id'=>$info['id']));?>">立即支付</a>
								</div><?php endif; ?>
							<?php if($info['status'] == 2): ?><div class="b-box">
									<a class="c-btn-oran  c-btn-r" style="margin: 0 auto;width: 100%;" href="javascript:cancleOrder(<?php echo ($info['id']); ?>);">取消订单</a>
								</div><?php endif; ?>
							<?php if($info['status'] == 3): ?><div class="b-box">
									<a class="c-btn-oran  c-btn-r" href="javascript:cancleOrder(<?php echo ($info['id']); ?>);">取消订单</a>
									<a class="c-btn-oran" href="javascript:confirmOrder(<?php echo ($info['id']); ?>);">立即收货</a>
								</div><?php endif; ?>
							
						</div>
					</section>
				</section>
			</div>
		</div>
	</div>
</section>

<div style="clear:both;height:2rem"></div>
<div class="popable" id="userComment" style="position: fixed;width: 100%;height: 100%;top: 0%;display: -webkit-box;left: 0%;z-index: 999999;line-height: 20px;background: #fff;overflow-y: scroll;padding: 10px;font-size: 0.8em;display:none;">
	<a href="javascript:$('#userComment').hide();" style="position: fixed;right: 20px;top: 10px;">X</a>
	<div class="popableInner">
		<div class="clearfix">
			<span class="left" style="float: left;">商品质量评分：</span>
			<ul id="score_rep" class="rating left star5" style="float: left;" onmouseout="onStar(this);">
				<li class="one"><a title="1分" name="point"   onclick="onstarclick(this);" onmouseover="onStar(this);">1</a></li>
				<li class="two"><a title="2分" name="point"   onclick="onstarclick(this);" onmouseover="onStar(this);">2</a></li>
				<li class="three"><a title="3分" name="point" onclick="onstarclick(this);" onmouseover="onStar(this);">3</a></li>
				<li class="four"><a title="4分" name="point"  onclick="onstarclick(this);" onmouseover="onStar(this);">4</a></li>
				<li class="five"><a title="5分" name="point"  onclick="onstarclick(this);" onmouseover="onStar(this);">5</a></li>
			</ul> 
			<input id="score" name="score" type="hidden" value="5"><br>			
		</div>
		<div style="height:10px"></div>
		<textarea id="content" cols="20" rows="5" class="w400" maxlength="150" style="width: 100%;border: 1px solid #999;display: -webkit-box;margin: 15px auto;"></textarea>
		<div class="clearfix">
			<p class="faceTittle" onclick="comment();" style="text-align: center;width:100%;background: #9b0001;padding: 2px;">
				<a href="javascript:;" class="bluesbtn right" style="color:#fff;font-size:15px;">
					发表评论
				</a>
			</p>				 
			<p class="faceTittle" onclick="javascript:$('#userComment').hide();" style="text-align: center;width:100%;background: #999;padding: 2px;margin: 10px 0;">
				<a class="closeWin closepop1" style="color:#fff;font-size:15px;">取消评论</a>
			</p>
			<span class="gray2" style="font-size:14px;"> 字数不超过150个字符 </span>
		</div>
		<input type="hidden" id="txtOrderId" value="0">
		<input type="hidden" id="txtProId" value="1751">
		<input type="hidden" id="txtOrderCode" value="">
		<ul style="margin:0; padding:0;font-size: 12px;">
			<li><strong>在您发表评论之前，请注意以下几点 </strong></li>
			<li>1、不仅评价商品的好或不好，更重要的是阐述自己的观点和理由以帮助其他客户判断商品是否适合自己。 </li>
			<li>2、我们鼓励您的原创评论，未经授权的文字请勿转载。 </li>
			<li>3、有关订单和送货等购物过程的问题，请查看帮助中心，或者联系客服。 </li>
			<li>4、不得发表违反国家相关法律的言论。 </li>
			<li>5、管理员有权删除违反上述要求的内容。 </li>
		</ul>
	</div>
</div>
<div class="mask" id="loading">
	<img src="/Public/m/images/loading-grey.gif" style="position: fixed;_position:absolute;margin-left:-20px;left:50%;top:45%;">
</div>
<div style="clear:both;height:4.5rem;"></div>
<div class="floor bottom-bar-pannel" id="floor-bottom-bar-pannel-id">
	<div class="floor-container ">
		<ul class="tab4">
			<li>
				<span class="bar-img">
					<a class="J_ping" href="<?php echo U('Index/index');?>">
					<img src="/Public/m/images/icon-home01.png"></a>
				</span>
			</li>
			<li>
				<span class="bar-img">
					<a class="J_ping" href="<?php echo U('Index/cates');?>">
						<img src="/Public/m/images/icon-catergry.png">
					</a>
				</span>
			</li>
			<li>
				<span class="bar-img">
					<a class="J_ping" href="<?php echo U('Index/cart');?>">
						<img src="/Public/m/images/icon-cart.png">
					</a>
				</span>
			</li>
			<li>
				<span class="bar-img">
					<a class="J_ping" href="<?php echo U('My/index');?>">
					<img src="/Public/m/images/icon-me.png">
				</a>
				</span>
			</li>
		</ul>
	</div>
</div>

<div id="indexToTop" style="display: none; width:3em; position:fixed;bottom:100px; right:20px; z-index:999;">
	<img src="/Public/m/images/scroll-to-top-icon.png" style="width: 100%;">
</div>
<div style="display:none; position:absolute; top:-9999px; left:-9999px;">
	<img src="" _src="<?php echo U('Ajax/data');?>" id="lazyload" />
</div>
<script>
	var topBtn = document.getElementById('indexToTop');
	window.onscroll = function () {
		// 获取页面向上滚动距离，chrome浏览器识别document.body.scrollTop，而火狐识别document.documentElement.scrollTop，这里做了兼容处理
		var toTop = document.documentElement.scrollTop || document.body.scrollTop;
		// 如果滚动超过300，返回顶部按钮出现，反之隐藏
		if(toTop>=300){
			topBtn.style.display = 'block';
		}else {
			topBtn.style.display = 'none';
		}
	}
	topBtn.onclick=function () {
		var timer = setInterval(function () {
			var toTop = document.documentElement.scrollTop || document.body.scrollTop;
			// 判断是否到达顶部，到达顶部停止滚动，没到达顶部继续滚动
			if(toTop == 0){
				clearInterval(timer);
			}else {
				// 设置滚动速度
				var speed = Math.ceil(toTop/5);
				// 页面向上滚动
				document.documentElement.scrollTop=document.body.scrollTop=toTop-speed;
			}
		},50);
	}
	
	$("#lazyload").attr('src',$("#lazyload").attr('_src'));
</script>

<script src="/Public/m/js/orderDetail.js"></script>
</body>
</html>