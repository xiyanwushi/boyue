<?php if (!defined('THINK_PATH')) exit();?>
<!doctype html>
<html lang="zh-CN">
<head>
    <html lang="zh">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>登录PC版商户后台</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta name="keywords" content="好商城V4,PHP商城系统,好商城V4商城系统,多用户商城系统,电商ERP,电商CRM,电子商务解决方案">
        <meta name="description" content="">
        <style type="text/css">
            body{background:rgb(51, 51, 51); padding:50px; text-align:center;}
        </style>
	</head>
</head>

<body>
	<div class="top" style=" line-height:50px; color:#fff; font-weight:bold; font-size:18px;">
		微信登录
	</div>
	<div class="qrcode">
		<div id="qrcode" style=" background:#fff; padding:20px; width:256px; height:256px; margin:0 auto;"></div>
	</div>
	
	<div class="bottom" style=" width:280px; height:55px; background:#232323; border-radius:25px; line-height:55px; color:#fff; margin:20px auto;">
		请使用微信扫描二维码登录
	</div>
	
	<script src="/Public/js/jquery.min.js"></script>
	<script src="/Public/js/jquery.qrcode.min.js"></script>
	<script>
	jQuery('#qrcode').qrcode({text:"<?php echo ($url); ?>"}); 
	setInterval(function(e){
		$.post("<?php echo U('login_ajax');?>",{},function(d){
			if(d.status==1){
				$(".bottom").text('扫码登录成功');//show();
				location.href="<?php echo U('Mch/index');?>";
			}else{
				$(".bottom").text(d.info);//show();
			}
		});
	},3000)
	</script>
</body>
</html>