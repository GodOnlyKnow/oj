<?php
     if (!isset($_POST['c']) || !isset($_POST['i'])){
        echo "Error";
        exit;
    }
    $cid = intval($_POST['c']);
    $id = $_POST['i'];
    include ("../../db/DB.Class.php");
    $db = new DB();
        $sql = "delete from news where cnid = $id and cid = $cid";
        $db->dml($sql);
    echo "删除成功";
?>
