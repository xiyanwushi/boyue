/*
*公共方法Ajax=post提交数据
*url:提交地址，data:数据对象，reflash：是否刷新本页面
*/
function Ajax_query(url,reflash=true,data){
	$('#load').show();
	if(!data){
		data = $('form').serialize();
	}
	if(data && url){
		$.post(url,data,function(d){
			console.log(d);
			if(d){
				$('#load').hide();
				if(d.status){
					layer.msg(d.info,{icon:6},function(){
						if(d.url){
							location.href=d.url;
						}else{
							if(reflash){
								location.reload();
							}
						}
					});
				}else{
					layer.msg(d.info,{icon:5});
				}
			}else{
				layer.msg('请求失败!',{icon:5});
			}
		});
	}
}


//校验手机号
function checkMobile(mobile){
	var msg='';
	var myreg = /^1[34578]\d{9}$/;             
	if(mobile == ''){
		msg = '请输入您的手机号！';
	}else if(mobile.length !=11){
		msg = '您的手机号输入有误！';
	}else if(!myreg.test(mobile)){
		msg = '请输入有效的手机号！';
	}
	if(msg!=''){
		layer.msg(msg,{icon:5});
		return false;
	}else{
		return true;
	}
}


//身份证验证
function checkCardNo(code) { 
		var city={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外 "};
		var msg = "";
		if(!code || !/^[1-9][0-9]{5}(19[0-9]{2}|200[0-9]|2010)(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])[0-9]{3}[0-9xX]$/i.test(code)){
			msg = "身份证号格式错误";
		}else if(!city[code.substr(0,2)]){
			msg = "地址编码错误";
		}else{
			//18位身份证需要验证最后一位校验位
			if(code.length == 18){
				code = code.split('');
				//∑(ai×Wi)(mod 11)
				//加权因子
				var factor = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ];
				//校验位
				var parity = [ 1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2 ];
				var sum = 0;
				var ai = 0;
				var wi = 0;
				for (var i = 0; i < 17; i++)
				{
					ai = code[i];
					wi = factor[i];
					sum += ai * wi;
				}
				var last = parity[sum % 11];
				if(parity[sum % 11] != code[17]){
					msg = "校验位错误";
				}
			}
		}
		if(msg!=''){
			layer.msg(msg,{icon:5});
			return false;
		}else{
			return true;
		}
}

/*
*发送验证码
*ob:发送按钮元素
*/
function sendSms(ob){
	var mobile = $('input[name="mobile"]').val();
	if(checkMobile(mobile)){
		$.post("./index.php?m=&c=Mch&a=SendSms",{mobile:mobile},function(d){
			if(d){
				if(d.status){
					layer.msg(d.info,{icon:6});
					Settime(ob);
				}else{
					layer.msg(d.info,{icon:5});
				}
			}else{
				layer.msg('请求失败！',{icon:5});
			}
		});
	}
}


//验证码倒计时
var countdown = 30;
function Settime(ob) {
    if (countdown == 0) {
        $(ob).removeAttr("disabled");
        $(ob).val("发送验证码");
        countdown = 30;
        return;
    } else {
        $(ob).attr("disabled", true);
        $(ob).val("重新发送(" + countdown + ")");
        countdown--;
    }
    setTimeout(function () {
        Settime(ob);
    }, 1000);
}



//上传单张图片
function uploadPic(obj){
	//上传图片至服务器
	var img = $(obj.parentElement).find('img');
	var hid = $(obj.parentElement).find('input[type="hidden"]');
	lrz(obj.files[0], {
		done: function (results) {
			  // 你需要的数据都在这里，可以以字符串的形式传送base64给服务端转存为图片。
			  $.post("./index.php?m=&c=Ajax&a=upload_64",
					  {img:results.base64,size:results.base64.length},function(data){
				  if(data.status){
					  hid.val(data.info);
					  img.attr('src',data.info);
				  }else{
					  layer.msg(data.info,{icon:5});
				  }
			  });
		}
	});	
}
