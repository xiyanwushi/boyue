var page=1;
var _status;
var myscroll = new iScroll("wrapper",{
	onScrollMove:function(){
		if (this.y<(this.maxScrollY)) {
			$('.pull_icon').addClass('flip');
			$('.pull_icon').removeClass('loading');
			$('.more span').text('释放加载...');
		}else{
			$('.pull_icon').removeClass('flip loading');
			$('.more span').text('上拉加载...')
		}
	},
	onScrollEnd:function(){
		if ($('.pull_icon').hasClass('flip')) {
			$('.pull_icon').addClass('loading');
			$('.more span').text('加载中...');
			pullUpAction(2);
		}
		
	},
	onRefresh:function(){
		$('.more').removeClass('flip');
		$('.more').removeClass('loading');
		$('.more span').text('上拉加载...');
		$('.more').hide();
	}
	
});

pullUpAction(1);

//type 区分首次加载显示背景遮罩
function pullUpAction(model){
	if(model == 1){
		$('#loading').show();
		$('.more').hide();
	}else{
		$('.more').show();
	}

	$.post("/index.php?m=&c=My&a=getOrder",{page:page,stats:_status},function(d){
		if(d){
			if(d.status){
				$('#orderlist').append(d.info);
				myscroll.refresh();					
			}else{
				if($('.empty').length && $('.empty').length>0){
					myscroll.refresh();
					$('.more').hide();
				}else{
					$('#orderlist').append(d.info);	
					myscroll.refresh();
					$('.more').hide();
				}
			}
			page++;
			$('#loading').hide();
		}else{
			layer.msg('网络异常',{icon:5});
		}
	});

}

//申请取消订单
function cancleOrder(id){
	if(id>0){
		layer.confirm('您是否要狠心取消这个订单吗？',
			{btn: ['狠心取消','放你一码']}, 
			function(){
				$.post("./index.php?m=&c=Ajax&a=cancleOrder",{order_id:id},function(d){
					console.log(d);
					if(d){
						if(d.status){
							layer.alert(d.info,function(){
								if(d.url){
									location.href=d.url;
								}
							});			
						}else{
							layer.msg(d.info,{icon:5});
						}
						
					}else{
						layer.msg('网络异常',{icon:5});
					}
				});
			},
			function(){
				layer.closeAll();
			}
		);
	}
}

//收货订单
function confirmOrder(order_id){
	if(order_id>0){
		layer.confirm('您确定是否已经收到了货物？',
			{btn: ['确定收货','稍后处理']}, 
			function(){
				$.post("./index.php?m=&c=Ajax&a=confirm_order",{order_id:order_id},function(d){
					console.log(d);
					if(d){
						if(d.status){
							layer.alert(d.info,function(){
								location.reload();
							});			
						}else{
							layer.msg(d.info,{icon:5});
						}
						
					}else{
						layer.msg('网络异常',{icon:5});
					}
				});
			},
			function(){
				layer.closeAll();
			}
		);
	}
}

$('.new-change-eleven').click(function(){
	$('.new-change-eleven').removeClass('active');
	$(this).addClass('active');
	_status = $(this).attr('_status');
	$('#orderlist').html('');
	page = 1;
	pullUpAction(1);	
});












	