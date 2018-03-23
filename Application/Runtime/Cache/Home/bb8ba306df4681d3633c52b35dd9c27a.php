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
<script>
$(function(){
	//初始化缩小html的size
	$('html').css('font-size','15px');
});
</script>
<link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/Public/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/store.css?2016" rel="stylesheet" type="text/css" />
<div class="header-blank"></div>
<div class="header" style="background:#000">
	添加收货地址
	<span class="left">
		<a href="javascript:;" onclick="window.history.go(-1)"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
	</span>
</div>

<div class="addradd-main">
	<form method="post">
		<div class="addradd-item">
			联系人姓名<br/>
			<input type="text" name="name" />
		</div>
		<div class="addradd-item">
			联系人手机<br/>
			<input type="text" name="mobile" />
		</div>
		<div class="addradd-item">
			所在地区<br/>
			<select id="dist">
				<option value="">请选择</option>
			</select>
			<input type="hidden" class="select_value" name="district" />
		</div>
		<div class="addradd-item">
			详细地址<br/>
			<input type="text" name="addr" />
		</div>
		
		<div class="addradd-btn">
			<input type="submit" value="保存地址" />
		</div>
	</form>
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

<script src="/Public/js/district-all.js" type="text/javascript"></script>
<script src="/Public/js/linkagesel-min.js" type="text/javascript"></script>
<script>
var opts = {
		data: districtData,     // districtData为district-all.js中定义的变量
		select:  '#dist',
		selClass:'select-fix-width',
		head:'请选择',
		fixWidth:'100%'
};
var linkageSel = new LinkageSel(opts);
districtData = opts = null; // 如果数据量大最好在创建LinkageSel实例之后清空
linkageSel.onChange(function() {
	d = this.getSelectedDataArr('name'),    // 所有有选定菜单的name. this === linkageSel2
	arr = [];
	select_value = $(".select_value");
	for (var i = 0, len = d.length; i < len; i++) {
		arr.push(d[i]);
	}
	select_value.val(arr.join('||'));
	$(".addradd-item select").css('width', '100%');
});
</script>

</body>
</html>