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
<title>Problemlist</title>
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
		    <a class="dropdown-toggle" data-toggle="dropdown"  href="#" >Contests<span class="caret"></span></a>
		    
		    <ul class="dropdown-menu" role="menu">
		    	 <li><a href="<?php echo U('Contest/Index/index','','');?>">School Contests</a></li>
		    	 <li><a href="#">Virtual Contests</a></li>
		    	 <li><a href="#">Recent Contests</a></li>
		    </ul>
		  	</li>
			<li role="presentation"><a href="<?php echo U('Index/Index/Status','','');?>">Status</a></li>
		</ul>
		</div>
	</div>
	

	<div id="mainlist" class="container">
	<div class="container-fluid" style="background-color:#787676;">
	<div class="navbar-form">
		<div class="input-group navbar-left searchbar">
          <input type="text" id="searchinfo" class="form-control" placeholder="enter any words">
         <span class="input-group-addon" id="submitinfo">Search</span>
         </div>
	   <nav class="navbar-right">
	      <ul class="pagination" style="margin: 0">
	       <?php  $SearchUrl=U('Index/Problemlist','',''); $rear=$nowpage-1; $str=''; if($info!=null)$str='&info='.$info; if($nowpage==1) echo'<li class="disabled"><a href="#">&laquo;</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$rear.$str.'">&laquo;</a></li>'; ?>
	       <?php
 $str=''; if($info!=null)$str='&info='.$info; if($pages<=5){ for($i=1;$i<=$pages;$i++){ if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$i.$str.'">'.$i.'</a></li>'; } } else{ if($nowpage<=3) for($i=1;$i<=5;$i++){ if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$i.$str.'">'.$i.'</a></li>'; } else if($pages-$nowpage<=2) for($i=$pages-4;$i<=$pages;$i++){ if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$i.$str.'">'.$i.'</a></li>'; } else for($i=$nowpage-2;$i<=$nowpage+2;$i++){ if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$i.$str.'">'.$i.'</a></li>'; } } ?>
	       <?php  $front=$nowpage+1; $str=''; if($info!=null)$str='&info='.$info; if($nowpage==$pages) echo'<li class="disabled"><a href="#">&raquo;</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$front.$str.'">&raquo;</a></li>' ?>
	      </ul>
	    </nav>
	</div>
	</div>
	<table id="list"  class="list">
		<tr>
			<th width="150px">Problem ID</th>
			<th>Title</th>
			<th>Source</th>
			<th>AC</th>
			<th>Submit</th>
		</tr>
		<?php if(is_array($data)): foreach($data as $key=>$p): ?><tr>
			<td id="pi"><?php echo ($p["pid"]); ?></td>
			<td><a href="<?php echo "Problem?problemid=".$p['pid']?>" id="pn"><?php echo ($p["pname"]); ?></a></td>
			<td><?php echo ($p["source"]); ?></td>
			<td><?php echo ($p["accepted"]); ?></td>
			<td><?php echo ($p["submit"]); ?></td>
		</tr><?php endforeach; endif; ?>
	</table>

	<div class="container-fluid" style="margin:40px 0;">
	<div class="navbar-form">
	   <nav class="navbar-right">
	      <ul class="pagination" style="margin: 0">
	       <?php  $rear=$nowpage-1; $str=''; if($info!=null)$str='&info='.$info; if($nowpage==1) echo'<li class="disabled"><a href="#">&laquo;</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$rear.$str.'">&laquo;</a></li>'; ?>
	       <?php
 $str=''; if($info!=null)$str='&info='.$info; if($pages<=5){ for($i=1;$i<=$pages;$i++){ if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$i.$str.'">'.$i.'</a></li>'; } } else{ if($nowpage<=3) for($i=1;$i<=5;$i++){ if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$i.$str.'">'.$i.'</a></li>'; } else if($pages-$nowpage<=2) for($i=$pages-4;$i<=$pages;$i++){ if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$i.$str.'">'.$i.'</a></li>'; } else for($i=$nowpage-2;$i<=$nowpage+2;$i++){ if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$i.$str.'">'.$i.'</a></li>'; } } ?>
	       <?php  $front=$nowpage+1; $str=''; if($info!=null)$str='&info='.$info; if($nowpage==$pages) echo'<li class="disabled"><a href="#">&raquo;</a></li>'; else echo'<li><a href="'.$SearchUrl.'?page='.$front.$str.'">&raquo;</a></li>' ?>
	      </ul>
	    </nav>
	</div>
	</div>
</div>

	<link rel="stylesheet" href="__PUBLIC__/CSS/Tabletpl.css" />
	<script type="text/javascript" src='__PUBLIC__/JS/LiSt.js'></script>
	<script>
	var ProblemUrl="<?php echo U('Index/Problem','','');?>";
	var SearchUrl="<?php echo U('Index/Problemlist','','');?>";
	</script>
	<div id="BottombarI">
	<div class="container">
	<div id="BottombaI" >
	<div>CDOJ</div>
	<div style="color:#1f4368;">for ACM</div>
	</div>
	<div id="BottombaII">
	<div>UESTC Online Judge</div>
	<div>Any Problem,Please Report</div>
	<div>xxx xx xxx xx</div>
	</div>
	<div id="BottombaIII">
	<div>Neusoft</div>
	<div>Any Problem,Please Report</div>
	<div>xxx xx xxx xx</div>
	</div>
	</div>
	</div>
	<div id="BottombarII">
	
	</div>
	<link rel="stylesheet" href="__PUBLIC__/CSS/Bottom.css" />
</body>
</html>