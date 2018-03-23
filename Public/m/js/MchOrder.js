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

	$.post("/index.php?m=&c=Mch&a=getOrder",{page:page,stats:_status},function(d){
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

$('.new-change-eleven').click(function(){
	$('.new-change-eleven').removeClass('active');
	$(this).addClass('active');
	_status = $(this).attr('_status');
	$('#orderlist').html('');
	page = 1;
	pullUpAction(1);	
});

//显示发货
var order_id;
function pShow(id){
	order_id = id;
	console.log(order_id);
	if($('.popup').css('display') == 'none'){
		$('.popup').show();
	}else{
		$('#express').val('');
		$('#express_no').val('');
		$('.popup').hide();
	}
	
}


//发货
function express(){
	if(order_id>0){
		var name = $('#express').val();
			no = $('#express_no').val();
		if(name==''){
			layer.msg('请输入快递公司');
			return false;
		}
		if(no==''){
			layer.msg('请输入快递单号');
			return false;
		}
		$.post("./index.php?m=&c=Mch&a=send_express",{order_id:order_id,name:name,no:no},function(d){
			if(d){
				$('.popup').hide();
				console.log(d);
				if(d.status == 1){
					layer.alert(d.info,function(){
						location.reload();
					});
				}else{
					layer.msg(d.info);
					layer.closeAll();
				}
			}else{
				layer.msg('网络异常',{icon:5});
			}
		});
	}else{
		layer.msg('订单错误!');
	}
	
}






	