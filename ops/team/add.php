<?php
    if (!isset($_POST['uid']) || !isset($_POST['tid'])){
        echo "ERROR";
        eixt();
    }
    $uid = '(' . $_POST['uid'] . ')';
    $tid = intval($_POST['tid']);
    include ("../../db/DB.Class.php");
    $db = new DB();
    $sql = "update user set tid = $tid where uid in $uid";
    $res = $db->dml($sql);
    if ($res[0] == 'S')
        echo "添加成功";
    else echo $res;
?>
