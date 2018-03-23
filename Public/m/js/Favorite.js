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
		$('.more').find('i').removeClass('flip');
		$('.more').find('i').removeClass('loading');
		$('.more span').text('上拉加载...');
	}
	
});

pullUpAction(1);

function pullUpAction(model){
	if(model == 1){
		$('#loading').show();
		$('.more').hide();
	}else{
		$('.more').show();
	}
	setTimeout(function(){
		$.post("/index.php?m=&c=My&a=getFavorite",{page:page},function(d){
			if(d){
				if(d.status){
					$('#scroller ul').append(d.info);
					myscroll.refresh();					
				}else{
					if($('.empty').length && $('.empty').length>0){
						myscroll.refresh();
					}else{
						$('#scroller ul').append(d.info);	
						myscroll.refresh();
					}
				}
				page++;
			}else{
				layer.msg('网络异常',{icon:5});
			}
		});
		
	}, 1000);
}


//关注
function Favorite(pid){
	if(pid){
		$.post("/index.php?m=&c=Ajax&a=Favorite",{pid:pid},function(d){
			if(d){
				console.log(d);
				if(d.status == 1){
					$('.bottom-focus-icon').removeClass('focus-out');
					$('.bottom-focus-icon').addClass('focus-on');
					layer.msg(d.info,{icon:6});
				}else if(d.status == 2){
					$('.bottom-focus-icon').removeClass('focus-on');
					$('.bottom-focus-icon').addClass('focus-out');
					layer.msg(d.info,{icon:6});															
				}else{
					layer.msg(d.info,{icon:5});	
				}
				location.reload();
			}else{
				layer.msg('网络异常',{icon:5});
			}
		});
	}
}
