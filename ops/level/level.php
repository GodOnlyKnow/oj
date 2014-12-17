<?php
    if (!isset($_POST['op']) || !isset($_POST['lid'])){
        echo "Error";
        exit();
    }
    $lid = intval($_POST['lid']);
    $op = intval($_POST['op']);
    include ("../../db/DB.Class.php");
    $db = new DB();

    if ($op == 1){
        if (!isset($_POST['name']) || !isset($_POST['desci'])){
            echo "Error.No input";
            exit();
        }
        $sql = sprintf("insert into level (name,desci) values ('%s','%s')",$_POST['name'],$_POST['desci']);
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            $sql = sprintf("select lid from level where name = '%s'",$_POST['name']);
            $res = $db->dql($sql);
            if ($res){
                $row = $res->fetch_assoc();
                $lid = $row['lid'];
                $sql = sprintf("insert into alevel (lid,name) values (%d,'添加%s'),(%d,'删除%s'),(%d,'修改%s')",$row['lid'],$_POST['name'],$row['lid'],$_POST['name'],$row['lid'],$_POST['name']);
                $res = $db->dml($sql);
                if ($res[0] == 'S'){
                    $sql = "select * from alevel where lid = " . $row['lid'];
                    $res2 = $db->dql($sql);
                    if ($res2 && $res2->num_rows > 0){
                        $lmark = '';
                        while ($row2 = $res2->fetch_assoc()){
                            if (empty($lmark))
                                $lmark = $row2['alid'];
                            else $lmark = $lmark . ',' . $row2['alid'];
                        }
                        $sql = sprintf("insert into admin_grooup_level (gid,lid,levelmark) values (1,%d,'%s')",$lid,$lmark);
                        $db->dml($sql);
                    }
                    if (file_exists("../" . $_POST['desci']))
                        echo "添加成功";
                    else {
                        if (!mkdir("../" . $_POST['desci'])) 
                            echo "创建文件夹失败。请手动创建文件夹" . $_POST['desci'] . "到目录ops/下。";
                    }
                } else {
                    echo $res;
                }
            } else "添加成功。但是未生成基础条目。";
        } else {
            echo $res;
        }

    } else if ($op == 2){
        $sql = "delete from alevel where lid = " . $lid;
        $res = $db->dml($sql);
        if ($res[0] == 'F'){
            echo $res;
            exit();
        }
        $sql = "delete from admin_grooup_level where lid = " .$lid;
        $res = $db->dml($sql);
        if ($res[0] == 'F'){
            echo $res;
            exit();
        }
        $sql = "delete from level where lid = " . $lid;
        $res = $db->dml($sql);
        if ($res[0] == 'F'){
            echo $res;
            exit();
        }
        echo "删除成功";
    } else if ($op == 3){
        if (!isset($_POST['name']) || !isset($_POST['desci'])){
            echo "Error.No input";
            exit();
        }
        $sql = sprintf("update level set name = '%s' ,desci = '%s' where lid = %d",$_POST['name'],$_POST['desci'],$lid);
        $res = $db->dml($sql);
        if ($res[0] == 'S'){
            echo "修改成功";
        } else {
            echo $res;
        }
    }
?>