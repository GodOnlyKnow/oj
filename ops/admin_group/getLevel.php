<?php
    if (!isset($_POST['g'])){
        echo "Error";
        exit();
    }
    $gid = intval($_POST['g']);
    include ("../../db/DB.Class.php");
    include ("../../conf.php");
    $db = new DB();
    $sql = "select * from level";
    $res = $db->dql($sql);
    $json = array();
    echo sprintf('<button type="button" class="btn btn-default" onclick="saveChange(%d)">保存配置</button>',$gid);
    if ($res && $res->num_rows > 0){
        while ($row = $res->fetch_assoc()){
            //if ( intval($row['lid']) == 1 && !IS_PREDOM) continue;
            $sql3 = "select * from admin_grooup_level where gid = " . $gid . "  and lid = " . $row['lid'];
            $res3 = $db->dql($sql3);
            if ($res3 && $res3->num_rows > 0){
                $row3 = $res3->fetch_assoc();
                echo "<div><input type='checkbox' checked /><a class='menu-o btn nav-header collapsed' data-toggle='collapse' href='#" . $row['name'] . "'>" . $row['name'] . "</a></div>";
                echo "<ul id='".$row['name']."' class='nav nav-list collapse menu-s'>";
                $mks = explode(',',$row3['levelmark']);
                $sql2 = "select * from alevel where lid = " . intval($row['lid']);
                $res2 = $db->dql($sql2);
                if ($res2 && $res2->num_rows > 0){
                    while ($row2 = $res2->fetch_assoc()){
                        $flag = 0;
                        foreach ($mks as $iii) if (intval($iii) == intval($row2['alid'])) $flag = 1;
                        
                        if ($flag == 1)
                            echo "<li><input type='checkbox' data-id='" . $row2['alid'] . "' checked />" . $row2['name'] . "</li>";
                        else 
                            echo "<li><input type='checkbox' data-id='" . $row2['alid'] . "' />" . $row2['name'] . "</li>";
                    }
                }
                echo "</ul>";
            } else {
                echo "<div class='bg-primary'><label><input type='checkbox' /><a class='menu-o nav-header collapsed' data-toggle='collapse' href='#" . $row['name'] . "'>" . $row['name'] . "</a><label></div>";
                echo "<ul id='".$row['name']."' class='nav nav-list collapse menu-s'>";
                $sql2 = "select * from alevel where lid = " . intval($row['lid']);
                $res2 = $db->dql($sql2);
                if ($res2 && $res2->num_rows > 0){
                    while ($row2 = $res2->fetch_assoc()){
                        echo "<li><input type='checkbox' data-id='" . $row2['alid'] . "' />" . $row2['name'] . "</li>";
                    }
                }
                echo "</ul>";
            }
        }
    }
?>