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
    <link rel="stylesheet" href="/Public/cate/css/mui.min.css">
    <!--App自定义的css-->
   
    <link rel="stylesheet" type="text/css" href="/Public/cate/css/common.css">
    <script src="/Public/cate/js/jquery.min.js"></script>
    <script src="/Public/cate/js/common.js"></script>
<script src="/Public/js/jquery-1.7.min.js"></script>
<script src="/Public/layer/layer.js"></script>
<script src="/Public/cate/js/mui.min.js"></script>
</head>
<body style="font-size: 12px; background: rgb(255, 255, 255);">
<style>
    .mui-bar-nav~.mui-content {
        padding-top: 50px;
        overflow: hidden;
    }
    
    .mui-row.mui-fullscreen>[class*="mui-col-"] {
        height: 100%;
    }
    
    .mui-segmented-control .mui-control-item {
        line-height: 50px;
        width: 100%;
    }
    
    .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
        background-color: #fff;
    }
    
    .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item,
    .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item.mui-active {
        color: #505050;
        border-bottom: 1px solid #ffffff;
        background-color: transparent;
    }
    
    .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item.mui-active {
        color: #dd2727;
    }

</style>    
<div id="header" class="search-head header mui-bar mui-bar-nav"></div>
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
	var title ="商品分类";
	if(title!=''){
		$('#headerTitle').html(title);
	}
	function headerShortcut(){
		$('.header-shortcut').toggle();
	}
</script>
    <!--分类开始-->
    <div class="mui-content mui-row mui-fullscreen" style="margin-bottom:44px;">
        <div class="mui-col-xs-3 myscroll" data-scroll="1">
            <ul id="segmentedControls" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-vertical" style="transform: translate3d(0px, 0px, 0px) translateZ(0px); transition-duration: 0ms;">
            <?php if(is_array($cates)): foreach($cates as $k=>$v): ?><li class="left-tit"><a href="#item<?php echo ($v['id']); ?>" class="mui-control-item"><?php echo ($v['name']); ?></a></li><?php endforeach; endif; ?>
            </ul>
        </div>
        <div id="segmentedControlContents" class="mui-col-xs-9 myscroll" style="border-left: 1px solid #c8c7cc;height: 100%; overflow:scroll;">
            <?php if(is_array($cates)): foreach($cates as $k=>$v): if($v['_child']): ?><div id="item<?php echo ($v['id']); ?>"  class="mui-control-content mui-active">
               <!--一组分类-->
                <div class="classification-group">
                    <div class="classification-tit"><?php echo ($v['name']); ?></div>
                    <div class="classification-item">
                        <ul class="clearfix">
                            <?php if(is_array($v['_child'])): foreach($v['_child'] as $key=>$val): ?><li>
                                <a href="<?php echo U('Index/all',array('cate_id'=>$val['id']));?>">
                                    <div class="classification-img"><img src="<?php echo ($val['pic']); ?>"></div>
                                    <div class="classification-txt"><?php echo ($val['name']); ?></div>
                                </a>
                            </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>
                <!--一组分类-->
            </div><?php endif; endforeach; endif; ?>
        </div>
    </div>
    <!--分类结束-->
	
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

<script>
	function showItem(ob){
		$(ob).parent().siblings().toggle();
	}
</script>
</body>
</html>