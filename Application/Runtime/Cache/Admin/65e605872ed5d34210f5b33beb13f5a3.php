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
				<script src="/Public/plugins/My97DatePicker/WdatePicker.js"></script>
        <div class="pageheader notab">
            <h1 class="pagetitle">用户管理</h1>
            <span class="pagedesc">管理商城中的用户信息</span>
            
        </div><!--pageheader-->
		<style>
			.btn{
				display:block;
				border-radius:2px;
				position:absolute;
				right:2px;
				width:60px;
				height:20px;
				line-height:20px;
				text-align:center;
				background-image:url()!important;
				
			}
		</style>
        <div id="contentwrapper" class="contentwrapper lineheight21">
			<div class="tableoptions">        
				<form method="post">
					等级:
					<select name="level" default="<?php echo ($_GET['level']); ?>" style="width:90px; min-width:0;">
						<option value="">全部</option>
						<?php if(is_array($_CFG['level'])): $i = 0; $__LIST__ = $_CFG['level'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
					编号:
					<input type="text" name="id" value="<?php echo ($_GET['id']); ?>" class="smallinput" style="width:100px;" />
					<input type="submit" value="查找" />
				</form>
			</div><!--tableoptions-->
			<table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
				<thead>
					<tr>
						<th class="head1">
							<a href="<?php if($_GET['order'] == 'id' && $_GET['type'] == 'desc'){ echo U('index?order=id&type=asc'); }else{ echo U('index?order=id&type=desc'); }?>">
							编号
							<?php if($_GET['order'] == 'id' && $_GET['type'] == 'desc')echo '↑';else echo '↓';?>
							</a>
						</th>
						<th class="head1">头像</th>
						<th class="head0">昵称</th>
						<th class="head1">等级</th>
						<th class="head1">推荐人ID</th>
						<th class="head0" width="150">
							账户余额
						</th>
						<th class="head0" width="150">
							账户<?php echo ($_site['points_name']); ?>
						</th>
						<th class="head0" width="150">
							重销<?php echo ($_site['points_name']); ?>
						</th>
						<th class="head0" width="150">
							冻结积分
						</th>
						<th class="head0">
							<a href="<?php if($_GET['order'] == 'agent1' && $_GET['type'] == 'desc'){ echo U('index?order=agent1&type=asc'); }else{ echo U('index?order=agent1&type=desc'); }?>">
							一级下线数
							<?php if($_GET['order'] == 'agent1' && $_GET['type'] == 'desc')echo '↑';else echo '↓';?>
							</a>
						</th>
						<!--<th class="head0">
							<a href="<?php if($_GET['order'] == 'agent2' && $_GET['type'] == 'desc'){ echo U('index?order=agent2&type=asc'); }else{ echo U('index?order=agent2&type=desc'); }?>">
							二级下线数
							<?php if($_GET['order'] == 'agent2' && $_GET['type'] == 'desc')echo '↑';else echo '↓';?>
							</a>
						</th>
						<th class="head0">
							<a href="<?php if($_GET['order'] == 'agent3' && $_GET['type'] == 'desc'){ echo U('index?order=agent3&type=asc'); }else{ echo U('index?order=agent3&type=desc'); }?>">
							三级下线数
							<?php if($_GET['order'] == 'agent3' && $_GET['type'] == 'desc')echo '↑';else echo '↓';?>
							</a>
						</th>-->
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><img src="<?php echo ($vo["headimg"]); ?>" style="width:50px; height:50px; border-radius:25px;" /></td>
						<td><?php echo ($vo["nickname"]); ?></td>
						<td><?php echo ($_CFG['level'][$vo['level']]['name']); ?></td>
						<td><?php echo ($vo["parent1"]); ?></td>
						<td style="position:relative"><?php echo ($vo["money"]); ?><a href="javascript:;" class="btn" onclick="showPs(<?php echo ($vo['id']); ?>);">充值金额</a></td>
						<td style="position:relative"><?php echo ($vo["points"]); ?><a href="javascript:;" class="btn" onclick="showPss(<?php echo ($vo['id']); ?>);">充值<?php echo ($_site['points_name']); ?></a></td>
						<td style="position:relative"><?php echo ($vo["cx_points"]); ?><a href="javascript:;" class="btn" onclick="showPsss(<?php echo ($vo['id']); ?>);">充值重销</a></td>
						<td style="position:relative"><?php echo ($vo["frozen"]); ?></td>
						<td><?php echo ($vo["agent1"]); ?></td>
						<!--<td><?php echo ($vo["agent2"]); ?></td>
						<td><?php echo ($vo["agent3"]); ?></td>-->
						<td>
							<a href="<?php echo U('detail?id='.$vo['id']);?>">详细信息</a>	|
							<a href="javascript:;" onclick="editParent(<?php echo ($vo['id']); ?>)">修改上级</a>	
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div class="dataTables_paginate paging_full_numbers" id="dyntable2_paginate">
			<?php echo ((isset($page) && ($page !== ""))?($page):"<p style='text-align:center'>暂时没有数据</p>"); ?>
			</div>
        
        </div><!--contentwrapper-->
		
		<div id="loading" style="width: 100%;height: 100%;position: fixed;top: 0;left: 0;display:none;z-index: 9999;">
			<div class="load-b" style="width: 100%;height: 100%;position: absolute;background: #000;opacity: 0.8;z-index: 9999999;"></div>
			<img src="/Public/images/loading-2.jpg" style="width: 50px;left: 48%;top: 40%;position: absolute;z-index: 9999999;" />
		</div>
		
		<link rel="stylesheet" href="/Public/layer/skin/default/layer.css?v=140b">
		<script src="/Public/layer/layer.js"></script>
		<script>
			var $ = jQuery;
			function showPs(userid){
				layer.prompt({title:'请输入您要充值金额'},function(val, index){
					if(val == ''){
						layer.msg('请输入您要充值金额');
						return;
					}
					
					$.post("<?php echo U('setMoney');?>",{money:val,user_id:userid},function(d){
						if(d){
							layer.msg(d.info, {icon: 6});
							 setTimeout(function(){
								layer.close(index);
								location.reload();
							 }, 2000);
						}else{
							layer.msg('网络异常');
						}
					});
					layer.close(index);
				});
			}
			
			function showPss(userid){
				layer.prompt({title:'请输入您要充值积分'},function(val, index){
					if(val == ''){
						layer.msg('请输入您要充值积分');
						return;
					}
					
					$.post("<?php echo U('setPoints');?>",{points:val,user_id:userid},function(d){
						if(d){
							console.log(d);
							layer.msg(d.info, {icon: 6});
							 setTimeout(function(){
								layer.close(index);
								location.reload();
							 }, 2000);
						}else{
							layer.msg('网络异常');
						}
					});
					layer.close(index);
				});
			}
			function showPsss(userid){
				layer.prompt({title:'请输入您要充值积分'},function(val, index){
					if(val == ''){
						layer.msg('请输入您要充值积分');
						return;
					}
					
					$.post("<?php echo U('setcx_Points');?>",{cx_points:val,user_id:userid},function(d){
						if(d){
							console.log(d);
							layer.msg(d.info, {icon: 6});
							 setTimeout(function(){
								layer.close(index);
								location.reload();
							 }, 2000);
						}else{
							layer.msg('网络异常');
						}
					});
					layer.close(index);
				});
			}

			function editParent(userid){
				layer.confirm("修改上级会影响所有下级的上级，是否继续修改？",function(){
					layer.prompt({title:'请输入上级用户ID'},function(val, index){
						layer.closeAll();
						$('#loading').show();
						$.post("<?php echo U('User/editParent');?>",{"user_id":userid,"parent":val},function(d){
							if(d){
								console.log(d);
								$('#loading').hide();
								layer.msg(d.info,{icon:6},function(){
									location.reload();
								});
							}else{
								layer.msg('请求失败');
							}
						})
						
					});
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