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
<link href="/Public/m/css/index3.css" rel="stylesheet" type="text/css">

<!--app下载提醒-->
<!-- <div class="index_layout"> 
	<div class="cell"> 
		<a href="https://m.lovo.cn/app/download.htm"><img width="100%" class="pic" src="/Public/m/images/layout_M211.png"></a>
		<a class="close"> <img src="/Public/m/images/layoutM_close.png"> </a>
	</div>
</div> -->
<div class="fullscreen">
	<div id="fixedtop" class="showfixedtop-half">
		<a id="layout_top" name="top"></a>
		<div id="index_search_main" class="lovo-header-home-wrapper">
			<div class="lovo-search-container on-blur" id="index_search_head">
				<div class="lovo-search-box">
					<div class="lovo-search-tb">
						<div class="lovo-search-icon">
							
							<span id="index_search_bar_cancel" class="lovo-search-icon-cancel"><i class="lovo-sprite-icon"></i></span>
						</div>
						<form action="" class="lovo-search-form">
							<div class="lovo-search-form-box" style="padding-left:8px;">
								<div class="lovo-search-form-input">
									<input type="hidden" name="sid" value="054cadfb3eb365fa315ea3f55425b43c">
									<input id="kwd_input" autocomplete="off" class="text" placeholder="请输入要搜索的内容" name="searchKeyword" type="search">																<input id="index_category" name="catelogyList" type="text" style="display:none">
								</div>
							</div>
						</form>
						<div class="lovo-search-login login-ing">
							<a class="lovo-search-form-icon" style="margin:12px;" onclick="searchHB();"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
	
	<script>
		var logo = "<?php echo ($_site['logo']); ?>";
		if(logo !=""){
			$('.lovo-sprite-icon').css({"background":"url("+logo+") no-repeat","background-size":"100%"});
		}
	</script>
	<div id="content">
		<section>
			<div class="banner">
				<div id="focus" class="focus">
					<div class="hd">
						<ul></ul>
					</div>
					<div class="bd">
						<ul>
							<?php if(is_array($_banner['config'])): $i = 0; $__LIST__ = $_banner['config'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ((isset($vo["url"]) && ($vo["url"] !== ""))?($vo["url"]):'javascript:;'); ?>"><img _src="<?php echo ($vo["pic"]); ?>" src="<?php echo ($vo["pic"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
				<script src="/Public/js/TouchSlide.1.1.js"></script>
				<script type="text/javascript">
					TouchSlide({ 
						slideCell:"#focus",
						titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
						mainCell:".bd ul", 
						effect:"left", 
						autoPlay:true,//自动播放
						autoPage:true, //自动分页
						switchLoad:"_src" //切换加载，真实图片路径为"_src" 
					});
				</script>
			</div>
		</section>
		<section id="entry-list" class="region">
			<div class="content">
				<?php if(is_array($_topcates)): foreach($_topcates as $key=>$v): ?><a href="<?php echo ($v['url']); ?>">
					<img class="" width="100%" title="<?php echo ($v['title']); ?>" src="<?php echo ($v['pic']); ?>"><br><?php echo ($v['title']); ?>
				</a><?php endforeach; endif; ?>
			</div>
		</section>
		
		<?php if(is_array($feature)): foreach($feature as $k=>$v): if($v['show'] == 1): ?><div style="clear:both;font-size: 1.4555rem;<?php if($k != 1): ?>padding:30px 0 5px 0;<?php endif; ?>">
				<img src="<?php echo ($v['pic']); ?>" width="100%" title="<?php echo ($v['name']); ?>">
				</div>
			<?php elseif($v['show'] == 2): ?>
				<div style="clear:both;font-size: 1.4555rem;<?php if($k != 1): ?>padding:30px 0 5px 0;<?php endif; ?>">
				<a href="javascript:;" class="hdmz"><?php echo ($v['name']); ?></a>
				</div>
			<?php else: ?>	
				<div style="clear:both;font-size: 1.4555rem;<?php if($k != 1): ?>padding:30px 0 5px 0;<?php endif; ?>">			
				<img src="<?php echo ($v['pic']); ?>" width="100%" title="<?php echo ($v['name']); ?>">
				<?php echo ($v['name']); ?>
				</div><?php endif; ?>
			
			<div class="item-line" style="width: 100%; height: 9.2rem; margin-top: 0.4rem; ">
				<?php if(is_array($v['list'])): foreach($v['list'] as $key=>$val): ?><div class="item-wrap">
					<a class="item" href="<?php echo U('Index/product',array('id'=>$val['id'],'is_zq'=>$v['checked']));?>" title="<?php echo ($val['title']); ?>">
						<img alt="<?php echo ($val['title']); ?>" class="" src="<?php echo ($val['pic']); ?>">
						<div class="text"><?php echo (msubstr($val['title'],0,18,'utf-8',true)); ?></div>
						<div style="margin-top:5%;">
							<div class="price" style="font-size:1rem;"><font style="font-size:0.8em">￥</font><span class="jq"><?php echo ($val['price']+($val['points']*$_site['points_rate']/100)); ?></span></div>
							<del style="font-size:0.8rem;color:#ccc">￥<?php echo ($val['market_price']); ?></del>
							<span class="cj">购买</span>
						</div>
					</a>
				</div><?php endforeach; endif; ?>
			</div>
			<?php if($k == 1): if($_site['openad'] == 1): ?><section style="clear: both;border-top: 2px solid #ddd;">
						<div style="width:47%;margin:2%; margin-right:0; float:left;clear: both;">
						  <a alt="" target="_blank" href="<?php echo ($ad1['url']); ?>" title="">
							<img src="<?php echo ($ad1['pic']); ?>" width="100%" style="width:100%;height:100%;" />
						  </a>
						</div>
						<div style="width:47%;margin:2%; float:right">
							<?php if(is_array($ad23)): foreach($ad23 as $key=>$v): ?><a alt="" target="_blank" href="<?php echo ($v['url']); ?>" title="">
									<img src="<?php echo ($v['pic']); ?>" width="100%" style="width:100%;height:100%;" />
								</a><?php endforeach; endif; ?>
						</div>
						<div class="bb" style="width:96%"> 
							<?php if(is_array($ad46)): foreach($ad46 as $key=>$v): ?><a alt="" target="_blank" href="<?php echo ($v['url']); ?>" title="">
									<img src="<?php echo ($v['pic']); ?>" width="100%" style="width:100%;height:100%;" />
								</a><?php endforeach; endif; ?>
						</div>
					</section><?php endif; endif; endforeach; endif; ?>
	</div>
	
</div>
<a href="<?php echo U('Index/all');?>" style="clear:both;color: #08122d;background: #f6f2f1;width: 96%;margin: 0 auto;
	line-height: 3em;font-size: 14px;display: block;border: 1px solid #e3dfde;text-align: center;">查看所有商品
</a>
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

<div class="mask" id="loading">
	<img src="/Public/m/images/loading-grey.gif" style="position: fixed;_position:absolute;margin-left:-20px;left:50%;top:45%;">
</div>
<script>
	window.shareData = {
		img: "<?php echo (complete_url($_CFG['site']['logo'])); ?>", 
		link: "<?php echo complete_url(U('Index/index',http_build_query(array_merge(array('parent' => $user['id']),$_GET))));?>",
		title: '博悦乐活网',
		desc: "欢迎关注博悦乐活网，更多优惠等你来拿！"
	};	
</script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
	wx.config({
		debug: false,
		appId: "<?php echo ($jssdk['appId']); ?>",
		timestamp: <?php echo ($jssdk['timestamp']); ?>,
		nonceStr: '<?php echo ($jssdk['nonceStr']); ?>',
		signature: '<?php echo ($jssdk['signature']); ?>',
		jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage']
	});
	wx.ready(function () {
		wx.checkJsApi({
			jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
			success: function(res) {
				//alert(JSON.stringify(res));
			}
		});
		wx.error(function(res){
			console.log('err:'+JSON.stringify(res));
			// config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。

		});
		//分享给朋友
		wx.onMenuShareAppMessage({
			title: window.shareData.title, // 分享标题
			desc: window.shareData.desc, // 分享描述
			link: window.shareData.link, // 分享链接
			imgUrl: window.shareData.img, // 分享图标
			type: 'link', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () { 
			},
			cancel: function () { 
				
			}
		});
		//分享到朋友圈
		wx.onMenuShareTimeline({
			title: window.shareData.title, // 分享标题
			link: window.shareData.link, // 分享链接
			imgUrl: window.shareData.img, // 分享图标
			success: function () { 
				// 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}
		});
	});
	</script>
</body>
</html>