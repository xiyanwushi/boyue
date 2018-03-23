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
<link href="/Public/m/css/iscroll.css" rel="stylesheet" type="text/css">
<link href="/Public/m/css/record.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/Public/m/js/iscroll.js"></script>
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
	var title ="我的账户";
	if(title!=''){
		$('#headerTitle').html(title);
	}
	function headerShortcut(){
		$('.header-shortcut').toggle();
	}
</script>
<style>
#wrapper {
    top: 154px!important;
	margin-bottom:50px;
.sep{
	margin: 0 auto;
    display: block;
    width: 150px;
    height: 22px;
    background: #FF9;
    margin-top: 3px;
    line-height: 22px;
    color: #c40001;
    border-radius: 5px;
    text-align: center;
	font-size: 12px;
</style>
<div style="display: block;margin-top: 44px;" class="landscape">
	<div class="main">
	    <div class="mb-os">
	    	<ul>
				<li style="line-height:22px;height:80px;background: #c40001;text-align: left;padding-left: 5px;color:#fff;border-bottom: 1px solid #A96C6C;margin-top:10px;">
					<div style="width:65%;float:left;margin-top:7px;margin-left:5px;">
						余额规则说明：满<?php echo ($_withdraw['money_ext']); ?>方可提现且必须<?php echo ($_withdraw['money_per']); ?>的整数倍，
						提现手续费<?php echo ($_withdraw['money_lv']); ?>%，最高手续费为：<?php echo ($_withdraw['money_max']); ?>
					</div>
					<div style="float:left;width:30%">
						<a href="<?php echo U('My/recharge');?>"  class="w-btn">余额充值</a>
						<a href="javascript:;" onclick="withdraw(1);" class="w-btn">余额提现</a>
						<!--<a href="javascript:;" onclick="$('.popup').toggle();" class="w-btn">积分转让</a>-->
					</div>
				</li>
	       		<li style="line-height: 30px;background: #c40001;text-align: left;padding-left: 5px;color:#fff">
	       			<table width=100%>
						<tr align="center">
							<th width=50%>共有余额:&nbsp; &nbsp;  <b style="font-size:1.8em; color:#FC3"><?php echo ($user['money']); ?></b>&nbsp;元 </th>
							<th>可提现:&nbsp; &nbsp; <b style="font-size:1.8em;color:#FC3">¥<?php echo ($user['money']); ?></b>&nbsp;元</th>
						</tr>
					</table>
	       		</li>
			</ul>
	    </div>
     	<div class="c-clild">
			<div class="mainCont">
				<div id="wrapper" style="overflow: hidden; left: 0px;">
					<div id="scroller" style="transform-origin: 0px 0px 0px; position: absolute; top: 0px; left: 0px;">
						<ul class="rd">
							
						</ul>
						<div class="more"><i class="pull_icon"></i><span>上拉加载...</span></div>
					</div>
					<div></div>
				</div>
			</div>
		</div>
		
	</div>
</div>
<!--  -->
<div class="mask" id="loading"><img src="/Public/m/images/loading-grey.gif" style="position: fixed;_position:absolute;margin-left:-20px;left:50%;top:45%;"></div>
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
	var type = 'money';
</script>
<script type="text/javascript" src="/Public/m/js/record.js"></script>
</body>
</html>