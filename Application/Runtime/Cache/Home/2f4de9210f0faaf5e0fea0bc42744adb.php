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
<link href="/Public/m/css/product.css" rel="stylesheet" type="text/css">
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
	var title ="产品详情";
	if(title!=''){
		$('#headerTitle').html(title);
	}
	function headerShortcut(){
		$('.header-shortcut').toggle();
	}
</script>
<style>
.d-cul li label {
    display: inline-block;
    width: 88px;
	font-size: .8rem;
}
.focus .bd{height:375px;}
.focus .bd li img{height:375px;}
</style>
<section class="content" style="margin-top:280px;">
	<div class="active" id="h5v0">
		<div id="J_detail">
			<div id="J_detail_main">
				<div class="banner">
					<div id="focus" class="focus">
						<div class="hd">
							<ul></ul>
						</div>
						<div class="bd">
							<ul>
								<?php if(is_array($info['banner'])): $i = 0; $__LIST__ = $info['banner'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="javascript:;"><img _src="<?php echo ($vo); ?>" src="<?php echo ($vo); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
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
				<div class="dt-info" data-spm="info">     
					<h1 id="goodsNameStrong" class="dtif-h"><?php echo ($info['title']); ?></h1>
						<ul class="d-cul">
						
						<li>
							<label>官方价:</label>
							<span class="gray12"><del class="dc-origin" id="marketPriceSpan">￥<?php echo ($info['market_price']); ?></del></span>						
						</li>
						<li class="dic-fli">
							<label>销售价:</label>
							<ins class="red dc-promo" id="salePriceSpan">￥<?php echo ($info['price']+($info['points']*$_site['points_rate']/100)); ?></ins> 
							<span class="gray12"> <span class="di-org" id="actTitle"></span></span>
						</li>
						<li class="dic-fli">
							<label>
								最高<?php echo ($_site['points_name']); ?>抵扣:
							</label>
							<span style="margin-left: 5px; font-size: 12px;" id="mayIntDiv">
							<span id="mayInt"><?php echo ($info['points']*$_site['points_rate']/100); ?>元
								(<?php echo ($info['price']); ?>元+<?php echo ($info['points']); echo ($_site['points_name']); ?>)</span</span> 
						</li>  
						<li class="dic-fli">
							<label><?php echo ($_site['points_name']); ?>兑换:</label>
							<span style="margin-left: 5px; font-size: 12px;" id="mayIntDiv">
							<span id="mayInt"><?php echo ((isset($info['zq_points']) && ($info['zq_points'] !== ""))?($info['zq_points']):"不可兑换"); ?></span><b></b></span> 
						</li>  
						<li class="dc-area">
							<label style="float:left">综合评分:</label>
							<ul class="rating  star<?php echo ($info['score']); ?>" style="padding:0; border:0; float:left;">
								<li class="one"><a href="javascript:;" title="1分">1</a></li>
								<li class="two"><a href="javascript:;" title="2分">2</a></li>
								<li class="three"><a href="javascript:;" title="3分">3</a></li>
								<li class="four"><a href="javascript:;" title="4分">4</a></li>
								<li class="five"><a href="javascript:;" title="5分">5</a></li>
							</ul>
						</li>
						<li>
							<label>累计销售:</label><?php echo ($info['sold']); ?> 件 
						</li>
						<li>
							<label>剩余库存:</label><?php echo ($info['stock']); ?> 件 
						</li>
					</ul>
				</div>
				<div id="sku-all" class="dgsc-pr">
					
					<div class="dgscp-c">
						<h3 class="bd">购买数量</h3>
						<div class="nums"> 
							<span class="minus lock J_updateQuantity" onclick="setCount(1,$('#goodsCount').val())">-</span>
							<input id="goodsCount" maxlength="3" onkeyup="value=value.replace(/[^\d]/g,&#39;&#39;)" type="text" data-default="1" value="1" class="input-nums c-form-txt-normal J_quantity">
							<span class="plus  J_updateQuantity" onclick="setCount(2,$('#goodsCount').val(),<?php echo ($info['id']); ?>)">+</span> 
						</div>
					</div>
				</div>
				<a class="dgscp-c" href="javascript:;" target="_blank">
					<img src="/Public/m/images/tthh30.png" style="WIDTH: 100%;">
				</a>
				<div class="dt-content">
					<ul class="dtct-ul">
						<li class="liChange sel" index="1">图文参数</li>
						<li class="liChange" index="2">产品评价</li>
					</ul>
					<div class="dtct-otr" style="min-height: 379px;">
						<div class="dtct-container" style="">
							<div class="changeByCli ByCli1 dt-imgtext visible" style="display: block;">
								<?php echo ($info['param']); ?>
							</div>
							
							<div class="changeByCli ByCli2 dt-comt visible" style="display:none">
								<section id="J_commentCont" class="innercontent">    
									<div class="dtcm-ct" id="J_comment_cont">
										<ul id="list">
											
										</ul>
									</div>
									<div class="c-pnav-con" id="J_dcpage">
										<section class="c-p-sec">
											<div class="c-p-pre">
												<span class="c-p-p" style="left: 6px;"><em></em></span>
												<a href="javascript:;" id="prev">上一页</a>
											</div>
											<div class="c-p-cur">
												 <div class="c-p-arrow c-p-down"><span id="vcount">1/<?php echo ($assess_count); ?></span><span></span></div>
											</div>
											<div class="c-p-next">
												<a href="javascript:;" id="next">下一页</a><span class="c-p-p"><em></em></span>
											</div>
									   </section>
									</div> 
								</section>         
							</div>
						</div>
					</div>
					<div id="J_detail_commloading" class="dt-loading none"><span class="c-loading"></span></div>
				</div>
				<div id="action-bar-padding"></div>
			</div>
		</div>
	</div>
	<?php if($qrcode): ?><div style="width:100%;position:relative;">
		<img src="/Public/images/wxbg.jpg" style="width:100%;margin-bottom:35px;" />
		<img src="<?php echo getqrcode($user['id']);?>" style="position: absolute;top: 59.555%;width: 130px;left: 33%;" />
	</div><?php endif; ?>
	<div class="miblebox" id="goods-img-box">
		<div class="hold-div-top" style="height: 20px;"></div>
		<div class="hold-div-bottom"></div>
		<div id="cart1" class="cart-concern-btm-fixed five-column four-column">
			<div class="concern-cart" style="width:42%">
				<a class="Customer-service-icn" href="javascript:;" onclick="$('#S_ODIALOG').toggle();" style="width:33.3%">
					<em class="help-act-icn"></em>
					<span class="focus-info">客服</span>
				</a>
				<a class="cart-car-icn" id="toCart" href="<?php echo U('Index/cart');?>" style="width:33.3%">
					<em class="btm-act-icn" id="shoppingCart">
						<i class="order-numbers" id="carNum"><?php echo ($cartNums); ?></i>
					</em>
					<span class="focus-info">购物车</span>
				</a>
				<a class="love-heart-icn L_ping" onclick="Favorite(<?php echo ($info['id']); ?>);">
					<div class="focus-container">
						<div class="focus-icon">
							<?php if($favorite): ?><i class="bottom-focus-icon focus-on"></i>
							<?php else: ?>
							<i class="bottom-focus-icon focus-out"></i><?php endif; ?>
						</div>
						<span class="focus-info">关注</span>
					</div>
				</a>
			</div>
			<div class="action-list" style="width:58%">
				<div class="dt-action">
					<div class="dta-iner">
			            <div class="item-action">
							<div onclick="addCart(<?php echo ($info['id']); ?>,1);" class="add-to-cart  bottom-cart-entrance">加入购物车</div>
							<div onclick="addCart(<?php echo ($info['id']); ?>,2);" class="buy-now">立即购买</div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
	
	<div class="ewwm" style="display:none">
		<div class="gzewm">
			<a href="javascript:void(0);"  onclick="$('.ewwm').toggle();" style="position: absolute; top:2%; right:2%">
				<img src="/Public/m/images/xx.jpg" />
			</a>
			<a href="javascript:void(0)">
				<?php if($info['user_id'] and $info['user']['kefu'] != ''): ?><img src="<?php echo ($userp['kefu']); ?>" width="80%" style="margin:10%">
				<?php else: ?>
					<img src="<?php echo ($_site['kefu']); ?>" width="80%" style="margin:10%"><?php endif; ?>
			</a>
		</div>
	</div>
	
	<div class="Customer-service cant" id="S_ODIALOG" style="display:none">
		<a style="position:relative;" href="tel:<?php if($userp): echo ($userp['mobile']); else: echo ($_site['tel']); endif; ?>">
			<img src="/Public/m/images/tel.jpg">
			<span style="position: absolute;top: 1.1em;left: 58%;">
				<?php if($userp): echo ($userp['mobile']); ?>
				<?php else: ?>
					<?php echo ($_site['tel']); endif; ?>
			</span>
		</a>
		<a href="javascript:$('.ewwm').toggle();$('#S_ODIALOG').toggle();">
			<img src="/Public/m/images/wx.jpg">
		</a>		
		<a href="javascript:$('#S_ODIALOG').toggle();" style="background:#042148; color:#fff; border-radius:20px; line-height:2em;height:2em">取消</a>
	</div>
</section>


<div class="mask" id="loading">
	<img src="/Public/m/images/loading-grey.gif" style="position: fixed;_position:absolute;margin-left:-20px;left:50%;top:45%;">
</div>
<div id="indexToTop" style="display: none; width:42px; position:fixed;bottom:100px; right:20px; z-index:999;">
	<img src="/Public/m/images/scroll-to-top-icon.png" style="width: 100%;">
</div>
<script>
	var is_zq = "<?php echo ($_GET['is_zq']); ?>";
		product_id = "<?php echo ($info['id']); ?>";
		assess_count = "<?php echo ($assess_count); ?>"?"<?php echo ($assess_count); ?>":0;
</script>
<script src="/Public/m/js/product.js"></script>
<script>
	window.shareData = {
		img: "<?php echo (complete_url($info['pic'])); ?>", 
		link: "<?php echo complete_url(U('Index/product',http_build_query(array_merge(array('parent' => $user['id'],'id'=>$info['id']),$_GET))));?>",
		title: '博悦乐活网',
		desc: "<?php echo ($info['title']); ?>"
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