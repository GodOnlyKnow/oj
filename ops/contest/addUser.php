<?php
    if (!isset($_POST['c']) || !isset($_POST['u'])){
        echo "Error";
        exit;
    }
    $cid = intval($_POST['c']);
    $uid = $_POST['u'];
    $arr = explode(',',$uid);
    include ("../../db/DB.Class.php");
    $db = new DB();
    $sql = "select * from contest where cid = $cid";
    $res = $db->dql($sql);
    if ($res && $res->num_rows > 0){
        $row = $res->fetch_assoc();
        $type = intval($row['type']);
        if ($type == 0){
            for ($i = 0;$i < count($arr);$i++) {
                $sql = "insert into contest_user (cid,uid,ischeck) values ($cid,$arr[$i],1)";
                $db->dml($sql);
            }
            echo "添加成功";
        } else {
            for ($i = 0;$i < count($arr);$i++) {
                $sql = "insert into contest_team (cid,tid,ischeck) values ($cid,$arr[$i],1)";
                $db->dml($sql);
            }
            echo "添加成功";
        }

    } else {
        echo "Error";
    }
?>