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
	
var page = 1;
	
pullUpAction();

//type 区分首次加载显示背景遮罩
function pullUpAction(){
	$('#loading').show();
	$.post("/index.php?m=&c=Index&a=getAll",{page:page,order:order,type:type,cate_id:cate_id,feature:feature,keyword:keyword},function(d){
		if(d){
			console.log(d);
			if(d.status){
				$('#scroller ul').append(d.info);
				bindScroll();	
			}else{
				if($('.empty').length && $('.empty').length>0){
				}else{
					$('#scroller ul').append(d.info);	
				}
			}
			$('#loading').hide();
		}else{
			layer.msg('网络异常',{icon:5});
		}
	});
		
}


function bindScroll(){
	$(window).scroll(function(){
		// 当滚动到最底部以上50像素时， 加载新内容
		if ($(document).height() - $(this).scrollTop() - $(this).height() < 50){
			page++;
			$(window).unbind("scroll");
			pullUpAction();
		}
	});
}
	

$('#search-bar li').each(function(){
	$('#search-bar').find('li').removeClass('active');
	if($(this).attr('_li') == _li){
		$(this).addClass('active');
		$(this).find('a').css('color','#fff');
		return false;
	}
});


//搜索商品
function searchP(){
	keyword = $('#keyword').val();
	if(keyword == ''){
		layer.msg('请输入搜索内容',{icon:5});
		return false;
	}
	location.href="/index.php?m=&c=Index&a=all&keyword="+keyword;
}











	