<?php
    if (!isset($_POST['i']) || !isset($_POST['c'])){
        echo "Error";
        exit;
    }
    $cid = intval($_POST['c']);
    $id = intval($_POST['i']);
    include ("../../db/DB.Class.php");
    $db = new DB();
    $sql = "select * from contest where cid = $cid";
    $res = $db->dql($sql);
    if ($res && $res->num_rows > 0){
        $row = $res->fetch_assoc();
        $type = intval($row['type']);
        if ($type == 0){
            $sql = "update contest_user set ischeck = 1 where cid = $cid and uid = $id";
            $db->dml($sql);
        } else {
            $sql = "update contest_team set ischeck = 1 where cid = $cid and tid = $id";
            $db->dml($sql);
        }
    }
?>