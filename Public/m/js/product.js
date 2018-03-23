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
});

//设置购买数量
function setCount(type,val,pid){
	var num = parseInt(val);
	if(type == 1){//减少数量		
		if(num != 1){
			num--;
			$('#goodsCount').val(num);
		}
	}else{//增加数量
		num++;
		$.post('/index.php?m=&c=Ajax&a=checkSold',{num:num,pid:pid},function(d){		
			if(d){
				console.log(d);
				if(d.status){
					$('#goodsCount').val(num);
				}else{
					layer.msg(d.info,{icon:5});	
				}
			}else{
				layer.msg('网络异常',{icon:5});
			}
		});			
	}
}

/*
*加入购物车和立即购买;
*params：pid:商品id，type:1:加入购物车;2:立即购买
*/
function addCart(pid,type){
	if(pid && type){
		var nums = $('#goodsCount').val();
		$.post("/index.php?m=&c=Ajax&a=addCart",{pid:pid,nums:nums,is_zq:is_zq},function(d){
			if(d){
				console.log(d);
				if(d.status){
					var nums = $('#carNum').html();
					nums++;
					$('#carNum').html(nums);
					if(type==1){
						layer.confirm('成功加入购物车，是否结算？', {btn: ['去结算','再逛逛']}, function(){
							location.href=d.url;
						});	
					}else{
						location.href=d.url;
					}
				}else{
					layer.msg(d.info,{icon:5});	
				}
			}else{
				layer.msg('网络异常',{icon:5});
			}
		});
	}
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
			}else{
				layer.msg('网络异常',{icon:5});
			}
		});
	}
}

//切换评价
$('.liChange').click(function(){
	$('.liChange').removeClass('sel');
	$(this).addClass('sel');
	var index = $(this).attr('index');
	$('.changeByCli').hide();
	$('.ByCli'+index).show();
});


//加载评论
var p = 1;

//初始化加载评价信息
loadAssess();

function loadAssess(){
	if(product_id>0){
		$.post("./index.php?m=&c=Ajax&a=loadAssess",{product_id:product_id,page:p},function(d){
			if(d){
				console.log(d);
				if(d.status == 1){
					$('#list').html('');
					$('#list').append(d.info);	
					var vcount = p+"/"+assess_count;
					$('#vcount').html(vcount);
				}else if(d.status == 2){
					$('#list').html('');
					$('#list').append(d.info);
				}else if(d.status == 3){
					layer.msg(d.info);	
					p--;
				}
			}else{
				layer.msg('网络异常',{icon:5});
			}
		});
	}
}

//上一页
$('#prev').click(function(){
	if(p>1){
		p--;
		loadAssess();
	}
});


//下一页
$('#next').click(function(){
	p++;
	loadAssess();
});

















	