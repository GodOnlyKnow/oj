<?php
    if (!isset($_POST['op']) || !isset($_POST['id'])){
        echo "Error";
        exit();
    }
    $op = intval($_POST['op']);
    $uid = $_POST['id'];
    include ("../../db/DB.Class.php");
    $db = new DB();
    if ($op == 2){
        $sql = "delete from user where uid = $uid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    } else {
        $sql = "delete from user where uid in $uid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    }
?>
