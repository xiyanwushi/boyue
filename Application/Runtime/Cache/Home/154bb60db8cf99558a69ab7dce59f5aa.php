<?php if (!defined('THINK_PATH')) exit(); if($list): if(is_array($list)): foreach($list as $key=>$v): ?><li>
	<div class="ol-t"> 
		<a href="<?php echo U('Mch/orderDetail',array('order_id'=>$v['id']));?>">订单号：<?php echo ($v['sn']); ?></a> 
	</div>
	<div class="mb-ollm">
	  <div class="ol-r">
		<?php if(is_array($v['cart'])): foreach($v['cart'] as $key=>$val): ?><a href="<?php echo U('Mch/orderDetail',array('order_id'=>$v['id']));?>" class="imgbox">
				<img src="<?php echo ($val['pic']); ?>">&nbsp;
			</a><?php endforeach; endif; ?>
		<p class="r-time"> 
			订单时间：<span><?php echo (date("Y-m-d H:i:s",$v['create_time'])); ?></span>
			<span style="float:right"><?php echo get_order_status($v['status']);?></span>
		</p>
	  </div>
	</div>
	<div class="ol-b">
		<span class="red">总额：¥<?php echo ($v['total']); ?> <?php echo ($_site['points_name']); ?>:<?php echo ($v['points_total']); ?></span>
		<?php if($v['status'] == 2): ?><a href="javascript:;" onclick="pShow(<?php echo ($v['id']); ?>)">发货</a><?php endif; ?>
	</div>
</li><?php endforeach; endif; ?>
<?php else: ?>
	<?php if($page == 1): ?><li>
			<div class="empty" style="margin:auto;clear;height:80px;">
				<img src="/Public/m/images/no-more.png?a=b" class="no-more">
				<span class="txt-nomore-msg">没有该类订单信息哦</span>
			</div>
		</li>
	<?php else: ?>
		<li>
			<div class="empty" style="margin:auto;clear;height:80px;">
				<img src="/Public/m/images/no-more.png?a=b" class="no-more">
				<span class="txt-nomore-msg">没有更多啦</span>
			</div>
		</li><?php endif; endif; ?>