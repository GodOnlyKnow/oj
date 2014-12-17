<?php
    if (!isset($_POST['op']) || !isset($_POST['id'])){
        echo "Error";
        exit();
    }
    $op = intval($_POST['op']);
    $tid = $_POST['id'];
    include ("../../db/DB.Class.php");
    $db = new DB();
    if ($op == 1){
        $name = $db->real($_POST['n']);
        $sql = "select * from team where name = '$name'";
        $res = $db->dql($sql);
        if ($res && $res->num_rows == 0){
            $sql = "insert into team (name) values ('$name')";
            $res = $db->dml($sql);
            if ($res[0] == 'S'){
                echo '添加成功';
            } else {
                echo $sql . "<br />" . $res;
            }
        } else {
            echo "用户名已存在";
        }
    } else if ($op == 2){
        $sql = "delete from team where tid = $tid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    } else if ($op == 3){
        $name = $db->real($_POST['n']);
        $sql = "update team set name = '$name' where tid = $tid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "修改成功";
        } else {
            echo $res;
        }
    } else {
        $sql = "delete from team where tid in $tid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    }
?>