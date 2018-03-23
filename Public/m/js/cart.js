$(function(){
	//初始化缩小html的size
	$('html').css('font-size','15px');
	var topBtn = document.getElementById('indexToTop');
	window.onscroll = function () {
		// 获取页面向上滚动距离，chrome浏览器识别document.body.scrollTop，而火狐识别document.documentElement.scrollTop，这里做了兼容处理
		var toTop = document.documentElement.scrollTop || document.body.scrollTop;
		// 如果滚动超过300，返回顶部按钮出现，反之隐藏
		if(toTop>=300){
			topBtn.style.display = 'block';
		}else {
			topBtn.style.display = 'none';
		}
	}
	topBtn.onclick=function () {
		var timer = setInterval(function () {
			var toTop = document.documentElement.scrollTop || document.body.scrollTop;
			// 判断是否到达顶部，到达顶部停止滚动，没到达顶部继续滚动
			if(toTop == 0){
				clearInterval(timer);
			}else {
				// 设置滚动速度
				var speed = Math.ceil(toTop/5);
				// 页面向上滚动
				document.documentElement.scrollTop=document.body.scrollTop=toTop-speed;
			}
		},50);
	}
	
	//初始化计算运费和总价
	total();
});

/*
*设置购买数量
*params:type:1:减少数量，2：增加数量；3：直接变成多少数量
*val:数量参数
*cid:购物车id
*/
function setCartNums(type,ob,cid){
	var num = parseInt(val);
	var model;
	if(type == 1){
		model = $(ob).next();
	}else if(type == 2){
		model = $(ob).prev();
	}else if(type == 3){
		model = $(ob);
	}
	var val = model.val();
	if(type && val && cid){
		if(val>=1){
			$.post("/index.php?m=&c=Ajax&a=setCartNums",{type:type,nums:val,cid:cid,addr:addr_id},function(d){
				if(d){
					if(d.status == 1){
						model.parents('.carts').find('.logis').html('运费:'+d.info.logis_fee)
						model.val(d.info.nums);
						total();
					}else if(d.status == 2){
						//不错任何处理（减少时候数量等于1）	
					}else{
						layer.msg(d.info,{icon:5});
					}
				}else{
					layer.msg('网络异常',{icon:5});
				}	
			});
		}
	}
}

//统计购物车价格
function total(){
	var arr = [];
	$('.checkbox').each(function(i,v){
		if($(this).hasClass('check-on')){
			arr.push($(this).attr('_cid'));
		}
	});
	
	$.post("/index.php?m=&c=Ajax&a=get_cart_total",{cids:arr.join(","),addr:addr_id},function(d){
		if(d){
			console.log(d);
			if(d.status){
				$('#logis_fee').html(d.info.logis_fee+'元');
				$('#total').html(d.info.total+'元');
				$('#points').html(d.info.points);
			}else{
				layer.msg(d.info,{icon:5});
			}
		}else{
			layer.msg('网络异常',{icon:5});
		}	
	});

}

//勾选checkbox
function choose(ob){
	if($(ob).find('input').hasClass('check-on')){
		$(ob).find('input').removeClass('check-on');
	}else{
		$(ob).find('input').addClass('check-on');
	}
	total();
}

//显示删除匡
var cart_id;
function DelShow(cid){
	$('#del').toggle();
	cart_id = cid;
}
//删除单个购物车内容
function DelCart(){
	if(cart_id){
		$.post("/index.php?m=&c=Ajax&a=delCart",{cids:cart_id},function(d){
			if(d){
				$('#del').toggle();
				if(d.status){
					layer.msg(d.info,{icon:6},function(){
						location.reload();
					});
				}else{
					layer.msg(d.info,{icon:5});
				}
			}else{
				layer.msg('网络异常',{icon:5});
			}	
		});
	}
}

function delAll(){
	layer.confirm('您确定要删除勾选的商品？', {btn: ['立即删除','暂时留着']}, function(){
		var arr = [];
		$('.checkbox').each(function(i,v){
			if($(this).hasClass('check-on')){
				arr.push($(this).attr('_cid'));
			}
		});
		if(arr.length>0){
			$.post("/index.php?m=&c=Ajax&a=delCart",{cids:arr.join(",")},function(d){
				if(d){
					if(d.status){
						layer.msg(d.info,{icon:6},function(){
							location.reload();
						});
					}else{
						layer.msg(d.info,{icon:5});
					}
				}else{
					layer.msg('网络异常',{icon:5});
				}	
			});
		}
	});
	
}


//结算
$('#checkout-btn').click(function(){
	var arr = [];
	$('.checkbox').each(function(i,v){
		if($(this).hasClass('check-on')){
			arr.push($(this).attr('_cid'));
		}
	});
	location.href="/index.php?m=&c=Index&a=order&addr="+addr_id+"&cids="+arr.join(",");
});


















	