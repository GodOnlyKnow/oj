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
<title>Contest</title>
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
		<div class="input-group navbar-left searchbar" style="margin-bottom: 10px;">
          <input type="text" id="searchinfo" class="form-control" placeholder="enter any words">
         <span class="input-group-addon" id="submitinfo">Search</span>
         </div>
	   <nav class="navbar-right">
	      <ul class="pagination" style="margin: 0">
	       <?php $rear=$nowpage-1; $str=''; if($info!=null)$str='&info='.$info; if($nowpage==1) echo'<li class="disabled"><a href="#">&laquo;</a></li>'; else echo'<li><a href="'.U('Index/index','','').'?p='.$rear.$str.'">&laquo;</a></li>' ?>
            <?php
 $str=''; if($info!=null)$str='&info='.$info; if($pages<=5) { for($i=1;$i<=$pages;$i++) { if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.U('Index/index','','').'?p='.$i.$str.'">'.$i.'</a></li>'; } } else { if($nowpage<=3) for($i=1;$i<=5;$i++) { if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.U('Index/index','','').'?p='.$i.$str.'">'.$i.'</a></li>'; } else if($pages-$nowpage<=2) for($i=$pages-4;$i<=$pages;$i++) { if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.U('Index/index','','').'?p='.$i.$str.'">'.$i.'</a></li>'; } else for($i=$nowpage-2;$i<=$nowpage+2;$i++) { if($i==$nowpage)echo'<li class="active"><a href="#">'.$i.'</a></li>'; else echo'<li><a href="'.U('Index/index','','').'?p='.$i.$str.'">'.$i.'</a></li>'; } } ?>
            <?php $front=$nowpage+1; $str=''; if($info!=null)$str='&info='.$info; if($nowpage==$pages) echo'<li class="disabled"><a href="#">&raquo;</a></li>'; else echo'<li><a href="'.U('Index/index','','').'?p='.$front.$str.'">&raquo;</a></li>' ?>
	      </ul>
	    </nav>
	</div>
	</div>
        <table class="altrowstable" id="alternatecolor">
            <tr>
                <th class="id">CID</th>
                <th class="name">Name</th>
                <th class="time">Time</th>
                <th class="length">Length</th>
                <th class="type">Type</th>
                <th class="status">Status</th>
            </tr>
            <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr <?php if($v['level']=='2') echo' style="background-color:#fc9f9f " '; else if($v['level']=='1') echo' class="secondrow" style="background-color:#ffcfa4" '; ?> >
                <td <?php if($v['level']=='2') echo' style="background-color:#f87373 " '; else if($v['level']=='1') echo' class="secondrow" style="background-color:#f9be69" '; ?> ><?php echo ($v["cid"]); ?></td>
                <td class="contest" onclick="fun(<?php echo ($v["cid"]); ?>)"><a href="javascript:void(0)"><?php echo ($v["name"]); ?></a></td>
                <td><?php echo ($v["start_time"]); ?></td>
                <td><?php echo ($v["length"]); ?></td>
                <td>
                    <span <?php if($v['private']=='0')echo' class="public" ';else if($v['private']=='1')echo'class="register" onclick="register('.$v["cid"].')" class="register"';else echo'class="private"'; ?> >
                        <?php if($v['private']=='0')echo'Public';else if($v['private']=='1')echo'<a href="javascript:void(0)">Register</a>';else echo'Private'; ?>
                    </span>
                    <?php if($v['private']=='1') echo' <a href="'.U("Contest/Index/register", '', '').'?cid='.$v['cid'].'"><span class="glyphicon glyphicon-search"></span></a>'; ?>
                </td>
                <td><?php echo ($v["sta"]); ?></td>
            </tr><?php endforeach; endif; ?>
        </table>
        </div>
       <div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-describedby="Inform" aria-hidden="false">
        <div class="modal-dialog modal-sm">
        <div class="modal-content" id="modalcontext">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title" id="myLargeModalLabel">Message</h4>
        </div>
        <h4 class="modal-body" id="modalmessage">
        ....
        </h4>
        <div class="modal-body" id="passwordbar" style="display: none">
            <input type="password" class="form-control" id="passwordvalue" placeholder="Password">
        </div>
        <div class="modal-body" id="passwordsend" style="display: none">
            <button type="button" class="btn btn-primary" id="passwordbtn">Submit</button>
        </div>
        </div>
      </div>
    </div>
         <script type="text/ecmascript">
            var formUrl = '<?php echo U("Contest/Index/form", '', '');?>';
            var handleUrl = '<?php echo U("Contest/Index/problemlist", '', '');?>';
            var registerUrl='<?php echo U("Contest/Index/register", '', '');?>';
            var indexUrl='<?php echo U("Contest/Index/index", '', '');?>';
            var countUrl ='<?php echo U("Contest/Index/newscount", '', '');?>';
            var cid="<?php echo ($contestinfo[0]['cid']); ?>";
        </script>
        <script src="__PUBLIC__/Js/jquery-1.10.2.min.js"></script>
        <script src="__PUBLIC__/Js/onload.js"></script>
        <script src="__PUBLIC__/Js/jquery-ui.min.js"></script>
        <link href="__PUBLIC__/Css/contest.css" rel="stylesheet">

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