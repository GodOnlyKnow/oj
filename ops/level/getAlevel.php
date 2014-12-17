<?php
    if (!isset($_POST['lid']) || !isset($_POST['d']) || !isset($_POST['a']) || !isset($_POST['m'])){
        echo "Error";
        exit();
    }
    $lid = $_POST['lid'];
    $isd = $_POST['d'];
    $isa = $_POST['a'];
    $ism = $_POST['m'];

    include ("../../db/DB.Class.php");
    $db = new DB();
    $sql = "select * from alevel where lid = " . $lid;
    $res = $db->dql($sql);
    if ($res && $res->num_rows > 0){
        while ($row = $res->fetch_assoc()){
            echo sprintf("<tr id='alid%d' data-name='%s' data-desci='%s'><td>%s</td><td>%s</td>",$row['alid'],$row['name'],$row['desci'],$row['name'],$row['desci']);
            echo "<td>";
            if ($ism) echo sprintf("<a class='btn btn-default' onclick='alevel(3,%d)'>修改</a>",$row['alid']);
            if ($isd) echo sprintf("<a class='btn btn-default' onclick='alevel(2,%d)'>删除</a>",$row['alid']);
            echo "</td></tr>";
        }
    }
?>