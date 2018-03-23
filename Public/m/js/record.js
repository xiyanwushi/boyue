var flag ="finance";
var page=1;
var done;
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
			if(flag == "finance"){
				pullUpAction(2);
			}else if(flag == "separate"){
				getSeparate();
			}
			
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
	$.post("/index.php?m=&c=My&a=getRecord",{type:type,page:page},function(d){
		if(d){
			//console.log(d);
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

}

function getSeparate(){
	$.post('./index.php?m=&c=My&a=getSeparate',{page:page,done:done},function(d){
		if(d){
			console.log(d);
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
}

//刷新乐币记录
$('#reflash').click(function(){
	page = 1;
	flag = "finance";
	$('#scroller ul').html('');
	pullUpAction(1);
})

$('.sep').click(function(){
	flag = "separate";
	page = 1;
	done = $(this).attr('_done');
	$('#scroller ul').html('');
	getSeparate();
});


function withdraw(model){
	if(model == 1){
		var title = "请输入您要提现的金额！"
	}else{
		var title = "请输入您要提现的积分！"
	}
	layer.prompt({title:title},function(val, index){
		 $.post("./index.php?m=&c=Ajax&a=withdraw",{value:val,type:model},function(d){
			 if(d){
				 if(d.status){
					$('.popup').hide();
					layer.msg(d.info,{icon:6},function(){
						location.reload();
					});
				 }else{
					 $('.popup').hide();
					 layer.msg(d.info);
				 }
			 }else{
				layer.msg('网络异常');
			 }
		 });
		 layer.close(index);
	});
}

function sk(){
	var mobile = $('#mobile').val();
		points = $('#points').val();
		points_type = $('#points_type option:selected').val();
	if(!mobile){
		layer.msg('请输入收款人手机号码');
		return false;
	}
	if(!points){
		layer.msg('请输入积分');
		return false;
	}
	$.post("./index.php?m=&c=Ajax&a=deposit",{mobile:mobile,points:points,points_type:points_type},function(d){
		 if(d){
			 if(d.status){
				$('.popup').toggle();
				layer.msg(d.info,{icon:6},function(){
					location.reload();
				});
			 }else{
				 $('.popup').toggle();
				 layer.msg(d.info);
			 }
		 }else{
			layer.msg('网络异常');
		 }
	})
}






















