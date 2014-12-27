<?php
    if (!isset($_POST['op']) || !isset($_POST['id'])){
        echo "Error";
        exit();
    }
    $op = intval($_POST['op']);
    $pid = $_POST['id'];
    include ("../../db/DB.Class.php");
    $db = new DB();
    if ($op == 2){
        $sql = "delete from contest where cid = $pid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    } else {
        $sql = "delete from contest where cid in $pid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    }
?>
