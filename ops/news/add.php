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
     if (isset($_GET['cnid'])){
         
             $Marks = TRUE;
             $sql = 'select * from news where cnid = ' . $_GET['cnid'];
             $res = $db->dql($sql);
             $row = $res->fetch_assoc();
         
     } else if (isset($_POST['cnid'])) {
         
             $sql = sprintf("update news set uid = %s,cid = %s,title = '%s',context = '%s',last_time = '%s' where cnid = %s",$uid,
                            $_POST['cid'],$_POST['title'],$_POST['context'],$_POST['last_time'],intval($_POST['cnid']));
             
             $res = $db->dml($sql);
             echo $res;
         
     } else {
         if (isset($_POST['title'])){
         if (!empty($_POST['cid'])){
             $sql = sprintf("insert into news (uid,cid,title,context,last_time) values (%s,%s,'%s','%s','%s')",$uid,
                            $_POST['cid'],$_POST['title'],$_POST['context'], date('Y-m-d H:i:s',time()));
         } else{
             $sql = sprintf("insert into news (uid,title,context,last_time) values (%s,'%s','%s','%s')",$uid,
                            $_POST['title'],$_POST['context'], date('Y-m-d H:i:s',time()));
         }
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
                        <label class="span2 offset1">所属比赛：</label>
                        <div class="input-control text span8">
                            <input type="text" name="cid" value="<?php if($Marks) echo $row['cid']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">题目：</label>
                        <div class="input-control text span8">
                            <input type="text" name="title" value="<?php if($Marks) echo $row['title']; ?>" />
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="span2 offset1">正文：</label>
                        <div class="input-control textarea span8">
                            <textarea name="context"><?php if($Marks) echo $row['context']; ?></textarea>
                        </div>
                    </div>
                    <?php if(isset($_GET['cnid'])) echo sprintf("<input type='hidden' name='cnid' value='%s' />",$_GET['cnid']); ?>
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
