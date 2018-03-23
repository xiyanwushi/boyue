<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>全部商品</title>
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta name="data-spm" content="a215s">
<meta content="telephone=no,email=no" name="format-detection">
<meta content="fullscreen=yes,preventMove=no" name="ML-Config">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"> 
<link rel="shortcut icon" href="/Public/m/images/favicon.ico" type="image/x-icon">
<link href="/Public/m/css/newall.css" rel="stylesheet" type="text/css">
<link href="/Public/m/css/search_v2.css" rel="stylesheet" type="text/css">
<link href="/Public/m/css/iscroll.css" rel="stylesheet" type="text/css">
<link href="/Public/layer/skin/layer.css" rel="stylesheet" type="text/css">
<script src="/Public/js/jquery-1.7.min.js"></script>
<script src="/Public/layer/layer.js"></script>
<script type="text/javascript" src="/Public/m/js/iscroll.js"></script>
</head>
<body>
<style>
.searchlist-normal {
    list-style: none;
    margin-bottom: 60px;
}
</style>
<header>
	<div class="m_common_new_top">
		<!-- 新版商详头部开始 -->
		<div id="m_common_header">
			<header class="header" style="position:fixed; width:100%; z-index:10;">
				<div class="header-new-bar">
					<div id="m_common_header_goback" class="header-icon-back">
						<a href="javascript:history.go(-1)">
							<span></span>
						</a>
					</div>
					<form action="" id="layout_searchForm" class="lovo-search-form">
						<div class="lovo-search-form-box">
							<div class="lovo-search-form-input">
								<input id="keyword" autocomplete="off" class="text" placeholder="请输入搜索的内容" name="searchKeyword" type="search" value="<?php echo ($_GET['keyword']); ?>">
							</div>
							<a href="javascript:void(0)" id="index_search_submit" class="lovo-search-form-action" onclick="searchP();">
								<span class="lovo-sprite-icon"></span>
							</a>
						</div>	
					</form>
					<div class="header-icon-shortcut L_ping" onclick="$('#m_common_header_shortcut').toggle();"><span></span></div>
					<div class="header-bar-border"></div>
				</div>
				<ul id="m_common_header_shortcut" class="header-shortcut" style="display:none">
					<li id="m_common_header_shortcut_m_index">
						<a class="L_ping" href="<?php echo U('Index/index');?>">
							<span class="shortcut-home"></span>
							<strong>首页</strong>
						</a>
					</li>
					<li class="L_ping" report-eventid="MCommonHead_CategorySearch">
						<a href="<?php echo U('Index/cates');?>">
							<span class="shortcut-categories"></span>
							<strong>分类</strong>
						</a>
					</li>
					<li class="L_ping">
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
	<!-- 新版商详头部结束 -->
	</div>
</header>
     <!--如果是商城页头-->
<div class="mjd-header cover-info" style="transform: translateY(0px);position:fixed;top: 44px;z-index: 9999;">
	<ul class="new-search-tab bdr-bom" id="search-bar">
		<li class="new-change-eleven" _li="1">
			<span class="J_ping">
				<a href="<?php echo U('Index/all',array('order'=>'sold','li'=>1));?>">销量</a>
			</span>
		</li>
		<li class="new-change-eleven" _li="2">
			<span class="J_ping">
				<a href="<?php echo U('Index/all',array('order'=>'score','li'=>2));?>">好评</a>
			</span>
		</li>
		<li class="new-change-eleven" _li="3">
			<span class="J_ping">
				<a href="<?php echo U('Index/all',array('order'=>'id','li'=>3));?>">最新</a>
			</span>
		</li>
		<li class="new-change-eleven new-sort-price" _li="4">
			<span class="J_ping <?php if($_GET['order'] == 'price' && $_GET['type'] == 'desc')echo 'arrow-down';else echo 'arrow-up';?>">
				<a href="
					<?php if($_GET['order'] == 'price' && $_GET['type'] == 'desc') echo U('Index/all',array('order'=>'price','type'=>'asc','li'=>4)); else echo U('Index/all',array('order'=>'price','type'=>'desc','li'=>4)); ?>
				">价格</a>
			</span>
		</li>
		<li class="new-change-eleven" onclick="$('#mjd-popCover').toggle();$('#mjd-floor').toggle();"><span class="J_ping" id="J_ping">筛选<span class="choose-icon"></span></span></li>
	</ul>
</div>



<div id="scroller" style="transform-origin: 0px 0px 0px; position: relative;margin-top: 80px; top: 0px; left: 0px;margin-bottom:44px;">
	<ul class="searchlist-normal" id="thesearchlist"> 
		
	</ul>	
</div>

<div id="saerchLand" class="mjd-floor association-pannel">
	<div id="search_land_searchland" class="search-land"></div>
</div>
<div id="layout_space" class="mjd-floor bar-space" style="height: 0px;"></div>

<div class="mjd-floor cover-pannel" style="display:none" id="mjd-floor"><div class="cover-floor "></div></div>
<div class="mjd-popCover" style="display:none" id="mjd-popCover">
	<div class="mjd-floor choose-pannel">
		<div class="sidebar-content">
			<div class="sidebar-header bdr-bom">
				<div class="sidebar-header-left arrow-left" onclick="$('#mjd-popCover').toggle();$('#mjd-floor').toggle();"><span></span></div>
				<div class="sidebar-header-center"><span>筛选</span></div>
			</div>
			<div class="sidebar-items-container" id="sidebar-items-container1">
				<?php if(is_array($_feature['config'])): foreach($_feature['config'] as $k=>$v): ?><ul class="sidebar-list bdr-t">
					<li class="sidebar-iteam bdr-bom J_ping">
						<a href="<?php echo U('Index/all',array('feature'=>$k));?>">
							<i class="arrow-right"></i>
							<span class="sort-of-brand"><?php echo ($v['name']); ?></span>
							<small class="sort-of-brand">点击筛选</small>
						</a>
					</li>
				</ul><?php endforeach; endif; ?>				
			</div> 
		</div>
	</div>
</div>
<div id="loading" style="width: 100%;height: 100%;position: fixed;top: 0;left: 0;display:none;z-index: 9999;">
	<div class="load-b" style="width: 100%;height: 100%;position: absolute;background: #000;opacity: 0.8;z-index: 999999;"></div>
	<img src="/Public/images/loading-2.jpg" style="width: 20%;left: 40%;top: 40%;position: absolute;z-index: 999999;" />
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
	var _li = "<?php echo ($_GET['li']); ?>";
		order = "<?php echo ($_GET['order']); ?>";
		type = "<?php echo ($_GET['type']); ?>";
		cate_id = "<?php echo ($_GET['cate_id']); ?>";
		feature = "<?php echo ($_GET['feature']); ?>";
		keyword = "<?php echo ($_GET['keyword']); ?>";
</script>
<script type="text/javascript" src="/Public/m/js/all.js"></script>
</body>
</html>