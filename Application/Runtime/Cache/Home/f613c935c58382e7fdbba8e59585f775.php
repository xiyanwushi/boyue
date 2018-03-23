<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="pixel-ratio-2 retina ios ios-9 ios-9-1 ios-gt-8 ios-gt-7 ios-gt-6 watch-active-state" style="font-size: 23.4375px;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="white">
<meta name="sogou_site_verification" content="CmNHqnSt0u">
<meta http-equiv="pragma" content="no-cache">
<title><?php echo ($_site['name']); ?>-商户申请</title>
<link rel="stylesheet" href="/Public/css/framework7.ios.css">

<link rel="stylesheet" type="text/css" href="/Public/css/my-app.css">
<link rel="stylesheet" type="text/css" href="/Public/css/index.css">
<link rel="stylesheet" href="/Public/css/bootstrap.font.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="/Public/m/css/newall.css">

<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<link rel="stylesheet" href="/Public/layer/skin/layer.css" type="text/css" />
<script type="text/javascript" src="/Public/layer/layer.js"></script>
</head>
<body>
<style>
.views, .view ,.pages {
    position: inherit;
}
.upload-file {
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    position: absolute;
    top: 0;
}
</style>
<div class="views">
	<div class="view view-main">
		<div class="navbar wb">
			<div class="navbar-inner">
				<div class="left">
					<a href="javascript:history.go(-1)" class="link icon-only back">
					<i class="icon icon-back"></i>
					</a>
				</div>
				<div class="center blue-color" style="left: -20px;">
					<?php if($user['ismch'] == 1): ?>商户资料
					<?php elseif($user['ismch'] == 0): ?>
						商户申请<?php endif; ?>
				</div>
				<div class="right">
					<a href="javascript:;" class="link"></a>
				</div>
			</div>
		</div>
		<div class="pages navbar-through">
			<div data-page="Password" class="page">
				<div class="page-content jobPage">
					<form id="register" class="list-block mt10" method="post">
						<ul class="clearfix">
							<li>
							<div class="item-content">
								<div class="item-inner register-inner">
									<div class="item-title label">
										真实姓名
									</div>
									<div class="item-input">
										<input type="text" name="true_name" id="true_name" autocomplete="off"  placeholder="请输入真实姓名" class="" value="<?php echo ($user['true_name']); ?>" />
									</div>
								</div>
							</div>
							</li>
							<li>
							<div class="item-content">
								<div class="item-inner register-inner">
									<div class="item-title label">
										手机号码
									</div>
									<div class="item-input">
										<input type="tel" name="mobile" value="<?php echo ($user['mobile']); ?>" id="mobile" autocomplete="off"  placeholder="请输入手机号码" onkeyup="this.value=this.value.replace(/\D/gi,&quot;&quot;)" maxlength="11" class="">
									</div>
								</div>
							</div>
							</li>
							<?php if($user['ismch'] == 0): ?><li>
							<div class="item-content">
								<div class="item-inner register-inner">
									<div class="item-title label">
										手机验证码
									</div>
									<div class="item-input">
										<input type="tel" name="code" id="code"  autocomplete="off"  maxlength="6" placeholder="手机短信验证码">
										<input class="getcode dpblue" type="button" onclick="sendSms(this);" value="发送短信">
									</div>
								</div>
							</div>
							</li><?php endif; ?>
							<li>
							<div class="item-content">
								<div class="item-inner register-inner">
									<div class="item-title label">
										详细地址
									</div>
									<div class="item-input">
										<input type="text" name="address" value="<?php echo ($user['address']); ?>" id="address" autocomplete="off" placeholder="请输入详细地址" />
									</div>
								</div>
							</div>
							</li>
							
							<li>
							<div class="item-content">
								<div class="item-inner register-inner">
									<div class="item-title label">
										身份证正面照
									</div>
									<div class="item-input">
										<?php if($user['sfz_a']): ?><img src="<?php echo ($user['sfz_a']); ?>" style="margin:10px;width: 100%;height: 80px;" />
										<?php else: ?>
											<img src="/Public/images/upload.jpg" style="margin:10px;width: 100%;height: 80px;" />
											<input class="upload-file" type="file" accept="image/*" multiple="" onchange="uploadPic(this)">
											<input name="sfz_a" id="sfz_a" type="hidden" /><?php endif; ?>
										
									</div>
								</div>
							</div>
							</li>
							
							<li>
							<div class="item-content">
								<div class="item-inner register-inner">
									<div class="item-title label">
										身份证反面照
									</div>
									<div class="item-input">
										<?php if($user['sfz_a']): ?><img src="<?php echo ($user['sfz_b']); ?>" style="margin:10px;width: 100%;height: 80px;" />
										<?php else: ?>
											<img src="/Public/images/upload.jpg" style="margin:10px;width: 100%;height: 80px;" />
											<input class="upload-file" type="file" accept="image/*" multiple="" onchange="uploadPic(this)">
											<input name="sfz_b" id="sfz_b" type="hidden" /><?php endif; ?>
									</div>
								</div>
							</div>
							</li>
							
						</ul>
						<?php if($user['ismch'] == 1): ?><div style="text-align: center;line-height: 100px;background: #fff;border-top: 1px solid #ddd;font-size: 15px;color: #ce0e0e;">您的商户资料正在审核中...</div>
						<?php elseif($user['ismch'] == 0): ?>
							<div class="content-block">
								<button type="button" onclick="sign();" class="button button-big button-fill dpblue ubt" style="width:100%">立即申请</button>
							</div>
						<?php elseif($user['ismch'] == -1): ?>
							<div style="text-align: center;line-height: 50px;background: #fff;border-top: 1px solid #ddd;font-size: 15px;color: #ce0e0e;">您的申请已被拒绝，请修改资料后重新提交</div>
							<div class="content-block">
								<button type="button" onclick="sign();" class="button button-big button-fill dpblue ubt" style="width:100%">重新申请</button>
							</div><?php endif; ?>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="loading" style="width: 100%;height: 100%;position: fixed;top: 0;left: 0;display:none;z-index: 9999;">
	<div class="load-b" style="width: 100%;height: 100%;position: absolute;background: #000;opacity: 0.8;z-index: 999999;"></div>
	<img src="/Public/images/loading-2.jpg" style="width: 20%;left: 40%;top: 40%;position: absolute;z-index: 999999;" />
