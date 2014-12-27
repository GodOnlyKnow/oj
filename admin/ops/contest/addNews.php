<?php
    if (!isset($_POST['c']) || !isset($_POST['t']) || !isset($_POST['r'])){
        exit;
    }
    $uid = intval($_COOKIE['userid']);
    $cid = intval($_POST['c']);
    $title = $_POST['t'];
    $context = $_POST['r'];
    include ("../../db/DB.Class.php");
    $db = new DB();
    $sql = "insert into news (uid,cid,title,context) values ($uid,$cid,'$title','$context')";
    $db->dml($sql);
    echo "添加成功";
?>