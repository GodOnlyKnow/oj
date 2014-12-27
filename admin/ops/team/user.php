<?php
    if (!isset($_POST['uid'])){
        echo "ERROR";
        exit();
    }
    $uid = intval($_POST['uid']);
    include ("../../db/DB.Class.php");
    $db = new DB();
    $sql = "update user set tid = null where uid = $uid";
    $res = $db->dml($sql);
    if ($res[0] == 'S')
        echo "删除成功";
    else echo $res;
?>
