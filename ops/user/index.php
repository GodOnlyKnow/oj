<?php
    if (!isset($_COOKIE['userid'])){
        header("Location:index.php");
        exit();
    }
    $uid = intval($_COOKIE['userid']);
    $uname = $_COOKIE['username'];
    include ("../../db/DB.Class.php");
    include ("../db/func.php");
    $db = new DB();
    if (!isset($_GET['lmark'])){
        getLmark($gid,$lmark,"普通用户",$uid,$db);
    } else {
        $lmark = $_GET['lmark'];
    }
    getNormalAttr($isa,$isd,$ism,$lmark,$db);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <?php getAllStyle(); ?>
        <script src="../js/user.js"></script>
    </head>
    <body style="width: 100%;">
        <div class="container-fluid">
         <div id="toolbar" class="row">
             <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <span class="navbar-brand">Tools</span>
                    </div>
             <?php
                 if ($isd) echo "<button class='btn btn-default' onclick='btnClick(4,-1)'>删除选中</button>";
                 if ($isa) echo "<a class='btn btn-default' href='add.php'>添加</a>";
                 showReload();
             ?>
                 </nav>
         </div>
         <div id="lists" class="row metro" style="width: 100%;">
            <table class="table striped hovered dataTable" id="datatable">
                <thead>
                    <tr><th><button class="btn btn-default" onclick="selectAll()">全选/反选</button></th><th>Team</th><th>用户名</th><th>邮箱</th><th>密码</th><th>年级</th><th>姓名</th><th>解决个数</th><th>提交总数</th><th>操作</th></tr>
                </thead>
                <tbody>
                <?php
                    $res = $db->dql('select * from user');
                    if ($res && $res->num_rows > 0){
                        while ($row = $res->fetch_assoc()){
                            echo sprintf("<tr><td><input type='checkbox' class='cbox' data-uid='%s' /></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",
                                    $row['uid'],$row['tid'],$row['username'],$row['email'],$row['password'],$row['grade'],$row['name'],$row['solved'],$row['submit']);
                            echo "<td>";
                            $id = $row['uid'];
                            if ($isd) echo "<button class='primary' onclick='btnClick(2,$id)'>删除</button>";
                            if ($ism) echo "<a class='button warning' href='add.php?id=$id'>修改</a>";
                            echo "</td></tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
         </div>
         </div>

         <?php
             delModel();
             tipModel();
         ?>
    </body>
</html>
