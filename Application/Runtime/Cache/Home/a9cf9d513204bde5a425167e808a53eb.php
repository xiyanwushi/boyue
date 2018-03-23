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
<style>
.header{ background:#000; color:#666666; box-shadow:none;}
.header a{ color:inherit;}
.footer{ border-top:1px solid #ddd}
.cart-checkbox {
    display: block;
    width: 20px;
    height: 20px;
    margin: 0 auto;
    background: url(./Public/m/images/shoppingcart.png) no-repeat 0px 1px;
    background-size: 50px 200px;
	top: 5px!important;
	right:0px!important;
}
</style>
<div class="header-blank"></div>
<div class="header">
	收货地址
	<span class="left">
		<a href="javascript:;" onclick="window.history.go(-1)"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
	</span>
</div>

<div class="addr-main">
	<div class="addr-add">
		<a href="<?php echo U('My/addr_add?act='.$_GET['act']);?>" style="font-size:16px;">
			添加新地址
		</a>
	</div>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="addr-item" style="padding: 0;">
		<div style="width:25px;height:25px;position:absolute;top: 10%;right: 3%;" onclick="del(<?php echo ($vo['id']); ?>);">
			<span class="cart-checkbox"></span>
		</div>
		<?php if($vo['is_default'] == 1): ?><div style="width:20px;height:20px;position:absolute;top: 10%;left: 2%;"><img style="width:100%;" src="/Public/images/l_2.png" /></div>
		<?php else: ?>
			<div style="width:22px;height:22px;position:absolute;top: 10%;left: 2%;" onclick="defaultAddr(<?php echo ($vo['id']); ?>);">
				<img alt="设置默认" style="width:100%;" src="/Public/images/ok.png" />
			</div><?php endif; ?>
		
		<div style="width: 70%;margin-left: 12%;line-height: px;margin-top: 10px;margin-bottom: 10px;">
		<a href="<?php if($_GET['act'] == 'select'): echo U('Index/cart?addr='.$vo['id']); else: echo U('Index/addr?default='.$vo['id']); endif; ?>">
			<?php echo ($vo["name"]); ?>(<?php echo ($vo["mobile"]); ?>)<br/>
			<?php echo str_replace('||',' ', $vo['district']); echo ($vo["addr"]); ?>
		</a>
		</div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<script>
	function del(id){
		layer.confirm('确定要删除吗？', {btn: ['确定','取消']}, function(){
			Ajax("<?php echo U('My/delAddr');?>",{id:id,act:"<?php echo ($_GET['act']); ?>"});
		})
	}
	
	function defaultAddr(id){
		layer.confirm('设置默认？', {btn: ['确定','取消']}, function(){
			Ajax("<?php echo U('My/default_addr');?>",{id:id,act:"<?php echo ($_GET['act']); ?>"});
		});
	}
	
	function Ajax(url,data){
		layer.msg('加载中', {
		  icon: 16,
		  shade: 0.5
		});
		if(url){
			layer.closeAll();
			$.post(url,data,function(d){
				if(d){
					console.log(d);
					if(d.status){
						layer.msg(d.info);
						if(d.url){
							setTimeout(function(){
								location.href=d.url;
								layer.closeAll();
							}, 2000);
						}
					}else{
						layer.msg(d.info);
					}
				}else{
					layer.msg('网络异常');
				}
			});
		}
	}
</script>
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