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
            $sql = "delete from contest_user where cid = $cid and uid = $id";
            $res = $db->dml($sql);
            if ($res[0] == 'S'){
                echo "删除成功";
            } else {
                echo $res;
            }
        } else {
            $sql = "delete from contest_user where cid = $cid and tid = $id";
            $res = $db->dml($sql);
            if ($res[0] == 'S'){
                echo "删除成功";
            } else {
                echo $res;
            }
        }
    }
?>