var page=1;
var _status = 1;
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
	
	$.post("/index.php?m=&c=My&a=getTeam",{page:page,stats:_status},function(d){
		if(d){
			//console.log(d);
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

$('.new-change-eleven').click(function(){
	$('.new-change-eleven').removeClass('active');
	$(this).addClass('active');
	_status = $(this).attr('_status');
	$('#orderlist').html('');
	$('#son').html('您的'+_status+'级有效会员共有：'+$(this).attr('_count')+'人');
	page = 1;
	pullUpAction(1);	
});












	