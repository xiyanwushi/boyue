<?php if (!defined('THINK_PATH')) exit();?>		
<?php if($list): if(is_array($list)): foreach($list as $key=>$v): ?><li>
	<div class="fl">
		<div>返佣用户ID:<?php echo ($v['user_id']); ?></div>
		<div style="margin-top:5px;">返佣用户昵称:<?php echo ($v['user']['nickname']); ?></div>
		<div style="margin-top:5px;"><?php echo (date("Y-m-d H:i:s",$v['create_time'])); ?></div>
	</div>
	<div class="fr sw"><?php if($v['status'] != 0): ?>完成分销<?php else: ?>预收分销<?php endif; ?></div>
	<div class="fr" style="color:#659ed2;margin-top:15px;font-size:14px;margin:15px;"><?php echo ($v['points']); ?></div>
</li><?php endforeach; endif; ?>
<?php else: ?>
	<div style="border:0px;" class="empty">
		<span class="pullUpLabel">
			<img src="/Public/m/images/no-more.png" class="no-more">
			<span class="txt-nomore-msg">没有更多啦</span>
		</span>
	</div><?php endif; ?>