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
	var title ="会员特权";
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
            <a href="<?php echo U('My/sync_profile');?>"><img src="<?php echo ($user['headimg']); ?>" class="touxiang" style="width:45px;height:45px;margin-bottom:2px;"></a>
            <p><?php echo ($user['nickname']); ?></p>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
<style>

.table1{
 margin:8px auto;
 border:1px solid #d2d1d6;
 width:92%
}
.table1 tr{
border: 1px solid #d2d1d6;
}
.table1 tr td{
border: 1px solid #d2d1d6;
text-align: center;
width:33.33%;
height:80px;
padding:5px;
}
.table1 tr td p{
margin-top:5px;
letter-spacing:0.1px;
font-size:0.8rem;
color:#666;
}
.table1 tr td img{
height:22px;
margin-top:10px;
}
.table2{
 margin:0px auto;
 border:1px solid #d2d1d6;
 width:92%;
}
.table2 tr{
border: 1px solid #d2d1d6;
}
.table2 tr td{
border: 1px solid #d2d1d6;
height:80px;
text-align: center;
padding:5px;
}
.table2 tr td img{
height:22px;
margin-top:10px;
}
.table2 tr td p{
margin-top:5px;
color:#666;
font-size:0.8rem;

}
.tr1 td{
width:50%
}
.tr2 td{
width:33.33%
}
.tr3 td{
width:25%
}
.div1{
font-size:1.2rem; 
margin:8px 10px 0 4%;
color:#150d14;
font-weight:bolder;
}
.div1 img{
height:20px;
width:5px ;
margin-right:10px;
}
</style>
<div class="div1">
	<div>
		<?php if($user['level'] == 0): ?><span ><img src="/Public/m/images/a12.png">会员特权</span><?php endif; ?>
		<?php if($user['level'] == 1): ?><span ><img src="/Public/m/images/a12.png">初级特权</span><?php endif; ?>
		<?php if($user['level'] == 2): ?><span ><img src="/Public/m/images/a12.png">银牌特权</span><?php endif; ?>
		<?php if($user['level'] == 3): ?><span ><img src="/Public/m/images/a12.png">金牌特权</span><?php endif; ?>
		<?php if($user['level'] == 4): ?><span ><img src="/Public/m/images/a12.png">钻石特权</span><?php endif; ?>
	</div>
</div>
<div style="clear:both"> </div>
<div >
	<table class="table1" >
		<tr >
			<td><img src="/Public/m/images/a1.png"><p>享受个人购物商家盈利的8%</p></td>
			<td><img src="/Public/m/images/a1.png"><p>直属会员购物商家盈利的30%</p></td>
			<td><img src="/Public/m/images/a1.png"><p>间接会员购物商家盈利的15%</p></td>	
		</tr>
	</table>
	<table class="table2" style="margin-top:-9px">
		<tr 
		<?php if($user['level'] == 0): ?>class="tr1"<?php endif; ?>
		<?php if($user['level'] == 1): ?>class="tr2"<?php endif; ?>
		<?php if($user['level'] > 1): ?>class="tr3"<?php endif; ?>
		>
			<td ><img src="/Public/m/images/a2.png"><p>推荐商家<hr><p>永久享受推荐商家盈利的8%</p></td>
			<?php if($user['level'] == 2): ?><td width=25%><img src="/Public/m/images/a2.png"><p>极差制<hr><p>团队新增购物商家盈利的6%</p></td><?php endif; ?>
			<?php if($user['level'] == 3): ?><td><img src="/Public/m/images/a2.png"><p>极差制<hr><p>团队新增购物商家盈利的12%</p></td><?php endif; ?>
			<?php if($user['level'] == 4): ?><td><img src="/Public/m/images/a2.png"><p>极差制<hr><p>团队新增购物商家盈利的18%</p></td><?php endif; ?>
			<?php if($user['level'] > 0): ?><td ><img src="/Public/m/images/a3.png"><p>&nbsp;</p><p>可申请商城入驻</p></td><?php endif; ?>
			<td><img src="/Public/m/images/a4.png"><p>&nbsp;</p><p>佣金可提现</p></td>
		</tr>
	</table>
</div>
<?php if($user['level'] > 0): ?><div style="font-size:1rem; padding:5px;margin:5px 10px;color:#333;">
<span style="color:#000;">温馨提示：</span>商家入驻，拨比金额，赠送冻结积分，通过商城盈利，100%返还，快乐分享，轻松赚钱！
</div><?php endif; ?>
</body>
</html>