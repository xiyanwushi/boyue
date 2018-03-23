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
<body style="font-size: 12px; background: #f5f5f5;">
<link href="/Public/m/css/my.css" rel="stylesheet" type="text/css">
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
	var title ="个人中心";
	if(title!=''){
		$('#headerTitle').html(title);
	}
	function headerShortcut(){
		$('.header-shortcut').toggle();
	}
</script>
<div style="display: block;margin-top: 44px;" class="landscape">
    <div class="main">
        <div class="mb-user">
            <a href="<?php echo U('My/sync_profile');?>"><img src="<?php echo ($user['headimg']); ?>" class="touxiang" width="20px"></a>
            <p><?php echo ($user['nickname']); ?></p>
            <p>
                <?php if($user['mobile']): echo ($user['mobile']); ?>
                    <?php else: ?><a style="color:#8B65DD" href="<?php echo U('My/profile');?>">立即认证</a><?php endif; ?>
            </p>
            <a href="<?php echo U('My/level1');?>" class="level"><span class="title"><?php echo ($_level[$user['level']]['name']); ?></span></a>
            <div class="mb-os" background-color="#f15353">
                <ul>
                    <li>
                        <a href="#" class="fragment">
                            <font style="font-size: 1rem;color: #000;"><?php echo ($user['money']); ?></font>
                            <br>余额 </a>
                    </li>
                    <li>
                        <a href="#" class="fragment">
                            <font style="font-size: 1rem;color: #000;"><?php echo ($user['points']+$user['cxpoints']+$separate_no); ?></font>
                            <br>乐币 </a>
                    </li>
                    <li  ><!--style="line-height: 40px;"-->
					<a  href="#" class="fragment">
                        <font style="font-size: 1rem;color: #000;"><?php echo ($user['frozen']); ?></font>
                            <br><font  class="fragment" >冻结积分 </font>
					</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 订单开始 -->
        <div class="user_center">
            <div class="Order_form">
                <div class="title_name">订单管理 <a href="<?php echo U('My/order');?>"><font style="text-indent:15px;text-align:right;"><i>所有订单＞&nbsp;&nbsp;&nbsp;</i></font></a></div>
                <ul class="Menu_list">
                    <li>
                        <a href="<?php echo U('My/order');?>"><img src="Public/m/images/icon_user_01.png" />
                            <h5>待付款</h5></a>
                    </li>
                    <li>
                        <a href="<?php echo U('My/order',array('status'=>3));?>"><img src="Public/m/images/icon_user_02.png" />
                            <h5>待发货</h5></a>
                        <!--em class="Number">1</em-->
                    </li>
                    <li>
                        <a href="<?php echo U('My/order',array('status'=>1));?>"><img src="Public/m/images/icon_user_03.png" />
                            <h5>待收货</h5></a>
                    </li>
                    <li>
                        <a href="<?php echo U('My/order',array('status'=>4));?>"><img src="Public/m/images/icon_user_pj.png" />
                            <h5>待评价</h5></a>
                    </li>
                </ul>
            </div>
            <div class="menu_Manager clearfix ">
			 <div class="title_name" style="text-indent:20px;height:36px;border-bottom:solid 1px #f5f5f5;line-height: 36.8px;font-size:0.857rem;font-weight:bolder">基础工具</div>
               <!--  <a href="user_Red_packets.html"><img src="Public/m/images/icon_user_05.png" />
                    <h5>红包</h5></a> -->
				<a href="<?php echo U('Points/index');?>"><img src="Public/m/images/Aftermarket.png" />
                    <h5>积分商城</h5></a>
				<a href="<?php echo U('My/money');?>"><img src="Public/m/images/icon_users_04.png" />
                    <h5>余额管理</h5></a>
                <a href="<?php echo U('My/points');?>"><img src="Public/m/images/icon_user_08.png" />
                    <h5>乐币管理</h5></a>
					
                <a href="<?php echo U('My/profile');?>"><img src="Public/m/images/icon_user_10.png" />
                    <h5>个人信息</h5></a>
                <a href="<?php echo U('My/addr');?>"><img src="Public/m/images/icon_users_09.png" />
                    <h5>地址管理</h5></a>
                <a href="<?php echo U('My/Favorite');?>"><img src="Public/m/images/icon_user_06.png" />
                    <h5>收藏</h5></a>
                <a href="#"><img src="Public/m/images/icon_kf.png" />
                    <h5>售后服务</h5></a>
                 <a href="#"><img src="Public/m/images/icon_users_08.png" />
                    <h5>提现管理</h5></a>
            </div>
            <div class="Distribution_M">
                <div class="title_name">推广管理</div>
                <ul class="Menu_list">
                    <li>
                        <a href="<?php echo U('My/qrcode');?>"><img src="Public/m/images/icon_users_06.png.png" />
                            <h5>我的推广码</h5></a>
                    </li>
                    <?php if($user['level'] > 0): ?><li>
                        <a href="<?php echo U('Mch/index');?>"><img src="Public/m/images/icon_fx_dp.png" />
                            <h5>我的店铺</h5></a>
                    </li><?php endif; ?>
                    <li>
                        <a href="<?php echo U('My/team');?>"><img src="Public/m/images/team.png" />
                            <h5>我的推广</h5></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 订单结束 -->
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

</body>

</html>