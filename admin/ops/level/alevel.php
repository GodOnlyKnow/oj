<?php
    if (!isset($_POST['op']) || !isset($_POST['alid'])){
        echo "Error";
        exit();
    }
    $alid = intval($_POST['alid']);
    $op = intval($_POST['op']);
    include ("../../db/DB.Class.php");
    $db = new DB();

    if ($op == 1){
        if (!isset($_POST['name']) || !isset($_POST['desci'])){
            echo "Error.No input";
            exit();
        }
        $sql = sprintf("insert into alevel (lid,name,desci) values (%d,'%s','%s')",$alid,$_POST['name'],$_POST['desci']);
        $res = $db->dml($sql);
        if ($res[0] == 'S'){

            echo "添加成功";
        } else {
            echo $res;
        }

    } else if ($op == 2){
        $sql = "delete from alevel where alid = " . $alid;
        $res = $db->dml($sql);
        if ($res[0] == 'F'){
            echo $res;
            exit();
        }
        echo "删除成功";
    } else if ($op == 3){
        if (!isset($_POST['name']) || !isset($_POST['desci'])){
            echo "Error.No input";
            exit();
        }
        $sql = sprintf("update alevel set name = '%s' ,desci = '%s' where alid = %d",$_POST['name'],$_POST['desci'],$alid);
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "修改成功";
        } else {
            echo $res;
        }
    }
?>