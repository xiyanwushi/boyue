
var page=1;
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
	setTimeout(function(){
		$.post("/index.php?m=&c=Mch&a=getMoney",{type:type,page:page},function(d){
			if(d){
				if(d.status){
					$('#scroller ul').append(d.info);
					myscroll.refresh();					
				}else{
					if($('.empty').length && $('.empty').length>0){
						myscroll.refresh();
						$('.more').hide();
					}else{
						$('#scroller ul').append(d.info);	
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
		
	}, 1000);
}
























