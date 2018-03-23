<?php if (!defined('THINK_PATH')) exit(); if($list): if(is_array($list)): foreach($list as $key=>$v): ?><li>
	<div class="ol-t"> 
		<a href="<?php echo U('My/orderDetail',array('order_id'=>$v['id']));?>">订单号：<?php echo ($v['sn']); ?></a> 
	</div>
	<div class="mb-ollm">
	  <div class="ol-r">
		<?php if(is_array($v['cart'])): foreach($v['cart'] as $key=>$val): ?><a href="<?php echo U('My/orderDetail',array('order_id'=>$v['id']));?>" class="imgbox">
				<img src="<?php echo ($val['pic']); ?>">&nbsp;
			</a><?php endforeach; endif; ?>
		<p class="r-time"> 
			订单时间：<span><?php echo (date("Y-m-d H:i:s",$v['create_time'])); ?></span>
			<span style="float:right">
				<?php if($v['is_cancle'] != 1): echo get_order_status($v['status']);?>
				<?php else: ?>
					申请取消订单，待审核<?php endif; ?>
			</span>
		</p>
	  </div>
	</div>
	<div class="ol-b">
		<span class="red">总额：¥<?php echo ($v['total']); ?> <?php echo ($_site['points_name']); ?>:<?php echo ($v['points_total']); ?></span>
		<?php if($v['is_cancle'] != 1): if($v['status'] == 1): ?><a href="<?php echo U('My/pay',array('order_id'=>$v['id']));?>">马上付款</a>
			<?php elseif($v['status'] == 3): ?>
				<a href="javascript:confirmOrder(<?php echo ($v['id']); ?>);">确认收货</a><?php endif; endif; ?>
		<?php if($v['status'] == 1): ?><a href="javascript:;" onclick="cancleOrder(<?php echo ($v['id']); ?>)" class="ddzz">取消订单</a><?php endif; ?>
		<?php if($v['status'] != 1): ?><a href="<?php echo U('My/orderDetail',array('order_id'=>$v['id']));?>" class="ddzz">订单详情</a><?php endif; ?>
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