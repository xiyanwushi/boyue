<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}
</style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
<meta name="format-detection" content="telephone=no, address=no">
<title><?php echo ($_site['name']); ?></title>
<link href="/Public/m/css/newall.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="/Public/css/common.css">
<link rel="stylesheet" type="text/css" href="/Public/css/app.css">
<link rel="stylesheet" type="text/css" href="/Public/css/font.css">
<link rel="stylesheet" type="text/css" href="/Public/m/css/mch.css">
<link href="/Public/layer/skin/layer.css" rel="stylesheet" type="text/css">
<link href="/Public/css/mobiscroll.css" rel="stylesheet" type="text/css">
<script src="/Public/js/jquery-1.7.min.js"></script>
<script src="/Public/js/mobiscroll.js" charset="utf-8" type="text/javascript"></script>
<script src="/Public/layer/layer.js"></script>

</head>
<body bgcolor="#f2f2f2">
	<div class="agent-money clr">
		<dl>
			<dt>
				<span>分销团队<?php echo ($_site['points_name']); ?>：<?php echo ((isset($points) && ($points !== ""))?($points):"0.00"); ?>元</span>
				<i class="iconfont icon-right" style="float: right;"></i>
			</dt>
			<dd style="margin:-32px 0">
				<p>预收<?php echo ($_site['points_name']); ?>：<?php echo ((isset($yj_points) && ($yj_points !== ""))?($yj_points):"0.00"); ?>元</p>
			</dd>
			<dd style="margin:-32px 0">
				<p>代理级别：<?php echo ($_level[$user['level']]['name']); ?></p>
			</dd>
			<dd><p>可提现（元）</p></dd>
			<dd class="clr"><b><?php echo ($user['money']); ?></b><button onclick="window.location.href=&#39;<?php echo U('My/money');?>&#39;">提现</button></dd>
		</dl>
		
	</div>
	<div class="agent-list clr">
		<ul>
			<li onclick="window.location.href=&#39;<?php echo U('Mch/money',array('type'=>1));?>&#39;">
				<span class="zero"><i class="iconfont icon-jifen"></i></span>
				<p>分销明细</p>
				<span><?php echo ((isset($points1) && ($points1 !== ""))?($points1):"0.00"); ?></span>元
			</li>
			<li onclick="window.location.href=&#39;<?php echo U('Mch/money',array('type'=>2));?>&#39;">
				<span class="zero"><i class="iconfont icon-jifen"></i></span>
				<p>团队明细</p>
				<span><?php echo ((isset($points2) && ($points2 !== ""))?($points2):"0.00"); ?></span>元
			</li>
			<li onclick="window.location.href=&#39;<?php echo U('My/team');?>&#39;">
				<span class="zero"><i class="iconfont icon-team"></i></span>
				<p>团队有效代理</p>
				<span><?php echo ($son); ?></span>人
			</li>
			
			<li onclick="window.location.href=&#39;<?php echo U('Mch/order');?>&#39;">
				<span class="zero"><i class="iconfont icon-dodeparent"></i></span>
				<p>商户订单</p>

			</li>
			<li onclick="$('#OutOf').toggle();">
				<span class="zero"><i class="iconfont icon-community"></i></span>
				<p>温馨提示</p>				
			</li>
			<li onclick="window.location.href=&#39;<?php echo U('Mch/xy');?>&#39;">
				<span class="zero"><i class="iconfont icon-iconfontbangzhu"></i></span>
				<p><?php if($user['ismch'] != 0): ?>商户资料<?php else: ?>申请商户<?php endif; ?></p>				
			</li>
		</ul>
	</div>
<div class="coverBG3" id="OutOf" style="display: none;" style="z-index:9999">
<div class="coverBG3" style="z-index:99">
	<ul class="cover2">
		<li class="coverCon">
			<div class="coverConBanzhang">
				<img class="coverConBanzhangClose" src="/Public/m/images/close2.png" onclick="$('#OutOf').toggle();">
				<p class="coverConBanzhangTitle"><b>温馨提示</b></p>
				<div class="coverConBanzhangCon">
					<p>1.商户可在电脑端输入http://<?php echo ($_SERVER['SERVER_NAME']); ?>/mch.php进入电脑端商户后台</p>
						
					<p>2.商户在电脑端输入网址后，需用本商户的微信扫码进入商户后台</p>
				</div>
			</div>
		</li>
	</ul>
</div>
</div>	

<div id="backtop"><i class="iconfont icon-fold"></i></div>
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