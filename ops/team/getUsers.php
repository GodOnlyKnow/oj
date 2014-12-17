<?php
    if (!isset($_POST['tid'])){
        echo "ERROR";
        exit();
    }
    $tid = intval($_POST['tid']);
    include ("../../db/DB.Class.php");
    $db = new DB();
    $str = "<tr><td><input id='uids' type='text' class='form-control' placeholder='多个用户用\",\"分割' /></td><td><button class='btn btn-default' onclick='addUser($tid)'>添加</button></td><td id='addTips'></td></tr><tr><th>用户编号</th><th>用户名</th><th>操作</th></tr>";
    $sql = "select * from user where tid = $tid";
    $res = $db->dql($sql);
    if ($res && $res->num_rows > 0){
        while ($row = $res->fetch_assoc()){
            $str = $str . sprintf("<tr><td>%s</td><td>%s</td><td><button class='btn btn-default' onclick='removeUser(%d)'>移除</button></td></tr>",$row['uid'],$row['username'],intval($row['uid']));
        }
    }
    echo $str;
?>
