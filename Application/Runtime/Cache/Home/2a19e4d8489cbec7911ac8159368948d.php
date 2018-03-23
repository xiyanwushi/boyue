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
var addr = "<?php echo ($addr); ?>";
var addr_id = "<?php echo ($addr['id']); ?>";
$(function(){
	if(addr == ''){
		layer.msg('您还未设置默认收货地址，快去设置吧！',{icon:5},function(){
			location.href="<?php echo U('My/addr');?>&act=select&is_default=1";
		});
	}
});
</script>
<link href="/Public/m/css/cart.css" rel="stylesheet" type="text/css">
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
	var title ="购物车";
	if(title!=''){
		$('#headerTitle').html(title);
	}
	function headerShortcut(){
		$('.header-shortcut').toggle();
	}
</script>
<section class="content" style="margin-top: 42px;">
	<?php if($addr): ?><div class="cart-addr">
		<a href="<?php echo U('My/addr?act=select');?>">
			<table style="font-size:14px;">
				<tbody>
				<tr>
					<td valign="top" width="50"><b>运至</b></td>
					<td align="left">
						<?php echo str_replace('||',' ', $addr['district']);?> <?php echo ($addr["addr"]); ?><br/><?php echo ($addr["name"]); ?> <?php echo ($addr["mobile"]); ?>								
						<input id="addr_id" type="hidden" value="8">
					</td>
					<td valign="middle"><img src="/Public/images/arrow.png" /></span></td>
				</tr>
			</tbody></table>
		</a>
	</div>
	<div style="height:10px;background:#f2f2f2;border-bottom: 1px solid #dedede;"></div><?php endif; ?>
	<?php if($list): ?><div style="display:block">
		<div class="shop-group">
			<div class="shop-group-item">
				<ul class="shp-cart-list">
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><li>
						<div class="items">
							<div class="check-wrapper">
								<a href="javascript:;" onclick="choose(this);">
									<input type="checkbox" class="checkbox check-on" _cid="<?php echo ($v['id']); ?>" />
								</a>
								<a href="javascript:;" onclick="DelShow(<?php echo ($v['id']); ?>);">
									<span class="cart-checkbox"></span>
								</a>
							</div>
							<div class="shp-cart-item-core shop-cart-display">
								<a class="cart-product-cell-1" href="<?php echo U('Index/product',array('id'=>$v['product_id']));?>">
									<img class="cart-photo-thumb" alt="" src="<?php echo ($v['pic']); ?>" style="opacity: 1;">
								</a>
								<div class="cart-product-cell-2 carts">
									<div class="cart-product-name">
										<a href="<?php echo U('Index/product',array('id'=>$v['product_id']));?>">
											<span><?php echo ($v['title']); ?></span>
										</a>
									</div>
									<div class="cart-product-prop eles-flex">
										<span class="prop1 logis">运费:<?php echo ($v['logis_fee']); ?></span>
									</div>
									<?php if($v['is_zq'] != 1): ?><div class="cart-product-prop eles-flex">
										<span class="prop1">单件最高可抵扣积分:<?php echo ($v['points']); ?></span>
									</div><?php endif; ?>
									<div class="cart-product-cell-3">
										<?php if($v['is_zq'] != 1): ?><span class="shp-cart-item-price">¥<strong><?php echo ($v['price']+($v['points']*$_site['points_rate']/100)); ?><span style="font-size:10px;">(元)</span></strong></span>
										<?php else: ?>
										<span class="shp-cart-item-price">∮<strong><?php echo ($v['zq_points']); ?><span style="font-size:10px;">(<?php echo ($_site['points_name']); ?>)</span></strong></span><?php endif; ?>
										<div class="quantity-wrapper customize-qua">
											<a class="quantity-decrease" href="javascript:;" onclick="setCartNums(1,this,<?php echo ($v['id']); ?>)"></a>
											<input type="number" size="4" value="<?php echo ($v['nums']); ?>" class="quantity" onchange="setCartNums(3,this,<?php echo ($v['id']); ?>)">
											<a class="quantity-increase " href="javascript:;" onclick="setCartNums(2,this,<?php echo ($v['id']); ?>)"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li><?php endforeach; endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<?php else: ?>
	<div class="shp-cart-empty" style="display:block" id="empty">
		<span class="empty-msg">购物车空空如也,赶紧逛逛吧~</span>
	</div>
	<div style="height:10px;background:#f2f2f2;border-bottom: 1px solid #dedede;"></div><?php endif; ?>
	<!-- 看看热卖 begin -->
	<?php if($send): ?><div class="shopping-guess-container" style="display: block;" id="hot">
		<div class="shopping-guess">
			<div class="gray-text">
				<span class="gray-layout">热卖推荐</span>				
			</div>
			<ul class="similar-ul cf" id="items">
				<?php if(is_array($send)): foreach($send as $key=>$v): ?><li class="similar-li">
					<a href="<?php echo U('Index/product',array('id'=>$v['id']));?>">
						<div class="similar-product">
							<img class="Jschangewidth" src="<?php echo ($v['pic']); ?>" style="opacity: 1;">
							<span class="similar-product-text"><?php echo ($v['title']); ?></span>
							<span class="similar-product-price">¥
								<span class="big-price"><?php echo ($v['price']+($v['points']*$_site['points_rate']/100)); ?></span>
								<del>¥<?php echo ($v['market_price']); ?></del>
							</span>
						</div>
					</a>
				</li><?php endforeach; endif; ?>
			</ul>
		</div>
	</div><?php endif; ?>
	<!-- 看看热卖 end -->
	<!--确定删除提示框-->
	<div class="cart-pop-floor" style="display:none" id="del">
		<div class="cart-cover-floor">
		</div>
		<div class="cart-info-box" style="margin-left: 28px; margin-top: 238px;">
			<div class="cart-info-box-content cart-bdb-1px">
				<span class="cart-info-box-text">确认要删除此商品吗？</span>
			</div>
			<div class="cart-btn-box">
				<a class="cart-btn-box-back"  onclick="$('#del').toggle();">取消</a>
				<a class="cart-btn-box-check" href="javascript:;" onclick="DelCart()">确定</a>
			</div>
		</div>
	</div>
	
	<div style="clear:both"></div>
	<div class="footer-toolbar">
		<div class="totalprice">
			<div class="realPay total-price" id="realPay398">
				<p class="h" style="color:#846161;font-size:12px;">
					<span>运费:</span><strong  id="logis_fee"></strong>
				</p>
				<p class="attached h" style="font-size:14px; margin-top:2px">
					<?php echo ($_site['points_name']); ?>:<span class="red"><strong id="points"></strong></span>&nbsp;&nbsp;
					RMB:<span class="price"><strong id="total"></strong></span>
					
				</p>
			
			</div>
			<div class="btn">
				<div class="submit " id="submit509">
					<button class="btn-sub" type="submit" style="background:#fff; border-left:1px solid #e3e3e3; width:40%; color:#666" onclick="delAll();">删除多选</button>
					<button class="c-btn-orgn btn-sub" type="submit" id="checkout-btn">结算</button>
				</div>
			</div>
			<input class="cartids" type="hidden" name="cart_ids">
		</div>
		<div class="realQuantity " id="realQuantity399">
			<input type="hidden" value="0">
		</div>
	</div>
	
	<div id="indexToTop" style="display: none; width:42px; position:fixed;bottom:64px; right:20px; z-index:999;">
		<img src="/Public/m/images/scroll-to-top-icon.png" style="width: 100%;">
	</div>

</section>

<script src="/Public/m/js/cart.js"></script>
</body>
</html>