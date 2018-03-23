<?php if (!defined('THINK_PATH')) exit();?>		
<?php if($list): if(is_array($list)): foreach($list as $key=>$v): ?><li class="normal-list">
	<a href="<?php echo U('Index/product',array('id'=>$v['id']));?>" class=" J_ping">
		<div class="pro-img">
			<img src="<?php echo ($v['pic']); ?>" alt="<?php echo ($v['title']); ?>" class="p-pic" width="80" height="80">					 
		</div>
		<div class="product-info-box">
			<div class="product-name">
				<span><?php echo ($v['title']); ?></span>
			</div>
			<div class="gray-icon"></div>
			<div class="product-price-m">
				<em>¥<span class="big-price"><?php echo ($v['price']+($v['points']*$_site['points_rate']/100)); ?></span></em>
			</div>
			<div class="gray-pro-info">
				<span>最近成交<?php echo ($v['sold']); ?>笔|</span>
				<span>评分</span>
				<ul class="rating  star<?php echo ($v['score']); ?>" style="padding:0; border:0;float:none;display:inline-block">      
					<li class="one">1</li>
					<li class="two">2</li>
					<li class="three">3</li>
					<li class="four">4</li>
					<li class="five">5</li>
				</ul>
			</div>								        
		</div>
	</a>
</li><?php endforeach; endif; ?>
<?php else: ?>
	<li>
		<div class="empty" style="margin:auto;clear;height:70px;">
			<img src="/Public/m/images/no-more.png?a=b" class="no-more">
			<span class="txt-nomore-msg">没有更多啦</span>
		</div>
	</li><?php endif; ?>