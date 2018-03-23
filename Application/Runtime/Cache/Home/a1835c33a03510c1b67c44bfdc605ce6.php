<?php if (!defined('THINK_PATH')) exit();?>		
<?php if($list): if(is_array($list)): foreach($list as $key=>$v): ?><li>
	<div class="fl">
		<div><?php echo get_finance_type($v['type']);?></div>
		<div style="margin-top:8px;"><?php echo (date("Y-m-d H:i:s",$v['create_time'])); ?></div>
	</div>
	<div class="fr sw"><?php echo get_finance_action($v['action']);?>	</div>
	<div class="fr" style="color:#659ed2;margin-top:15px;font-size:14px;margin:10px;"><?php echo ($v['value']); ?></div>
</li><?php endforeach; endif; ?>
<?php else: ?>
	<div style="border:0px;" class="empty">
		<span class="pullUpLabel">
			<img src="/Public/m/images/no-more.png" class="no-more">
			<span class="txt-nomore-msg">没有更多啦</span>
		</span>
	</div><?php endif; ?>