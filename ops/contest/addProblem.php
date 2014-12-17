<?php
    if (!isset($_POST['c']) || !isset($_POST['p'])){
        echo "Error";
        exit;
    }
    $cid = intval($_POST['c']);
    $uid = $_POST['p'];
    $arr = explode(',',$uid);
    include ("../../db/DB.Class.php");
    $db = new DB();
    for ($i = 0;$i < count($arr);$i++) {
        $sql = "insert into contest_problem (cid,pid) values ($cid,$arr[$i])";
        $db->dml($sql);
    }
    echo "添加成功";
?>