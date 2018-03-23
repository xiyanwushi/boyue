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
            <h1 class="pagetitle">编辑产品</h1>
            <span class="pagedesc">请认真编辑产品的各项信息</span>       
        </div><!--pageheader-->
       
        <div id="contentwrapper" class="contentwrapper lineheight21">			       
            <form class="stdform stdform2" method="post">
				<style>
				.form-table{ width:100%; background:#ddd;}
				.form-table th,.form-table td{ padding:15px;}
				.form-table th.title{ width:190px; background:#fcfcfc; color:#666; text-align:left;}
				.form-table th small{ font-weight:normal; color:#999; display:block;}
				.form-table td{ background:#fff; vertical-align:middle;}
				#cate select{ width:150px!important; min-width:100px;}
				.stdform2 label {
					display: inline-block;
					padding: 0;
					vertical-align: top;
					text-align: left;
					font-weight: bold;
					padding-left: 0;
					width: 120px;
				}
				</style>
				<table class="form-table" cellspacing="1" border="0">
					<tr>
						<th class="title">商品标题<small>设置商品的标题</small></th>
						<td>
							<input type="text" name="title" id="title" value="<?php echo ($info["title"]); ?>" class="smallinput" />
						</td>
					</tr>
					<?php if($info['user']): ?><tr>
						<th class="title">所属商户<small>所属商户的会员ID</small></th>
						<td>
							<input type="text"  id="user_id" value="<?php echo ($info['user']['id']); ?> - <?php echo ($info['user']['nickname']); ?>" class="smallinput" />
						</td>
					</tr><?php endif; ?>
					<tr>
						<th class="title">商城分类</th>
						<td id="cate">
							<input type="hidden" name="p_cate_id" id="p_cate_id" value="<?php echo ($info["p_cate_id"]); ?>"/>
							<input type="hidden" name="cate_id" id="cate_id" value="<?php echo ($info["cate_id"]); ?>"/>
							<input type="hidden" name="cate_tree" id="cate_tree" value="<?php echo ($info["cate_tree"]); ?>"/>
							<select name="" id="store_select" default="<?php echo ($info["store_cate"]); ?>">
							</select>
						
							<script src="/Public/js/linkagesel-min.js" type="text/javascript"></script>
							<script>
							var opts = {
									//data: districtData,     // districtData为district-all.js中定义的变量
									select:  '#store_select',
									ajax: '<?php echo U("get_child_cates");?>',
									selClass:'select-fix-width',
									head:'请选择',
									fixWidth:'100%',
									autoLink:false,
									loaderImg:'/Public/images/loading_16.gif',
									defVal:<?php echo json_encode(explode(',',$info['cate_tree']));?>
							};
							var linkageSel = new LinkageSel(opts);
							districtData = opts = null; // 如果数据量大最好在创建LinkageSel实例之后清空
							linkageSel.onChange(function() {
								tmp = linkageSel.getSelectedArr();
								d=[];
								for(var i=0;i<tmp.length;i++){
									console.log(tmp[i]);
									if(tmp[i]!='' && tmp[i]!=null)d.push(tmp[i]);
								}
								console.log(d.join(","));
								$("#p_cate_id").val(d[0]);
								$("#cate_id").val(d[1]);
								$("#cate_tree").val(d.join(","));
							});
							</script>
						</td>
					</tr>
					<tr>
						<th class="title">发布区域<small>可以多勾选,也可以不勾选，不勾选则不在首页显示</small></th>
						<td>
							<?php if(is_array($_feature['config'])): foreach($_feature['config'] as $k=>$v): ?><label>
								<input type="checkbox" name="feature[]" <?php if(in_array($k,$info['feature'])): ?>checked<?php endif; ?> value="<?php echo ($k); ?>"  />
								<span style="font-size:14px;margin-right:2%;font-weight:bold;"><?php echo ($v['name']); ?></span>
								</label><?php endforeach; endif; ?>
						</td>
					</tr>
					<tr>
						<th class="title">是否积分专区商品<small>可以多勾选,也可以不勾选，勾选则计算积分专区积分</small></th>
						<td>
							<label>
							<input type="checkbox" name="is_points" <?php if($info['is_points']): ?>checked<?php endif; ?> value="1"  />
							<span style="font-size:14px;margin-right:2%;font-weight:bold;">是</span>
							</label>
						</td>
					</tr>
					<tr>
						<th class="title">单个商品运费<small></small></th>
						<td>
							<input type="text" name="weight" id="weight" value="<?php echo ($info["weight"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">排序权值<small>越大越靠前</small></th>
						<td>
							<input type="text" name="sort" id="sort" value="<?php echo ($info["sort"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">
							商品封面图片
							<small>点击+可以上传，点击图片可更换（大小为170*170像素）</small>
						</th>
						<td>
							<iframe src="<?php echo U('upload', 'event=setPic&url='.$info['pic']);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic" id="pic" value="<?php echo ($info["pic"]); ?>" class="smallinput" />
							
							
							<script>
							function setPic(url){
								document.getElementById('pic').value = url;
							}
							
							</script>
					</tr>
					<tr>
						<th class="title">
							商品详情轮播图片
							<small>点击+可以上传，点击图片可更换，最多上传五张</small>
						</th>
						<td>
							<iframe src="<?php echo U('upload', 'event=setPic1&url='.$info['banner'][1]);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic1" id="pic1" value="<?php echo ($info['banner'][1]); ?>" class="smallinput" />
							
							<iframe src="<?php echo U('upload', 'event=setPic2&url='.$info['banner'][2]);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic2" id="pic2" value="<?php echo ($info['banner'][2]); ?>" class="smallinput" />
							
							<iframe src="<?php echo U('upload', 'event=setPic3&url='.$info['banner'][3]);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic3" id="pic3" value="<?php echo ($info['banner'][3]); ?>" class="smallinput" />
							
							<iframe src="<?php echo U('upload', 'event=setPic4&url='.$$info['banner'][4]);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic4" id="pic4" value="<?php echo ($info['banner'][4]); ?>" class="smallinput" />
							
							<iframe src="<?php echo U('upload', 'event=setPic5&url='.$$info['banner'][5]);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic5" id="pic5" value="<?php echo ($info['banner'][5]); ?>" class="smallinput" />
							
							
							<script>
							function setPic1(url){
								document.getElementById('pic1').value = url;
							}
							function setPic2(url){
								document.getElementById('pic2').value = url;
							}
							function setPic3(url){
								document.getElementById('pic3').value = url;
							}
							function setPic4(url){
								document.getElementById('pic4').value = url;
							}
							function setPic5(url){
								document.getElementById('pic5').value = url;
							}
							</script>
					</tr>
					<tr>
						<th class="title">商品原价<small>设置商品的显示折扣之前的价格</small></th>
						<td>
							<input type="text" name="market_price" id="market_price" value="<?php echo ($info["market_price"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">商品出售价<small>设置商品的购买价格</small></th>
						<td>
							<input type="text" name="price" id="price" value="<?php echo ($info["price"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">商品购买所需积分<small>若设置所需积分，则必须要用积分进行购买，若没有则需要付相同比例的金额</small></th>
						<td>
							<input type="text" name="points" id="points" value="<?php echo ($info["points"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">积分专区所需积分<small>必须要用积分进行购买，若没有则需要付相同比例的金额</small></th>
						<td>
							<input type="text" name="zq_points" id="zq_points" value="<?php echo ($info["zq_points"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">返佣比例<small>若设置返佣比例，则以商品价格的反应比例进行返佣(单位：百分比)</small></th>
						<td>
							<input type="text" name="separate" id="separate" value="<?php echo ($info["separate"]); ?>" class="smallinput" />
						</td>
					</tr>
					
					<tr>
						<th class="title">库存</th>
						<td>
							<input type="text" name="stock" id="stock" value="<?php echo ($info["stock"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">商品初始化销量</th>
						<td>
							<input type="text" name="sold" id="sold" value="<?php echo ($info["sold"]); ?>" class="smallinput" />
						</td>
					</tr>
					
					<tr>
						<th class="title">产品图文参数</th>
						<td>
							<textarea name="param" id="param" class="longinput" style="min-width:400;margin: 0px; height: 500px; max-width:640px;"><?php echo ($info["param"]); ?></textarea>
						</td>
					</tr>
				</table>
				
				
				
				<p class="stdformbutton">
					<button class="submit radius2">提交</button>
					<input type="reset" class="reset radius2" value="重置" />
				</p>
			</form>
			<script src="/Public/plugins/ueditor1.4.3/ueditor.config.js"></script>
			<script src="/Public/plugins/ueditor1.4.3/ueditor.all.min.js"></script>
			<script>
				ue = UE.getEditor('info');
				ue = UE.getEditor('param');
				jQuery(document).ready(function(d){
					$ = jQuery;
					//调整下拉的默认选择
					$("select").each(function(index, element) {
					  $(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');
					});
				});
			</script>
        
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