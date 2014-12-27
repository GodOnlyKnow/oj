<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="__PUBLIC__/CSS/bootstrap.min.css" />
<link rel="stylesheet" href="__PUBLIC__/CSS/Top.css" />
<script src="__PUBLIC__/JS/jquery-1.11.1.min.js"></script>
<script src="__PUBLIC__/JS/bootstrap.min.js"></script>
<script src="__PUBLIC__/JS/Top.js"></script>
<script>
	var verifyUrl="<?php echo U('Index/Index/verify','','');?>";
	var RegistUrl="<?php echo U('Index/Index/Register','','');?>";
	var LoginUrl="<?php echo U('Index/Index/Login','','');?>";
	var Checkname="<?php echo U('Index/Index/Checkvalue','','');?>";
</script>
<title><?php echo ($data["pname"]); ?></title>
</head>
<body>
	<div id="topba" style="width: 80%; margin:  0 auto" >
	<ul class="nav nav-pills" role="tablist" id="topmenu">
	<li role="presentation"><a href="#">RecentsNews</a></li>
    <li role="presentation"><a href="#">Step-By-Step</a></li>
  	<li role="presentation"><a href="#">Download</a></li>
  	<li role="presentation"><a href="#">Ranklist</a></li>
  	<li role="presentation"><a href="#">FA.Qs</a></li>
  	<li role="presentation"><a href="#">BBS</a></li>
  	<li role="presentation"><a href="#">Users</a></li>
  	<li>
  	<?php
 if(isset($_SESSION['username'])==false){ echo '<button type="button" class="btn" id="signin">Sign In...</button>'; } else{ echo '<span id="welcome"><a href="#">'.$_SESSION['username'].'</a>欢迎你     <a id="loginout" href="#">退出</a></span>'; } ?>
  	</li>
  	
	</ul>
	</div>
	<div id="loginbar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content loginbar">
	    	<div class="loginba">Login<span aria-hidden="true" id="close" data-dismiss="modal" ><img src="__PUBLIC__/Image/LoginRegist/X.png"></span></div>
		    
		    <div id="loginform">
				<div class="input-group formfirst">
				  <span class="input-group-addon">Name:</span>
				  <input type="text" class="form-control must" id="loginuname" placeholder="Please enter username">
				</div>
				<div class="input-group">
				  <span class="input-group-addon">Password:</span>
				  <input type="password" class="form-control must" id="loginpwd" placeholder="Please enter password">
				</div>
			</div>
			<div class="loginline"></div>
			<div class="btns">
				<button type="button" class="btn" id="loginBtn">Login</button>
				<button type="button" class="btn" id="registBtn" >Regist</button>
			</div>
	  </div>
	</div>
	</div>
	<div id="Registbar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content Regist-Content">
	    	<div class="registba">Regist<span aria-hidden="true" id="Xclose" data-dismiss="modal" ><img src="__PUBLIC__/Image/LoginRegist/X.png"></span></div>
		    <div id="Registform">
				<div class="input-group formfirst">
				  <span class="input-group-addon">Name:</span>
				  <input type="text" class="form-control must" id="rgname" placeholder="Please enter username" data-container="body" data-tigger="focus" data-toggle="popover" data-placement="right" data-content="用户名只由字母、数字、下划线构成的长度6-30">
				</div>
				<div class="input-group">
				  <span class="input-group-addon">Password:</span>
				  <input type="password" class="form-control must" id="rgpwd" placeholder="Please enter password">
				</div>
				<div class="input-group">
				  <span class="input-group-addon">Confirm Password:</span>
				  <input type="password" class="form-control must" id="rgrepwd" placeholder="Please confirm password">
				</div>
				<div class="input-group">
				  <span class="input-group-addon">E-mail:</span>
				  <input type="text" class="form-control must" id="rgemail" placeholder="Please enter Email">
				</div>
				<div class="input-group">
				  <span class="input-group-addon">Verify:</span>
				  <input type="text" class="form-control must" id="rgverify">
				  <img src=<?php echo U("Index/Index/verify",'','');?> id="verify_code"/>
				</div>
			</div>
			
			<div class="loginline"></div>
			<div class="btns">
				<button type="button" class="btn" id="registedBtn">Regist</button>
				<button type="button" class="btn" id="resetBtn" >Reset</button>
			</div>
	  </div>
	</div>
	</div>
	<div id="Registsuccess" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	    	<div>注册成功</div>
	    	<button type="button" class="btn">完善个人资料</button>
			<button type="button" class="btn">暂时不用</button>
	  </div>
	</div>
	</div>
	<div class="container">
	<a id="Brand" href="#">
		<div id="cdoj">CDOJ</div>
		<div id="neu">Neusoft University</div>
	</a>
		<div id="navi">
		<ul class="nav nav-pills">
		    <li role="presentation"><a href="<?php echo U('Index/Index/Index','','');?>">Home</a></li>
		    <li role="presentation"><a href="<?php echo U('Index/Index/Problemlist','','');?>">Problems</a></li>
		    <li role="presentation" class="dropdown">
		    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		    Contests<span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu" role="menu">
		    	 <li role="presentation"><a href="<?php echo U('Contest/Index/index','','');?>">School Contests</a></li>
		    	 <li role="presentation"><a href="#">Virtual Contests</a></li>
		    	 <li role="presentation"><a href="#">Recent Contests</a></li>
		    </ul>
		  	</li>
			<li role="presentation"><a href="<?php echo U('Index/Index/Status','','');?>">Status</a></li>
		</ul>
		</div>
	</div>
	


