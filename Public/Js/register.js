var validate={username:1,password:1,cpassword:1,email:1}

$(function(){
	$("#regs").click(function(){
		
		if(validate.username==0 && validate.password==0 && validate.cpassword==0 && validate.email==0){
			alert(registerUrl);
			$.post(registerUrl,{
				"username":$("input[name='username']").val(),
				"password":$("input[name='password']").val(),
				"email":$("input[name='email']").val()
			},function(data){
				alert(data);
				if(data==1)
				$("#error").html("用户名已存在");
				else{
					window.location.href='Index';
				}
			},'json');
		}
		//验证用户名
		$("input[name='username']").trigger("blur");
		//验证密码
		$("input[name='password']").trigger("blur");
		//验证过确认密码
		$("input[name='cpassword']").trigger("blur");
		//验证邮箱
		$("input[name='email']").trigger("blur");
		
		return false;
	})
})
$(function(){
	
	//验证用户名
	$("input[name='username']").blur(function(){
		var username = $("input[name='username']");
		if(username.val().trim()==''){
			validate.username=1;
			username.parent().find("span").remove().end().append("<span class='error'>*</span>");
			return ;
		}
		else{
			username.parent().find("span").remove();
			validate.username=0;
		}
	})
	//验证密码
	$("input[name='password']").blur(function(){
		var password = $("input[name='password']");
		if(password.val().trim()==''){

			validate.password=1;
			password.parent().find("span").remove().end().append("<span class='error'>*</span>");
			return ;
		}
		else{
			password.parent().find("span").remove();
			validate.password=0;
			
		}
	})
	//验证确认密码
	$("input[name='cpassword']").blur(function(){
		var cpassword = $("input[name='cpassword']");
		var password = $("input[name='password']");
		if(cpassword.val().trim()==''){
			validate.username=1;
			cpassword.parent().find("span").remove().end().append("<span class='error'>*</span>");
			return ;
		}
		else{
			cpassword.parent().find("span").remove();
			if(cpassword.val()!=password.val())
			{
				cpassword.parent().find("span").remove().end().append("<span class='error'>两次密码不一致</span>");
				validate.cpassword=1;
			}
			else{
				password.parent().find("span").remove();
				validate.cpassword=0;
			}
		}
	})
	//验证邮箱
	$("input[name='email']").blur(function(){
		var email = $("input[name='email']");
		if(email.val().trim()==''){
			validate.email=1;
			email.parent().find("span").remove().end().append("<span class='error'>*</span>");
			return ;
		}
		else{
			email.parent().find("span").remove();
			validate.email=0;
		}
	})
})