<?php
    if (!isset($_POST['g']) || !isset($_POST['p'])){
        echo "Error";
        exit();
    }
    $gid = intval($_POST['g']);
    $ps = explode(',',$_POST['p']);
    include ("../../db/DB.Class.php");
    $db = new DB();
    $arr = array();
    foreach ($ps as $pp){
        $sql = "select * from alevel where alid = $pp";
        $res = $db->dql($sql);
        if ($res && $res->num_rows > 0){
            $row = $res->fetch_assoc();
            if (empty($arr[$row['lid']])){
                $arr[$row['lid']] = $pp;
            } else {
                $arr[$row['lid']] = $arr[$row['lid']] . "," . $pp;
            }
        }
    }
    if (!empty($arr)){
        $error = "";
        foreach ($arr as $key=>$val){
            $sql = "select * from admin_grooup_level where gid = $gid and lid = $key";
            $res = $db->dql($sql);
            if ($res){
                if ($res->num_rows == 0){
                    $sql = "insert into admin_grooup_level (gid,lid,levelmark) values ($gid,$key,'$val')";
                    $res = $db->dml($sql);
                    if ($res[0] == 'F') $error = $error . $res;
                } else {
                    $sql = "update admin_grooup_level set levelmark = '$val' where gid = $gid and lid = $key";
                    $res = $db->dml($sql);
                    if ($res[0] == 'F') $error = $error . $res;
                }
            }
            
        }
        if ($error == "") echo "保存成功";
        else echo $error;
    }
    
?>