<?php if (!defined('THINK_PATH')) exit();?>		
<?php if($list): if(is_array($list)): foreach($list as $key=>$v): ?><li>
	<div class="fl">
		<div><?php if($status == 3): ?>账户乐币已结算记录<?php else: ?>账户乐币待结算记录<?php endif; ?></div>
		<div style="margin-top:8px;"><?php echo (date("Y-m-d H:i:s",$v['create_time'])); ?></div>
	</div>
	<div class="fr sw"><?php if($v['status'] == 3): ?>账户乐币已结算记录<?php elseif($v['status'] == 2): ?>待确认收货<?php else: ?>未达条件<?php endif; ?></div>
	<div class="fr" style="color:#659ed2;margin-top:15px;font-size:14px;margin:10px;"><?php echo ($v['points']); ?></div>
</li><?php endforeach; endif; ?>
<?php else: ?>
	<div style="border:0px;" class="empty">
		<span class="pullUpLabel">
			<img src="/Public/m/images/no-more.png" class="no-more">
			<span class="txt-nomore-msg">没有更多啦</span>
		</span>
	</div><?php endif; ?>