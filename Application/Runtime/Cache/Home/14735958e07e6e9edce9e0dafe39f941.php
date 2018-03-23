<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
<title>登录确认</title>
<link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/Public/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/store.css?2016" rel="stylesheet" type="text/css" />
<script src="/Public/js/jquery.min.js" type="text/javascript"></script>
<script src="/Public/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<style>
.header{ background:#000; color:#666666; box-shadow:none;}
.header a{ color:inherit;}
.footer{ border-top:1px solid #ddd}
</style>
</head>

<style>
body{background:#414449; padding:50px;}
</style>
<body>
	<div style=" text-align:center;">
		<img src="/Public/images/pc.png" style=" width:100px;" />
	</div>
	<div style=" font-size:16px; color:#fff; text-align:center; padding:20px;">
	即将在电脑上登录商城<br/>
	请确认是否是本人操作
	</div>
	<div style=" padding:20px; text-align:center;">
		<form method="post">
			<input type="hidden" name="rand" value="<?php echo ($_GET['rand']); ?>" />
			<input type="submit" value="我确认登录电脑版商户管理" style=" height:40px; line-height:40px; width:200px; background:#19A519; color:#fff; border-radius:5px; border:none;" />
		</form>
	</div>

</body>
</html>