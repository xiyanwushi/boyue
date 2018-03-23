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
<link href="/Public/layer/skin/layer.css" rel="stylesheet" type="text/css">
<link href="/Public/css/mobiscroll.css" rel="stylesheet" type="text/css">
<script src="/Public/js/jquery-1.7.min.js"></script>
<script src="/Public/js/mobiscroll.js" charset="utf-8" type="text/javascript"></script>
<script src="/Public/layer/layer.js"></script>
</head>
<body bgcolor="#f2f2f2">
<style>
.smark-profile .submit {
    padding: 30px 20px;
}
</style>
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
	var title ="修改个人资料";
	if(title!=''){
		$('#headerTitle').html(title);
	}
	function headerShortcut(){
		$('.header-shortcut').toggle();
	}
</script>
 <div class="smark-profile tab1" style="margin-top: 44px;">
	<ul>
		<li class="first">
			<span class="personal-img">个人头像&nbsp;<span style="font-size:10px;color:#ddd;">(点击头像上传图片)</span></span>
			<div class="right" style="position:relative;">
				<img src="<?php echo ($user['headimg']); ?>">
				<input type="file" onchange="upload(this)" style="position:absolute;left:0;opacity: 0;top: 0;width: 60px;height: 60px;" />
				<input name="headimg" type="hidden" value="<?php echo ($user['headimg']); ?>" />
			</div>
		</li>
		<li>
			<span>昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称</span>
			<em><?php echo ($user['nickname']); ?></em>
			<i class="iconfont icon-right" style="float:right"></i>
		</li>
		<li class="flex">
			<span>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span>
			<input name="true_name" class="flex_1" placeholder="请输入真实姓名" type="text" value="<?php echo ($user['true_name']); ?>">	
		</li>
		<li class="flex">
			<span>身份证号</span>
			<input name="cardno" class="flex_1" placeholder="请输入身份证号" type="text" value="<?php echo ($user['cardno']); ?>">	
		</li>
		<li class="flex">
			<span>电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话</span>
			<input name="mobile" class="flex_1" placeholder="请输入电话号码" type="text" value="<?php echo ($user['mobile']); ?>">	
		</li>
		<li class="flex">
			<span>开户银行</span>					
			<input name="bank" class="flex_1" placeholder="请输入开户银行" type="text" value="<?php echo ($user['bank']); ?>">		
		</li>
		<li class="flex">
			<span>银行卡号</span>					
			<input name="bankno" class="flex_1" placeholder="请输入银行账号" type="text" value="<?php echo ($user['bankno']); ?>">		
		</li>
		
		<li class="flex">
			<span>出生日期</span>					
			<input readonly="readonly" id="birth" class="flex_1 mbsc-comp" placeholder="请输入出生日期" type="text" value="<?php echo ($user['birth']); ?>">
			<i class="iconfont icon-right"></i>			
		</li>
		<li class="flex">
			<span>邮寄地址</span>					
			<input name="address" class="flex_1" placeholder="请输入详细地址" type="text" value="<?php echo ($user['address']); ?>">		
		</li>
	</ul>
	<div class="submit">
		<input name="submit" value="提交" type="button">
	</div>
		
</div>
<div class="nickname-popup" style="display:none">
	<div>
		<input placeholder="请输入新昵称" type="text">
		<input name="save" value="保存" type="button">
	</div>
</div>
<script type="text/javascript">
    $(function($){
		$("input[name='logout']").click(function(){
			window.location.href="<?php echo U('Ucenter/logout');?>";
		});
		$("input[name=savePassword]").click(function(){
			window.location.href="<?php echo U('Ucenter/editPsw');?>";
		});
    });
</script>
<script>
	$(function(){
		$('#birth').mobiscroll().date({
				theme: 'mobiscroll',
				lang: 'zh',
				display: 'bottom',
				dateWheels: 'yy-mm-dd',
				dateFormat: 'yy-mm-dd',
				showScrollArrows: true
			});
		var mobile = $("input[name=mobile]").val();
		if(mobile != ""){
			$("input[name=mobile]").attr("disabled","true");
		}else{
			$("input[name=mobile]").removeAttr("disabled");
		}
		$(".smark-profile li:nth-child(2)").click(function(){
			$(".nickname-popup").show()
		});
		$(".nickname-popup input[name=save]").click(function(){
			var name = $(".nickname-popup input[type=text]").val();
			if(name !== ''){
				$(".smark-profile li:nth-child(2) em").text(name);
			}	
			$(".nickname-popup").hide();
		});
		$("body").keydown(function(e) {
			var e = e || event, keycode = e.which || e.keyCode;
			if (keycode == 13) {
				$(".smark-profile input[name=submit]").trigger("click");
			}
		});
		$(".profile-tab a").click(function(){
			$(this).addClass("active").siblings().removeClass("active");
		});
        $(".smark-profile input[name=submit]").click(function(){
			var name = $(".smark-profile li em").text();
			var sex = $(".smark-profile li option:selected").attr("value");
			var birth = $("#birth").val();
			var mobile = $("input[name=mobile]").val();
			var address= $("input[name=address]").val();
			var true_name = $("input[name=true_name]").val();
			var cardno = $("input[name=cardno]").val();
			var headimg = $("input[name=headimg]").val();
			var bank = $("input[name=bank]").val();
			var bankno = $("input[name=bankno]").val();
			if(true_name == '' || true_name == null){
				layer.msg("请输入真实姓名",{icon:5});
				return false;
			}
			if(bank == '' || bank == null){
				layer.msg("请输入开户银行",{icon:5});
				return false;
			}
			if(bankno == '' || bankno == null){
				layer.msg("请输入银行卡号",{icon:5});
				return false;
			}
			if(cardno == ''|| cardno == null){
				layer.msg("请输入身份证号",{icon:5});
				return false;
			}
			if(mobile == ''|| mobile == null){
				layer.msg("请输入手机号码",{icon:5});
				return false;
			}
			$.post("<?php echo U('My/profile');?>",{nickname:name,bank:bank,bankno:bankno,birth:birth,mobile:mobile,address:address,true_name:true_name,cardno:cardno,headimg:headimg},function(data){
					console.log(data);
					if(data.status==1){
						layer.alert(data.info,{icon:6},function(){
							window.location.href=data.url;
						});
					}else{
						layer.msg(data.info,{icon:5});
					}
				},"json"
				)
		});	
    });
</script>
<script src="/Public/js/lrz.mobile.min.js"></script>
<script>
	function upload(obj){
		//上传图片至服务器
		var inputHide = $(obj.parentElement).find("input[type=hidden]");
			img = $(obj.parentElement).find("img");
		lrz(obj.files[0], {
			done: function (results) {
				  // 你需要的数据都在这里，可以以字符串的形式传送base64给服务端转存为图片。
				  $.post("<?php echo U('Ajax/upload_64');?>",
						  {img:results.base64,size:results.base64.length},function(data){
					  if(data.status){
						  inputHide.val(data.info);
						   img.attr('src',data.info);
					  }else{
						  layer.msg(data.info,{icon:5});
					  }
				  });
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