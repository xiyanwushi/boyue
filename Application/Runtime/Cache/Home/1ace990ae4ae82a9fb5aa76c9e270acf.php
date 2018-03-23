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
.item .price {
    font-size: 1.45rem;
}
.order-buy .order-info .order-list-info .list-info {
    padding: 4px 0px 0px 4px;
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
									<div class="itemInfo list-info" id="itemInfo13">
										<div class="list-img">
											<a href="<?php echo U('Index/product',array('id'=>$v['product_id']));?>">
												<img src="<?php echo ($v['pic']); ?>">
											</a>
										</div>
										
										<div class="list-cont">
											<h5 class="goods-title"><?php echo ($v['title']); ?></h5>
											<p class="godds-specification">运费:<?php echo ($v['logis_fee']); ?> 
												<?php if($v['is_zq'] != 1): ?><br>所需积分:<?php echo ($v['points']); endif; ?>
											</p>
											<div class="itemPay list-price-nums" id="itemPay6">
												<?php if($v['is_zq'] != 1): ?><p class="price">¥<?php echo ($v['price']); ?></p>
												<?php else: ?>
													<p class="price">∮<?php echo ($v['zq_points']); ?></p><?php endif; ?>
												
												<p class="nums">x<?php echo ($v['nums']); ?></p>
												<?php if($v['status'] == -1): ?><span class="status-2" onclick="pShow(<?php echo ($v['id']); ?>,<?php echo ($info['id']); ?>)">操作退货</span><?php endif; ?>
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
									合计:<strong class="price red">￥<?php echo ($info['total']); ?></strong>
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
								<?php if($info['payway'] == 1): ?>余额支付
								<?php else: ?>
									微信支付<?php endif; ?>
								</div>
							</div>
							<div class="b-box">
								<p class="title">订单状态</p>
								<div class="interpret multi-select"><?php echo get_order_status($info['status']);?></div>
							</div>
							<div class="b-box">
								<p class="title">留言</p>
								<div class="interpret multi-select"><?php echo ($info['msg']); ?></div>
							</div>
							<?php if($info['status'] == 2): ?><div class="b-box">
									<a class="c-btn-oran  c-btn-r" href="javascript:;" onclick="cancelOrder();">取消订单</a>
									<a class="c-btn-oran" href="javascript:ppShow();">立即发货</a>
								</div><?php endif; ?>							
						</div>
					</section>
				</section>
			</div>
		</div>
	</div>
</section>
<div style="height:2rem"></div>
<div class="mask" id="loading">
	<img src="/Public/m/images/loading-grey.gif" style="position: fixed;_position:absolute;margin-left:-20px;left:50%;top:45%;">
</div>


<div class="popup" id="p1" style="display:none">
	<div>
		<div class="co-list" style="height:40px;">
			<div class="col-a" style="height:40px;">
				<span class="col-span" style="float: left;margin-top: 3%;padding-left:10%;">选择</span>
				<select name="choose" id="choose">
					<option value="">请选操作</option>
					<option value="1">同意退货</option>
					<option value="2">拒绝退货</option>
				</select>
			</div>
		</div>
		<input style="background:#FF5722;" value="确定" onclick="cancleOne();" type="button" />
		<input class="reset" onclick="pShow()" value="取消" type="button" />
	</div>
</div>


<div class="popup" id="p2" style="display:none">
	<div>
		<div class="co-list" style="height:80px;">
			<div class="col-a" style="height:40px;">
				<span class="col-span" style="float: left;margin-top: 3%;">快递公司：</span>
				<input type="text" class="col-aaa fl money put" id="express" value=""  placeholder="输入快递公司">
			</div>
			<div class="col-a" style="height:40px;">
				<span class="col-span" style="float: left;margin-top: 3%;">快递单号：</span>
				<input type="text" class="col-aaa fl money put" id="express_no" value=""  placeholder="输入快递单号">
			</div>
		</div>
		<input style="background:#FF5722;" value="确定发货" onclick="express();" type="button" />
		<input class="reset" onclick="ppShow()" value="取消" type="button" />
	</div>
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

<script>
//显示发货
var cart_id,order_id;
function pShow(cid,oid){
	cart_id = cid;
	order_id = oid;
	if($('#p1').css('display') == 'none'){
		$('#p1').show();
	}else{
		$('#p1').hide();
	}
	
}


function ppShow(oid){
	if($('#p2').css('display') == 'none'){
		$('#p2').show();
	}else{
		$('#p2').hide();
	}
	
}

//取消单个商品
function cancleOne(){
	if(cart_id && order_id){
		var choose = $('#choose option:selected').val();
		if(!choose){
			layer.msg('请选择操作');
			return false;
		}
		$.post("<?php echo U('Mch/cancleOne');?>",{choose:choose,cart_id:cart_id,order_id:order_id},function(d){
			if(d){
				$('#p1').hide();
				console.log(d);
				if(d.status == 1){
					layer.alert(d.info,function(){
						if(d.url){
							location.href=d.url;
						}
					});
				}else{
					layer.msg(d.info);
					layer.closeAll();
				}
			}else{
				layer.msg('网络异常',{icon:5});
			}
		});
	}
}

//发货
function express(){
	var name = $('#express').val();
		no = $('#express_no').val();
	if(name==''){
		layer.msg('请输入快递公司');
		return false;
	}
	if(no==''){
		layer.msg('请输入快递单号');
		return false;
	}
	$.post("<?php echo U('Mch/send_express');?>",{order_id:"<?php echo ($info['id']); ?>",name:name,no:no},function(d){
		if(d){
			$('#p2').hide();
			console.log(d);
			if(d.status == 1){
				layer.alert(d.info,function(){
					location.reload();
				});
			}else{
				layer.msg(d.info);
				layer.closeAll();
			}
		}else{
			layer.msg('网络异常',{icon:5});
		}
	});
}
</script>
</body>
</html>