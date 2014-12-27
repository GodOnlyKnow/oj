<?php
    if (!isset($_COOKIE['userid'])){
        header("Location:index.php");
        exit();
    }
     include ("../../db/DB.Class.php");
     include ("../db/func.php");
     $db = new DB();
     $uid = intval($_COOKIE['userid']);
     $Marks = FALSE;
     if (isset($_GET['id'])){
             $Marks = TRUE;
             $sql = 'select * from user where uid = ' . $_GET['id'];
             $res = $db->dql($sql);
             $row = $res->fetch_assoc();
     } else if (isset($_POST['uid'])) {
             $sql = sprintf("update user set tid = %d,username = '%s',email = '%s',password = '%s',grade = %d,class = %d,major = '%s',name = '%s',sex = %d where uid = %d",
                            intval($_POST['tid']),$_POST['username'],$_POST['email'],md5($_POST['password']),intval($_POST['grade']),intval($_POST['class']),$_POST['major'],$_POST['name'],$_POST['sex']=='on'?1:0,intval($_POST['uid']));
             
             $res = $db->dml($sql);
             echo $res;
         
     } else {
         if (isset($_POST['username'])){
             $sql = sprintf("insert into user (tid,username,email,password,grade,class,major,name,sex) values (%d,'%s','%s','%s',%d,%d,'%s','%s',%d)",
                            intval($_POST['tid']),$_POST['username'],$_POST['email'],md5($_POST['password']),intval($_POST['grade']),intval($_POST['class']),$_POST['major'],$_POST['name'],$_POST['sex']=='on'?1:0);
             $res = $db->dml($sql);
             echo $res;
         }
     }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <?php getMetroStyle(); ?>
    </head>
    <body class="metro">
        <div>
            <form action="add.php" method="post">
                <div class="grid">
                    <div class="row">
                        <label class="span2 offset1">Team：</label>
                        <div class="input-control text span8">
                            <input type="number" name="tid" value="<?php if($Marks) echo $row['tid']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">用户名：</label>
                        <div class="input-control text span8">
                            <input type="text" name="username" value="<?php if($Marks) echo $row['username']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">邮箱：</label>
                        <div class="input-control text span8">
                            <input type="email" name="email" value="<?php if($Marks) echo $row['email']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">密码：</label>
                        <div class="input-control text span8">
                            <input type="text" name="password" value="<?php if($Marks) echo $row['password']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">年级：</label>
                        <div class="input-control text span8">
                            <input type="number" name="grade" value="<?php if($Marks) echo $row['grade']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">班级：</label>
                        <div class="input-control text span8">
                            <input type="number" name="class" value="<?php if($Marks) echo $row['class']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">专业：</label>
                        <div class="input-control text span8">
                            <input type="text" name="major" value="<?php if($Marks) echo $row['major']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">姓名：</label>
                        <div class="input-control text span8">
                            <input type="text" name="name" value="<?php if($Marks) echo $row['name']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">性别：</label>
                        <div class="input-control switch span1">
                            <label>
                                <input type="checkbox" <?php if($Marks && intval($row['sex']) == 1) echo 'checked';  ?> name="sex" />
                                <span class="check"></span>
                            </label>
                        </div>
                    </div>
                    <?php if(isset($_GET['id'])) echo sprintf("<input type='hidden' name='uid' value='%s' />",$_GET['id']); ?>
                    <div class="row">
                        <div class="span1 offset4">
                            <input type="submit" class="default" value="Submit" />
                        </div>
                        <div class="span1 offset2">
                            <a href="index.php?lmark=13,14,15"><input type="button" value="Cancel" /></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
