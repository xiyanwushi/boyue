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
            <h1 class="pagetitle">提现设置</h1>
            <span class="pagedesc">设置网站的提现设置</span>
            
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper lineheight21">
        
        
            <form class="stdform stdform2" method="post">
				<p>
					<label>提现方式</label>
					<span class="field">	
						<input type="text" style="background:#ddd" readonly value="一键转账(微信企业付款)" class="smallinput" />
					</span>
				</p>
				<!-- <p>
					<label>提现支持的银行<small>多个用|分开</small></label>
					<span class="field"><input type="text" name="banks" id="banks" value="<?php echo ($_CFG["withdraw"]["banks"]); ?>" class="smallinput" /></span>
				</p> -->
				<p style="background: #ddd;padding: 5px 10px 5px 10px;font-size: 14px;font-weight: bold;">
					余额提现设置
				</p>
				<p>
					<label>满多少余额方可提现<small></small></label>
					<span class="field"><input type="text" name="money_ext" id="money_ext" value="<?php echo ($_CFG["withdraw"]["money_ext"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>余额最低提现倍数<small>以某个值的倍数进行提现</small></label>
					<span class="field"><input type="text" name="money_per" id="money_per" value="<?php echo ($_CFG["withdraw"]["money_per"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>余额提现手续费百分比<small>按照提现的金额的比例</small></label>
					<span class="field"><input type="text" name="money_lv" id="money_lv" value="<?php echo ($_CFG["withdraw"]["money_lv"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>余额提现手续费最大收取<small>收取提现的金额</small></label>
					<span class="field"><input type="text" name="money_max" id="money_max" value="<?php echo ($_CFG["withdraw"]["money_max"]); ?>" class="smallinput" /></span>
				</p>
				
				<p style="background: #ddd;padding: 5px 10px 5px 10px;font-size: 14px;font-weight: bold;">
					积分提现设置
				</p>
				<p>
					<label>满多少积分方可提现<small></small></label>
					<span class="field"><input type="text" name="points_ext" id="points_ext" value="<?php echo ($_CFG["withdraw"]["points_ext"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>积分最低提现倍数<small>以某个值的倍数进行提现</small></label>
					<span class="field"><input type="text" name="points_per" id="points_per" value="<?php echo ($_CFG["withdraw"]["points_per"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>积分提现手续费百分比<small>按照提现的积分的比例</small></label>
					<span class="field"><input type="text" name="points_lv" id="points_lv" value="<?php echo ($_CFG["withdraw"]["points_lv"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>积分提现手续费最大收取<small>收取提现的积分</small></label>
					<span class="field"><input type="text" name="points_max" id="points_max" value="<?php echo ($_CFG["withdraw"]["points_max"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>提现积分进入重销比例<small>按照提现的积分的比例</small></label>
					<span class="field"><input type="text" name="points_cx_lv" id="points_cx_lv" value="<?php echo ($_CFG["withdraw"]["points_cx_lv"]); ?>" class="smallinput" /></span>
				</p>
				<p class="stdformbutton">
					<button class="submit radius2">提交</button>
					<input type="reset" class="reset radius2" value="重置" />
				</p>
			</form>
        
        
        </div><!--contentwrapper-->
        
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