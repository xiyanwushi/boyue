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
<link rel="stylesheet" type="text/css" href="/Public/m/css/buy.css">
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
	var title ="订单详情";
	if(title!=''){
		$('#headerTitle').html(title);
	}
	function headerShortcut(){
		$('.header-shortcut').toggle();
	}
</script>

<section class="content" style="margin-bottom:7rem;">
	<div class="active">
        <div class="content-buy">
			<div class="wrap order-buy">
				<div class="mainCont">
					<section class="address">
						<div class="address-info" id="J_address">
							<p class="address-name"><?php echo ($addr['name']); ?></p>
							<p class="address-phone"><?php echo ($addr['mobile']); ?></p>
						</div>
						<div class="address-details">
							<?php if($addr['is_default'] == 1): ?><i class="sitem-tip">默认</i><?php endif; ?>
							&nbsp;&nbsp;&nbsp;<?php echo str_replace('||',' ', $addr['district']);?> 
						</div>
					</section>
					<section class="order " id="order15">
						<section class="order-info">
							<div class="order-list">
								<ul class="order-list-info">
									<?php if(is_array($list)): foreach($list as $key=>$v): ?><li class="item " id="item14">
										<div class="itemInfo list-info" id="itemInfo13">
											<div class="list-img"> 
												<a><img src="<?php echo ($v['pic']); ?>"></a>
											</div>
											<div class="list-cont">
												<h5 class="goods-title"><?php echo ($v['title']); ?></h5>
												<p class="godds-specification">运费:<?php echo ($v['logis_fee']); ?></p>
												<?php if($v['is_zq'] != 1): ?><p class="godds-specification">单件最高可抵扣积分:<?php echo ($v['points']); ?>x<?php echo ($v['nums']); ?></p><?php endif; ?>
												<div class="itemPay list-price-nums" id="itemPay6">
													<?php if($v['is_zq'] != 1): ?><p class="price">￥<?php echo ($v['price']+($v['points']*$_site['points_rate']/100)); ?></p>
													<?php else: ?>
														<p class="price">∮<?php echo ($v['zq_points']); ?></p><?php endif; ?>
													<p class="nums">x<?php echo ($v['nums']); ?></p>
												</div>
											</div>
										</div>
									</li><?php endforeach; endif; ?>
								</ul>
								<a class="dgscp-c" href="">
									<img src="/Public/m/images/tthh30.png" style="width: 100%;">
								</a>

								<div class="deliveryMethod" style="margin:16px 0px 10px 0px;font-size:.7em">
									<div style="width:182px;position: relative;">									
									支付方式
										<select name="payway" id="payway" class="payway">	
											<option value="">请选择</option>
											<option value="1">微信支付</option>
											<option value="2">余额支付</option>
										</select>
										<img src="/Public/m/images/arrow_down.png" style="position: absolute;top: 18%;right: 25px;" />
									</div>
								</div>
								<div class="memo " id="memo9">
									<div class="inputs">
										<input type="text" class="c-inputs c-form-txt-normal" maxlength="200" name="msg" id="msg" value="" placeholder="备注留言">
									</div>
								</div>
								<div class="orderPay " id="orderPay10">
									<div class="subtotal"> 
										<span class="total-text">共</span> 
										<em><?php echo ($nums); ?></em> 
										<span class="total-text" style="margin-right:12px;">件商品</span> 
										运费:<strong class="price">￥<?php echo ($logis_fee); ?></strong>
										商品合计:<strong class="price">￥<?php echo ($total); ?></strong> 
									</div>
								</div>
							</div>
						</section>
					</section>
					<section class="bottom-bar">
						<div class="total-price">
							<div>
								<p class="submitOrder">
									<button class="c-order-btn  J_submit" onclick="submitOrder();">确认</button>
								</p>
								<p class="realPay " id="realPay8">
									
									积分:<span id="points" _value="<?php echo ($points); ?>" class="price">￥<?php echo ($points); ?></span> 
									RMB:<strong class="price" id="needPayAmountSpan">￥<?php echo ($total+$logis_fee); ?>(含运费)</strong> 
								</p> 
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
     </div>  
</section>
<div style="clear:both;height:2rem;"></div>
<script>
	$(function(){
		$('html').css('font-size','14px');
	});
	var addr = "<?php echo ($_GET['addr']); ?>";
		cids = "<?php echo ($_GET['cids']); ?>";
		money = "<?php echo ($user['money']); ?>";
		cx_points = "<?php echo ($user['cx_points']); ?>";
		points = "<?php echo ($user['points']); ?>";
		
	//提交订单
	function submitOrder(){
		if(cids && addr){
			var way = $('#payway option:selected').val();
			if(!way || way==''){
				layer.msg('请选择支付方式');
				return false;
			}
			var need_points = $('#points').attr("_value");
			var need_money = $('#price').attr("_value");
			var msg = '';
			if(parseFloat(money) < parseFloat(need_money) && way == "2"){
				msg = '余额不足,抵扣后将以微信支付结算,是否继续？';
			}
			if( parseFloat(cx_points) < parseFloat(need_points) && parseFloat(points) >= parseFloat(need_points) ){
				msg = '重销积分不足,以自有积分进行抵扣,是否继续？';
			}
			if( parseFloat(cx_points) < parseFloat(need_points) && parseFloat(points) < parseFloat(need_points) ){
				if(way == "2"){
					msg = '重销积分和自有积分不足,将以余额抵扣,是否继续？'
				}else{
					msg = '重销积分和自有积分不足,将以微信支付结算,是否继续？'
				}
			}
			
			var data = {cids:cids,addr:addr,msg:$('#msg').val(),payway:way}
			if(msg!=''){
				layer.confirm(msg, {btn: ['继续结算','再看看']}, function(){
					ajax(data);
				});
			}else{
				ajax(data);
			}	
		}
	}
	
	function ajax(data){
		$.post("/index.php?m=&c=Ajax&a=createOrder",data,function(d){
			if(d){
				console.log(d);
				if(d.status){
					if(d.url){
						location.href=d.url;
					}
				}else{
					layer.msg(d.info,{icon:5});
				}
			}else{
				layer.msg('网络异常',{icon:5});
			}	
		});
	}
</script>
<script src="/Public/m/js/order.js"></script>
</body>
</html>