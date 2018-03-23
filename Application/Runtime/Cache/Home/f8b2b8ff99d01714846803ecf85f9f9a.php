<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
<title>微信安全支付</title>
<link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/Public/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/store.css?bc" rel="stylesheet" type="text/css" />
<link href="/Public/css/user.css" rel="stylesheet" type="text/css" />
<link href="/Public/m/css/newall.css" rel="stylesheet" type="text/css" />
<link href="/Public/layer/skin/layer.css" rel="stylesheet" type="text/css">
<script src="/Public/js/jquery-1.7.min.js"></script>
<script src="/Public/layer/layer.js"></script>

</head>
<style>
.pay-info p{font-size:14px;line-height:14px;margin-top:5px;margin-bottom:10px;}
.header {color: #fff;}
</style>
<body>
	<div class="header-blank"></div>
    <div class="header">
		订单安全支付
	</div>
	
	<div class="pay-main">
		<div class="pay-tips">点击立即支付可进行付款</div>
		<div class="pay-info">
			<p>
				订单在线支付,金额：￥<?php echo ($info['wxpay']); ?>
			</p>
			<p>
				订单编号：<?php echo ($info['sn']); ?>
			</p>
			<p>
				支付说明：系统优先使用自身的重销<?php echo ($_site['points_name']); ?>支付<?php echo ($_site['points_name']); ?>，
					若重销<?php echo ($_site['points_name']); ?>不足，则使用自身<?php echo ($_site['points_name']); ?>支付<?php echo ($_site['points_name']); ?>，
					若重销<?php echo ($_site['points_name']); ?>和自身<?php echo ($_site['points_name']); ?>都不足支付<?php echo ($_site['points_name']); ?>，则可使用现金比例进行支付。
			</p>
		</div>
		
		<div class="pay-repay" id="pay" style="display:block">
			<a href="javascript:;" onclick="doPay()">立即支付</a>
		</div>
		<div class="pay-repay" id="repay">
			<a href="javascript:;" onclick="doPay()">重新支付</a>
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

	<script type="text/javascript">
		function doPay(){
			$('#pay').hide();
			$.post("<?php echo U('My/dopay');?>",{order_id:"<?php echo ($info['id']); ?>"},function(d){
				if(d){
					console.log(d);
					if(d.status){
						var jsApiParameters = eval('(' +d.info + ')');
						WeixinJSBridge.invoke(
							'getBrandWCPayRequest',
							jsApiParameters,
							function(res){
								WeixinJSBridge.log(res.err_msg);
								if(res.err_msg == "get_brand_wcpay_request:ok"){
									location.href="<?php echo U('My/orderDetail');?>&order_id="+"<?php echo ($info['id']); ?>";
								}else if(res.err_msg == "get_brand_wcpay_request:cancel"){
									$('#repay').show();		
								}else{
									layer.alert("调用微信支付失败："+res.err_msg);
									$('#repay').show();
								}
							}
						);
					}else{
						layer.msg(d.info,{icon:5});
					}
				}else{
					layer.msg('网络异常',{icon:5});
				}				
			})
		}
	</script>
</body>
</html>