</div>
<script src="/Public/m/js/app.js"></script>
<script src="/Public/js/lrz.mobile.min.js"></script>
<script>
	function sign(){
		$('#loading').show();
		var data = {
			"true_name":$('#true_name').val(),
			"mobile":$('#mobile').val(),
			"code":$('#code').val(),
			"address":$('#address').val(),
			"sfz_a":$('#sfz_a').val(),
			"sfz_b":$('#sfz_b').val(),
		}
		var err_msg = {
			"true_name":'请输入您的真实姓名',
			"mobile":'请输入您的手机号码',
			"code":'请输入您的手机验证码',
			"address":'请输入您的详细地址',
			"sfz_a":'请上传您的身份证正面照',
			"sfz_b":'请上传您的身份证反面照',
		}
		var msg='';
		$.each(data,function(i,v){
			if(v==''){
				msg = err_msg[i];
				return false;
			}
		});
		if(msg!=''){
			$('#loading').hide();
			layer.msg(msg);
			return false;
		}
		$.post("<?php echo U('Mch/sign');?>",data,function(d){
			$('#loading').hide();
			if(d){
				if(d.status){
					layer.msg(d.info,{icon:6},function(){
						if(d.url){
							location.href=d.url;
						}else{
							location.reload();
						}
					});
				}else{
					layer.msg(d.info,{icon:5});
				}
			}else{
				layer.msg('请求失败',{icon:5});
			}
		});
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