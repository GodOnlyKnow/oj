<?php
    if (!isset($_POST['op']) || !isset($_POST['id'])){
        echo "Error";
        exit();
    }
    $op = intval($_POST['op']);
    $gid = intval($_POST['id']);
    include ("../../db/DB.Class.php");
    $db = new DB();
    if ($op == 1){
        $name = $db->real($_POST['n']);
        $desci = $db->real($_POST['d']);
        $sql = "select * from admin_group where name = '$name'";
        $res = $db->dql($sql);
        if ($res && $res->num_rows == 0){
            $sql = "insert into admin_group (name,desci) values ('$name','$desci')";
            $res = $db->dml($sql);
            if ($res[0] == 'S'){
                echo "添加成功";
            } else {
                echo $res;
            }
        } else {
            echo "名称已存在";
        }
    } else if ($op == 2){
        $sql = "delete from admin_group where gid = $gid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    } else {
        $name = $db->real($_POST['n']);
        $desci = $db->real($_POST['d']);
        $sql = "update admin_group set name = '$name',desci = '$desci' where gid = $gid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "修改成功";
        } else {
            echo $res;
        }
    }
?>