<div id="pno">Problem<span style="font-weight:bold;color:rgb(170,170,170);margin:0 10px">></span><span class="pnoid">PID: <?php echo ($data["pid"]); ?></span></div>
<div id="topline"></div>
<div id="back">
	<div id="pname"><?php echo ($data["pname"]); ?></div>
	<div id="limit">
	<span>Time Limit: </span><span class="limitdata"><?php echo ($data["time"]); ?> Sec</span> 
	<span>Memory Limit: </span><span class="limitdata"><?php echo ($data["memory"]); ?> MB</span>
	<span>Submit: </span><span class="limitdata"><?php echo ($data["submit"]); ?></span> 
	<span>Solve: </span><span class="limitdata"><?php echo ($data["solved"]); ?></span>
	</div>
	<div class="btns">
		<button type="button" class="Pre btn">Previous</button>
	<?php
 if(isset($_SESSION['username'])==false){ echo '<button type="button" class="Submit btn submitbtn" onclick="loginFalse()">Submit</button>'; } else{ echo '<button type="button" class="Submit btn submitbtn" onclick="loginTrue()">Submit</button>'; } ?>
		<button type="button" class="Status btn">Status</button>
		<button type="button" class="Next btn">Next</button>
	</div>
</div>
	<div id="back1">
	<div class="problemTag">
	--&nbsp;<span style="font:42px arial;">D</span>escription&nbsp;--
	</div>
	<div class="problemTagtext">
	<?php echo ($data["desci"]); ?>
	</div>
	<div class="problemTag">
	--&nbsp;<span style="font:42px arial;">I</span>nput&nbsp;--
	</div>
	<div class="problemTagtext">
	<?php echo ($data["input"]); ?>
	</div>
	<div class="problemTag">
	--&nbsp;<span style="font:42px arial;">O</span>utput&nbsp;--
	</div>
	<div class="problemTagtext">
	<?php echo ($data["output"]); ?>
	</div>
	<div class="problemTag">
	--&nbsp;<span style="font:42px arial;">S</span>imple&nbsp;&nbsp;input&nbsp;&&nbsp;output&nbsp;--
	</div>
	<div class="problemTagtext">
	<table id="inoutable">
	<tr>
		<th>Simple Input</th>
		<th>Simple Output</th>
	</tr>
	<tr>
		<td><?php echo ($data["indata"]); ?></td>
		<td><?php echo ($data["outdata"]); ?></td>
	</tr>
	</table>
	</div>
	<div class="problemTag">
	--&nbsp;<span style="font:42px arial;">S</span>ource&nbsp;--
	</div>
	<div class="problemTagtext">
	<?php echo ($data["source"]); ?>
	</div>
</div>
<div class="btns" id="bottombtn">
		<button type="button" class="Pre btn">Previous</button>
		<?php
 if(isset($_SESSION['username'])==false){ echo '<button type="button" class="Submit btn submitbtn" onclick="loginFalse()">Submit</button>'; } else{ echo '<button type="button" class="Submit btn submitbtn" onclick="loginTrue()">Submit</button>'; } ?>
		<button type="button" class="Status btn">Status</button>
		<button type="button" class="Next btn">Next</button>
</div>

<div id="submitbar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="SubmitContent">
    <div id="submitba">Submit</div>
      <textarea id="cpp-code"></textarea>
      <div class="btn-group" id="btnsgroup">
  		<button type="button" class="btn btn-default" id="0Btn">C</button>
  		<button type="button" class="btn btn-default active" id="1Btn">C++</button>
 	    <button type="button" class="btn btn-default" id="2Btn">Java</button>
	  </div>
	  <div id="submitbarBtnbar">
	  	<button type="button" id="SubmitBtn" class="SubmitbarBtn btn btn-primary">Submit</button>
		<button type="button" id="CancelBtn" class="SubmitbarBtn btn btn-primary">Cancel</button>
	  </div>
    </div>
  </div>
</div>

<script type="text/javascript" src='__PUBLIC__/JS/problem.js'></script>
<script type="text/javascript" src='__PUBLIC__/JS/codemirror.js'></script>
<script type="text/javascript" src='__PUBLIC__/JS/clike.js'></script>
<link rel="stylesheet" href="__PUBLIC__/CSS/codemirror.css" />
<link rel="stylesheet" href="__PUBLIC__/CSS/Problem.css" />
<script>
	var ProblemUrl="<?php echo U('Index/Problem','','');?>";
	var SubmitUrl="<?php echo U('Index/Submit','','');?>";
</script>
<script type="text/javascript">

var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('cpp-code'), {
    lineNumbers: true,
    smartIndent: true,
    electricChars:true,
    theme: 'default',
    mode: 'text/x-c++src'
}); 

</script>
</body>
</html>