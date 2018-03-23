<?php if (!defined('THINK_PATH')) exit(); if($list): if(is_array($list)): foreach($list as $key=>$v): ?><li>
	<div class="ol-l">
		<a href="<?php echo U('Index/product',array('id'=>$v['product']));?>" class="toDetail">
			<img src="<?php echo ($v['pic']); ?>">
		</a>
	</div>
	<div class="ol-r">
		<h3><a href="<?php echo U('Index/product',array('id'=>$v['product']));?>" class="toDetail"><?php echo ($v['title']); ?></a></h3>
		<p class="r-price">
			 关注时间:<?php echo (date("Y-m-d H:i:s",$v['create_time'])); ?>
			<br>
		<span class="r-red">￥<?php echo ($v['price']); ?></span>
		</p>
		<p class="r-btn">
			<a href="javascript:;" onclick="Favorite(<?php echo ($v['product_id']); ?>)" class="c-btn hotHref ">取消关注</a> 
		</p>
	 </div>
</li><?php endforeach; endif; ?>
<?php else: ?>
	<li>
		<div class="empty" style="margin:auto">
			<img src="/Public/m/images/no-more.png?a=b" class="no-more">
			<span class="txt-nomore-msg">没有更多啦</span>
		</div>
	</li><?php endif; ?>