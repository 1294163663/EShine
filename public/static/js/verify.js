function verify(){
    console.log("ok");
	var myreg1 = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	var myreg2 = /^[\u4e00-\u9fa5]{2,8}$/;
	if (!myreg2.test($("#studentName").val())) {
		alert('请输入正确的姓名！'); 
		return false; 
	}
	if(!myreg1.test($("#phone").val())) 
	{ 
		alert('请输入有效的手机号码！'); 
		return false; 	
	} 
	
	else{
		if(confirm("确定提交吗？")){
			$("#myForm").submit();
		}
	}
}

