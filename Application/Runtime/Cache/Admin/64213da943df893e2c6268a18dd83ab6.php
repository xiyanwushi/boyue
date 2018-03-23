<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>管理后台</title>
<link rel="stylesheet" href="/Public/admin/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="/Public/plugins/bootstrap/css/bootstrap.font.css" type="text/css" />
<script type="text/javascript" src="/Public/admin/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/Public/admin/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/Public/admin/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/Public/admin/js/custom/general.js"></script>

<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="js/plugins/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body class="withvernav">
<div class="bodywrapper">
    <div class="topheader">
        <div class="left">
            <h1 class="logo">分销.<span>商城</span></h1>
            <span class="slogan">后台管理系统</span>
                 
            <br clear="all" />
            
        </div><!--left-->
		<div class="right">
        	 <span style=" color:#fff;">
				<?php if(session('?admin')): echo session('admin.name');?> <a href="<?php echo U('Index/logout');?>" style=" color:#ccc;">[退出]</a><?php endif; ?>
				<?php if(session('?mch')): echo session('mch.nickname');?> <a href="<?php echo U('Mch/logout');?>" style=" color:#ccc;">[退出]</a><?php endif; ?>
			</span>
        </div><!--right-->

    </div><!--topheader-->
    
    <style>
	.vernav2 span.text{ padding-left:10px;}
	.menucoll2 span.text{ display:none;}
	.menucoll2>ul>li>a{ width:12px; padding:9px 10px; !important;}
	.dataTables_paginate a{ padding:0 10px;}
	</style>
    <div class="vernav2 iconmenu">
    	<ul>
			<!-- <?php if(session('?admin')): ?><li>
				<a href="#formsub">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					<span class="text">系统设置</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="formsub">
               		<li><a href="<?php echo U('Config/site');?>">网站设置</a></li>
					<li><a href="<?php echo U('Config/user');?>">管理员设置</a></li>
                    <li><a href="<?php echo U('Config/mp');?>">公众号设置</a></li>
                    <li><a href="<?php echo U('Config/dist');?>">分销奖设置</a></li>
					 <li><a href="<?php echo U('Config/tward');?>">团队奖设置</a></li>
					<li><a href="<?php echo U('Config/level');?>">等级设置</a></li>
					<li><a href="<?php echo U('Config/banner');?>">轮播图设置</a></li>
					<li><a href="<?php echo U('Logis/index');?>">运费设置</a></li>
					<li><a href="<?php echo U('Config/feature');?>">标签设置</a></li>
					<li><a href="<?php echo U('Config/topcates');?>">首页导航设置</a></li>
					<li><a href="<?php echo U('Config/ad');?>">首页广告位设置</a></li>
					<li><a href="<?php echo U('Config/withdraw');?>">提现设置</a></li>
					<li><a href="<?php echo U('Config/mch');?>">商户设置</a></li>
                </ul>
            </li>
			<li>
				<a href="#product" class="elements">
					<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
					<span class="text">商品管理</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="product">
					<li><a href="<?php echo U('Product/index',array('status'=>1));?>">商品管理</a></li>
					<li><a href="<?php echo U('Product/index',array('status'=>0));?>">商品审核</a></li>
               		<li><a href="<?php echo U('Product/cate');?>">分类设置</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Notice/index');?>" class="editor">
					<span class="glyphicon glyphicon-volume-down" aria-hidden="true"></span>
					<span class="text">通知公告管理</span>
				</a>
            </li>
			<li>
				<a href="#order" class="elements">
					<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
					<span class="text">订单管理</span>
				</a>
				<span class="arrow"></span>
            	<ul id="order">
					<li><a href="<?php echo U('Order/index',array('mch'=>0));?>">平台订单</a></li>
					<li><a href="<?php echo U('Order/index',array('mch'=>1));?>">商户订单</a></li>
                </ul>
            </li>
			
			<li>
				<a href="#user" class="elements">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					<span class="text">用户管理</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="user">
					<li><a href="<?php echo U('User/index');?>">用户列表</a></li>
					<li><a href="<?php echo U('Tree/index');?>">树形关系</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Reward/index');?>" class="support">
					<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
					<span class="text">领导奖励管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Withdraw/index');?>" class="support">
					<span class="glyphicon glyphicon-import" aria-hidden="true"></span>
					<span class="text">提现管理</span>
				</a>
            </li>
			<li>
				<a href="#finance" class="elements">
					<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
					<span class="text">系统财务</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="finance">
					<li><a href="<?php echo U('Finance/deposit_log');?>">转<?php echo ($_site['points_name']); ?>记录</a></li>
					<li><a href="<?php echo U('Finance/separate_log',array('type'=>1));?>">分销记录</a></li>
					<li><a href="<?php echo U('Finance/separate_log',array('type'=>2));?>">团队奖记录</a></li>
					<li><a href="<?php echo U('Finance/finance_log');?>">账户变动记录</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Selfmenu/index');?>" class="widgets">
					<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>
					<span class="text">自定义菜单管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Autoreply/index');?>" class="addons">
					<span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
					<span class="text">自动回复管理</span>
				</a>
            </li>
			<li>
				<a href="#report" class="elements">
					<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
					<span class="text">统计分析</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="report">
					<li><a href="<?php echo U('Report/index');?>">数据报表</a></li>
               		<li><a href="<?php echo U('Report/instant');?>">实时数据</a></li>
                </ul>
            </li><?php endif; ?> -->
			<?php if(session('?mch')): ?><li>
					<a href="<?php echo U('Mch/index');?>">
						<span class="glyphicon glyphicon-eur" aria-hidden="true"></span>
						<span class="text">商品管理</span>
					</a>
				</li>
				<li>
				<a href="<?php echo U('Mch/order');?>" class="elements">
					<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
					<span class="text">订单管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Mch/report');?>" class="elements">
					<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
					<span class="text">实时数据</span>
				</a>
            </li><?php endif; ?>
			<?php if(session('?admin')): if(is_array($menu)): foreach($menu as $key=>$v): if($v['_child']): ?><li>
							<a href="#menu<?php echo ($v[id]); ?>" class="elements">
								<span class="glyphicon <?php echo ($v['class']); ?>" aria-hidden="true"></span>
								<span class="text"><?php echo ($v['name']); ?></span>
							</a>
							<span class="arrow"></span>
							<ul id="menu<?php echo ($v[id]); ?>">
								<?php if(is_array($v['_child'])): foreach($v['_child'] as $key=>$val): ?><li><a href="<?php echo U($val['url']);?>"><?php echo ($val['name']); ?></a></li><?php endforeach; endif; ?>
							</ul>
						</li>
					<?php else: ?>
						<li>
							<a href="<?php echo U($v['url']);?>" class="editor">
								<span class="glyphicon <?php echo ($v['class']); ?>" aria-hidden="true"></span>
								<span class="text"><?php echo ($v['name']); ?></span>
							</a>
						</li><?php endif; endforeach; endif; endif; ?>
        </ul>
        <a class="togglemenu"></a>
        <br /><br />
    </div><!--leftmenu-->
        
    <div class="centercontent">
		
        <div class="pageheader notab">
            <h1 class="pagetitle">首页广告位设置</h1>
            <span class="pagedesc">设置首页广告位的图片、链接,点击广告区域的 + / 图片 可对其进行编辑</span>
           
        </div>
        <style>
			img.img,.file{ position:absolute; top:0; left:0; width:100px; height:100px;}
			.file{ z-index:888; opacity:0;}
			.fl{float:left}
			.fr{float:right}
			.bod-r{border-right:1px solid #ddd;}
			.bod-l{border-left:1px solid #ddd;}
			.bod-b{border-bottom:1px solid #ddd;}
			.shu{width:400px;border:1px solid #ddd;height:482px;background:#FFFCFC;margin-left:20px;float:left;font-size:40px;}
			.shu img{width:100%;height:100%}
			
			.s-l{width:199px;border-right:1px solid #ddd;height:300px;text-align:center;line-height:300px;}
			.s-r{width:200px;height:300px;}
			.s-r div{height:150px;text-align:center;line-height:150px;}
			.bb{width:100%;height:160px;margin-top:20px;border-top:1px solid #ddd;float: left;}
			.bb div{width:33.1%;height:160px;float:left;text-align:center;line-height:160px;}
			.s-l:hover{background-color:#FF9800;cursor:pointer}
			.s-r div:hover{background-color:#FF9800;cursor:pointer}
			.bb div:hover{background-color:#FF9800;cursor:pointer}
			
			.st{width:600px;float:left;height:370px;border:1px solid #ddd;margin-left:50px;margin-top:2%;}
			.st-title{height:40;font-size:18px;text-align:left;padding-left:5%;line-height:40px;border-bottom:1px solid #ddd;background:#ddd}
			.k-upload{width:100%;height:120px;font-size:25px;border-bottom:1px solid #ddd}
			.k-upload1{width:100%;height:80px;font-size:25px;border-bottom:1px solid #ddd}
			.k-upload2{width:100%;height:50px;font-size:20px;line-height:50px;text-align:center;border-bottom:1px solid #ddd;}
			.k-l{width:30%;float:left;text-align:center;height:100%;line-height:120px;}
			.k-r{width:70%;float:left;text-align:left;line-height:120px;margin-top:10px;}
			.k-r input{
				width:95%;
			    padding: 8px 5px;
				border: 1px solid #ccc;
				-moz-border-radius: 2px;
				-webkit-border-radius: 2px;
				border-radius: 2px;
				background: #fcfcfc;
				vertical-align: middle;
				-moz-box-shadow: inset 0 1px 3px #ddd;
				-webkit-box-shadow: inset 0 1px 3px #ddd;
				box-shadow: inset 0 1px 3px #ddd;
				color: #666;
				margin-top:15px;
			}
			.k-btn{width:50%;height:50px;margin:0 auto;margin-top:20px;}
			.k-btn div{width:40%;height:35px;line-height:35px;border-radius:5px;font-size:18px;text-align:center;}
			.k-submit{border: 1px solid #f0882c;background: #fb9337;color: #fff;cursor: pointer;}
			.k-cancle{color: #666;border: 1px solid #ccc;background: #eee;cursor:pointer}
		</style>
        <div id="contentwrapper" class="contentwrapper lineheight21">
			<div class="shu">
				<div class="s-l fl bod-b adclick ad_1" _ad="ad_1">+</div>
				<div class="s-r fl bod-b">
					<div class="bod-b adclick ad_2"  _ad="ad_2">+</div>
					<div class="adclick ad_3"  _ad="ad_3">+</div>
				</div>
				<div class="bb">
					<div class="adclick ad_4" _ad="ad_4">+</div>
					<div class="bod-r bod-l adclick ad_5"  _ad="ad_5">+</div>
					<div class="adclick ad_6" _ad="ad_6">+</div>
				</div>
			</div>
			<div class="st" style="display:none">
				<div class="st-title"><span>ad-1</span>区域</div>	
				<div class="k-upload">				
					<div class="k-l">上传图片</div>
					<div class="k-r" id="upload" style="position:relative;">
						<input type="file" onchange="upload(this)" class="file" />
						<img src="/Public/images/upload.jpg" class="img" />		
					</div>      
				</div>
				<div class="k-upload1">
					<div class="k-l" style="line-height:80px;">图片链接</div>
					<div class="k-r" id="url" style="line-height:80px;">
						<input type="text" placeholder="请输入图片链接地址"/>
					</div>     
				</div>
				<div class="k-upload2">图片大小：<span id="size"></span></div>
				<div class="k-btn">
					<div class="k-submit fr">保存</div>
					<div class="k-cancle fl">取消</div> 
				</div>
			</div>
        </div><!--contentwrapper-->
		<script src="/Public/js/lrz.mobile.min.js"></script>
        <script>
			var $ = jQuery;
			var title;
			var arr = {
				'ad_1':'195*392像素',
				'ad_2':'254*213像素',
				'ad_3':'254*213像素',
				'ad_4':'171*235像素',
				'ad_5':'171*235像素',
				'ad_6':'171*235像素',
			};
			init();
			//初始化操作
			function init(){
				$.post("<?php echo U('Config/Ads');?>",function(d){
					console.log(d);
					if(d){
						if(d.status){
							var list = d.info;
							for(i=0;i<list.length;i++){
								var title = list[i].title;
								var pic = list[i].pic;
								if(pic!=''){
									$('.'+title).html('<img src='+pic+' />');
								}
							}		
						}
					}else{
						alert('网络异常');
					}
				});
			}
			
			
			$('.adclick').click(function(){
				title = $(this).attr('_ad');
				$('.st-title').find('span').html(title);
				$('#size').html(arr[title]);
				$.post("<?php echo U('Config/getAd');?>",{title:title},function(d){
					console.log(d);
					if(d){
						if(d.status){
							$('#upload').find('img').attr('src',d.info.pic);
							$('#url').find('input').val(d.info.url);
							$('.st').show();
						}else{
							var pic  = $('.'+title+'').html();
							if(pic!='+'){
								var src = $('.'+title+'').find('img').attr('src');
								$('#upload').find('img').attr('src',src);
							}else{
								$('#upload').find('img').attr('src','/Public/images/upload.jpg');
							}
							$('#url').find('input').val('');
							$('.st').show();
						}
					}else{
						alert('网络异常');
					}
				});
			});
			$('.k-cancle').click(function(){
				$('.st').hide();
			});
			
			$('.k-submit').click(function(){
				var data = {
					title:title,
					pic:$('#upload').find('img').attr('src'),
					url:$('#url').find('input').val(),
				}
				$.post("<?php echo U('Config/ad');?>",data,function(d){
					console.log(d);
					if(d){
						alert(d.info);
						location.reload();
					}else{
						alert('网络异常');
					}
				})
			});
			
			function upload(obj){
				//上传图片至服务器
				lrz(obj.files[0], {
					done: function (results) {
						  // 你需要的数据都在这里，可以以字符串的形式传送base64给服务端转存为图片。
						  $.post("<?php echo U('Admin/upload_64');?>",
								  {img:results.base64,size:results.base64.length},function(data){
							  if(data.status){
								console.log(data);
								  $(obj.parentElement).find('img').attr('src',data.info);
								  $(obj.parentElement).find('img').attr('alt',2);
								  $('.'+title+'').html('');
								  $('.'+title+'').html('<img src='+data.info+' />');
							  }else{
								  alert(data.info);
							  }
						  });
					}
				});
			}
		</script>
	</div><!-- centercontent -->
    
    
</div><!--bodywrapper-->
<script>
	jQuery(document).ready(function(e){
		
		
		// 菜单添加提示 
		$ = jQuery;
		
		// 根据cookie打开对应的菜单
		if($.cookie('curIndex')){
			//console.log($.cookie('curIndex'));
			$(".vernav2>ul>li").eq($.cookie('curIndex')).find('ul').show();
		}
		
		$(".vernav2 ul li").each(function(index, el){
			$(this).attr('title', $(this).find("a").find('span.text').text());
			
		});
		
		
		$(".vernav2>ul>li>a").each(function(index,el){
			$(el).on('click',function(e){
				$.cookie('curIndex',$(this).parent('li').index());
			});
		});
		
		
		// 调整默认选择内容
		$("select").each(function(index, element) {
			$(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');
		});
		// 调整提示内容
	});
</script>
</body>
</html>