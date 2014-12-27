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
        $sql = "delete from problem where pid = $pid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    } else {
        $sql = "delete from problem where pid in $pid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    }
?>
