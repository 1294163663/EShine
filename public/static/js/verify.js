function verify(){
    console.log("ok");
	var myreg1 = /^(\d{11})$/;
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

