// 评论分数
function onStar(obj) {
	var val = $(obj).html();
	var star = "rating left active star" + val;
	document.getElementById('score_rep').className = star;
}

function onstarclick(obj){
	var val = $(obj).html();
	var star = "rating left active star" + val;
	document.getElementById('score_rep').className = star;
	$("#score").val(val);
	console.log($("#score").val());
}

//删除已经下单的单个商品
function deleteOrder(cart_id,order_id){
	if(cart_id && order_id){
		layer.confirm('您是否删除这个商品吗？',
			{btn: ['狠心删除','放你一码']}, 
			function(){
				$.post("./index.php?m=&c=Ajax&a=deleteOneCart",{cart_id:cart_id,order_id:order_id},function(d){
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

//显示评价曾
var product_id,cart_id;
function popShow(pid,cartid){
	product_id = pid;
	cart_id = cartid;
	console.log(cart_id);
	$('#userComment').toggle();
}

var flag = true;
function comment(){
	if(flag){
		flag = false;
		$('.mask').show();
		if(product_id>0 && cart_id){
			var score = $("#score").val();
				content = $('#content').val();
			if(content == ''){
				layer.msg('请输入评价内容');
				flag = true;
				return false;
			}
			$.post("./index.php?m=&c=Ajax&a=assess",{product_id:product_id,cart_id:cart_id,score:score,content:content},function(d){
				if(d){
					$('.mask').hide();
					if(d.status){
						flag = true;
						layer.alert(d.info,function(){		
							location.reload();							
						});			
					}else{
						flag = true;
						layer.msg(d.info,{icon:5});
					}
					
				}else{
					flag = true;
					layer.msg('网络异常',{icon:5});
				}
			});
		}else{
			layer.msg('商品信息错误');
		}
	}
}