<?php if (!defined('THINK_PATH')) exit(); if($list): if(is_array($list)): foreach($list as $key=>$v): ?><li>
	<div class="headimg"><img src="<?php echo ($v['headimg']); ?>" /></div>
	<div class="tboxR">
		<p class="clearfix BoxRTop">
			<b class="fl"><?php echo ($v['nickname']); ?></b>
			<span class="fr BoxRTopStep2" style="background:#FF5722">贡献+<?php echo ((isset($v['separate']) && ($v['separate'] !== ""))?($v['separate']):"0.00"); ?></span>
		</p>
		<p class="BoxRMid">
			关注时间：<?php if($v['sub_time']): echo (date("Y-m-d H:i:s",$v['sub_time'])); else: ?>-<?php endif; ?>
			<span class="fr BoxRTopStep2"><?php echo ((isset($v['team']) && ($v['team'] !== ""))?($v['team']):"0"); ?>成员</span>
		</p>
		<p class="BoxRBtm">
			<?php if($v['isvalid']): ?>有效代理<?php else: ?>非有效代理<?php endif; ?>
		</p>
	</div>
</li><?php endforeach; endif; ?>
<?php else: ?>
	<?php if($page == 1): ?><li>
			<div class="empty" style="margin:auto;clear;height:80px;">
				<img src="/Public/m/images/no-more.png?a=b" class="no-more">
				<span class="txt-nomore-msg">没有下级团队信息</span>
			</div>
		</li>
	<?php else: ?>
		<li>
			<div class="empty" style="margin:auto;clear;height:80px;">
				<img src="/Public/m/images/no-more.png?a=b" class="no-more">
				<span class="txt-nomore-msg">没有更多啦</span>
			</div>
		</li><?php endif; endif; ?>