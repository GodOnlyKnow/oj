<?php
    if (!isset($_POST['i']) || !isset($_POST['c'])){
        echo "Error";
        exit;
    }
    $cid = intval($_POST['c']);
    $id = intval($_POST['i']);
    include ("../../db/DB.Class.php");
    $db = new DB();
    $sql = "delete from contest_problem where cid = $cid and pid = $id";
    $res = $db->dml($sql);
    if ($res[0] == 'S'){
        echo "删除成功";
    } else {
        echo $res;
    }
?>