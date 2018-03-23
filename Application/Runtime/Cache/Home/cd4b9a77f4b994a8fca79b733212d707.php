<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
<title>在线充值</title>
<link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/Public/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="/Public/css/store.css?2016" rel="stylesheet" type="text/css">
<link href="/Public/css/font.css?2016" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/Public/layer/skin/layer.css" type="text/css">
<script src="/Public/js/jquery.min.js" type="text/javascript"></script>
<script src="/Public/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/Public/layer/layer.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://magic.lswig.cn/Public/layer/skin/layer.css" id="layui_layer_skinlayercss">
<style>
.header{ background:#000; color:#fff; box-shadow:none;}
.header a{ color:inherit;}
.footer{ border-top:1px solid #ddd}
.charge-money a {float: left;margin-right: 5px;margin-top:5px;}
.input-money{height: 30px;padding-left: 2%;width: 100%; border-radius: 5px;border: 1px solid #ddd;}
.charge-money a.active {border-color: #f93;background:#f93;color:#fff;}
input { background-color: transparent;-webkit-appearance: none;}
.charge-money a {float: left;margin-right: 5px;margin-top:5px;}
.input-money{height: 30px;padding-left: 2%;width: 100%; border-radius: 5px;border: 1px solid #ddd;}
.charge-money a.active {border-color: #f93;background:#f93;color:#fff;}
input { background-color: transparent;-webkit-appearance: none;}
</style>
</head>
<body>
	<div class="header-blank"></div>
    <div class="header">
		在线充值
		<span class="left">
			<a href="<?php echo U('index');?>"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
		</span>
	</div>
	
	<div class="charge-main" >
			<div class="charge-header" style="background-color:#F15353;">
				<p>账户可用余额</p>
				<p class="money">￥<?php echo ($user["money"]); ?>元</p>
			</div>
			<div class="charge-money" style="width: 100%;overflow: hidden;text-align: center;">
				<?php if(is_array($values)): foreach($values as $k=>$vo): if($k == 0): ?><a href="javascript:;" class="active" onclick="setMoney(this)"><span><?php echo ($vo); ?></span>元</a>
					<?php else: ?>
						<a href="javascript:;" onclick="setMoney(this)"><span><?php echo ($vo); ?></span>元</a><?php endif; endforeach; endif; ?>
				<input type="hidden" name="money" id="money" value="" />
				<script>
				$(function(){
					$(".charge-money a").each(function(){
						if($(this).hasClass('active')){
							$("#money").val($(this).find('span').text());
						}
					});
				});
				function setMoney(obj){
					$(".charge-money a").removeClass('active');
					$("#money").val($(obj).find('span').text());
					$(obj).addClass('active');
				}
				</script>
			</div>
			<div class="charge-btn">
				<p style="font-size:13px;color: #F51E1E;">温馨提示：输入自定义金额，则充值输入金额</p>
				<input type="number" id="putmoney"  onclick="move();" class="input-money" placeholder="自定义输入金额" value="" />
				<hr style="margin-top:10px;">
				<a href="javascript:;" id="subt" onclick="form_submit()">在线支付</a>
				<a href="javascript:;" style="display:none;" id="subt_w" >正在支付，请稍后...</a>
				<script>
				function form_submit(){
					$('#subt').hide();
					$('#subt_w').show();
					var putmoney = $('#putmoney').val();
					if(putmoney){
						$("#money").val(putmoney);
					}
					money = parseFloat($("#money").val());
					if(isNaN(money) || money <=0){
						layer.alert('请选择充值金额');
						return false;
					}
					$.post("<?php echo U('My/doRecharge');?>",{money:money},function(d){
						if(d){
							if(d.status){
								//付款成功
								//调起微信支付js
								var jsapi =  d.info;
								var jsApiParameters = eval('(' +jsapi + ')');
								//	alert(data);
								WeixinJSBridge.invoke(
									'getBrandWCPayRequest',
									jsApiParameters,
									function(res){
										WeixinJSBridge.log(res.err_msg);
										if(res.err_msg == "get_brand_wcpay_request:ok"){
											layer.alert('支付成功',{icon:"6"},function(){
												location.reload();
											});
										}else if(res.err_msg == "get_brand_wcpay_request:cancel"){
											layer.msg('您取消了支付');
											$('#subt').show();
											$('#subt_w').hide();
										}else{
											layer.msg('支付失败，请重试！');
											$('#subt').show();
											$('#subt_w').hide();
										}
									}
								);
							}else{
								layer.msg(d.info);
							}
						}else{
							layer.msg('网络异常');
						}
					});
				}
				
				function move(){
					$(".charge-money a").removeClass('active');
				}
				</script>
			</div>
	</div>
	
	
</body>
</html>