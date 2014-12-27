<?php
    if (!isset($_POST['op']) || !isset($_POST['id'])){
        echo "Error";
        exit();
    }
    $op = intval($_POST['op']);
    $uid = $_POST['id'];
    include ("../../db/DB.Class.php");
    $db = new DB();
    if ($op == 1){
        $name = $db->real($_POST['n']);
        $phone = $db->real($_POST['p']);
        $psd = md5($db->real($_POST['ps']));
        $username = $db->real($_POST['u']);
        $email = $db->real($_POST['e']);
        $gname = $db->real($_POST['g']);
        $sql = "select * from admin_user where username = '$username'";
        $res = $db->dql($sql);
        if ($res && $res->num_rows == 0){
            $sql = "select * from admin_group where name = '$gname'";
            $res = $db->dql($sql);
            $row = $res->fetch_assoc();
            $gid = intval($row['gid']);
            $sql = "insert into admin_user (name,username,psd,phone,email,gid) values ('$name','$username','$psd','$phone','$email',$gid)";
            $res = $db->dml($sql);
            if ($res[0] == 'S'){
                echo "添加成功";
            } else {
                echo $res;
            }
        } else {
            echo "用户名已存在";
        }
    } else if ($op == 2){
        $sql = "delete from admin_user where uid = $uid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    } else if ($op == 3){
        $name = $db->real($_POST['n']);
        $phone = $db->real($_POST['p']);
        $psd = md5($db->real($_POST['ps']));
        $username = $db->real($_POST['u']);
        $email = $db->real($_POST['e']);
        $gname = $db->real($_POST['g']);
        $sql = "select * from admin_group where name = '$gname'";
        $res = $db->dql($sql);
        $row = $res->fetch_assoc();
        $gid = $row['gid'];
        $sql = "update admin_user set name = '$name',username = '$username',phone = '$phone',psd = '$psd',email = '$email',gid = '$gid' where uid = $uid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "修改成功";
        } else {
            echo $res;
        }
    } else {
        $sql = "delete from admin_user where uid in $uid";
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "删除成功";
        } else {
            echo $res;
        }
    }
?>