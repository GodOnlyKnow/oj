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
     if (isset($_GET['pid'])){
         
             $Marks = TRUE;
             $sql = 'select * from problem where pid = ' . $_GET['pid'];
             $res = $db->dql($sql);
             $row = $res->fetch_assoc();
         
     } else if (isset($_POST['pid'])) {
         
             $sql = sprintf("update problem set uid = %d,pname = '%s',desci = '%s',input = '%s',output = '%s',indata = '%s',outdata = '%s',hint = '%s',source = '%s',author = '%s',memory = %d,time = %d,special = %d where pid = %d",$uid,
                            $_POST['name'],$_POST['desci'],$_POST['input'],$_POST['output'],$_POST['indata'],$_POST['outdata'],$_POST['hint'],$_POST['source'],$_POST['author'],intval($_POST['memory']),intval($_POST['time']),isset($_POST['special'])?($_POST['special']=='on'?1:0):0,intval($_POST['pid']));
             
             $res = $db->dml($sql);
             echo $res;
         
     } else {
         if (isset($_POST['name'])){
             $sql = sprintf("insert into problem (uid,pname,desci,input,output,indata,outdata,hint,source,author,memory,time,special) values (%d,'%s','%s','%s','%s','%s','%s','%s','%s','%s',%d,%d,%s)",$uid,
                            $_POST['name'],$_POST['desci'],$_POST['input'],$_POST['output'],$_POST['indata'],$_POST['outdata'],$_POST['hint'],$_POST['source'],$_POST['author'],intval($_POST['memory']),intval($_POST['time']),isset($_POST['special'])?($_POST['special']=='on'?1:0):0);
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
                        <label class="span2 offset1">题目：</label>
                        <div class="input-control text span8">
                            <input type="text" name="name" value="<?php if($Marks) echo $row['pname']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">描述：</label>
                        <div class="input-control textarea span8">
                            <textarea name="desci"><?php if($Marks) echo $row['desci']; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">输入描述：</label>
                        <div class="input-control textarea span8">
                            <textarea name="input"><?php if($Marks) echo $row['input']; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">输出描述：</label>
                        <div class="input-control textarea span8">
                            <textarea name="output"><?php if($Marks) echo $row['output']; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">输入样例：</label>
                        <div class="input-control textarea span8">
                            <textarea name="indata"><?php if($Marks) echo $row['indata']; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">输出样例：</label>
                        <div class="input-control textarea span8">
                            <textarea name="outdata"><?php if($Marks) echo $row['outdata']; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">提示：</label>
                        <div class="input-control textarea span8">
                            <textarea name="hint"><?php if($Marks) echo $row['hint']; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">来源：</label>
                        <div class="input-control text span8">
                            <input type="text" name="source" value="<?php if($Marks) echo $row['source']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">作者：</label>
                        <div class="input-control text span8">
                            <input type="text" name="author" value="<?php if($Marks) echo $row['author']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">内存限制(MB)：</label>
                        <div class="input-control text span8">
                            <input type="text" name="memory" value="<?php if($Marks) echo $row['memory']; ?>"/>
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">时间限制(MS)：</label>
                        <div class="input-control text span8">
                            <input type="text" name="time" value="<?php if($Marks) echo $row['time']; ?>"/>
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">特殊判题：</label>
                        <label class="span1">否</label>
                        <div class="input-control switch span1">
                            <label>
                                <input type="checkbox" name="special" <?php if($Marks && intval($row['special']) == 1) echo 'checked';  ?> />
                                <span class="check"></span>
                            </label>
                        </div>
                        <label class="span1">是</label>
                    </div>
                    <?php if(isset($_GET['pid'])) echo sprintf("<input type='hidden' name='pid' value='%s' />",$_GET['pid']); ?>
                    <div class="row">
                        <div class="span1 offset4">
                            <input type="submit" class="default" value="Submit" />
                        </div>
                        <div class="span1 offset2">
                            <input type="button" value="Cancel" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
