<?php
    if (!isset($_COOKIE['userid'])){
        header("Location:index.php");
        exit();
    }
    $pageIndex = 1;
    $pageSize = 20;
    if (isset($_GET['page'])) $pageIndex = intval($_GET['page']);
    if (isset($_GET['pageSize'])) $pageSize = intval($_GET['pageSize']);
    $uid = intval($_COOKIE['userid']);
    $uname = $_COOKIE['username'];
    include ("../../db/DB.Class.php");
    include ("../db/func.php");
    $db = new DB();
    if (!isset($_GET['lmark'])){
        getLmark($gid,$lmark,"队伍",$uid,$db);
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
        <script src="../js/team.js"></script>
    </head>
    <body style="width: 100%;">
        <div class="container-fluid">
        <div class="col-xs-6">
         <div id="toolbar">
             <?php
                 if ($isd) echo "<button class='btn btn-default' onclick='btnClick(4,-1)'>删除选中</button>";
                 if ($isa) echo "<button class='btn btn-default' onclick='btnClick(1,-1)'>添加</button>";
                 showReload();
             ?>
         </div>
         <div id="lists" class="metro">
            <table class="table striped hovered dataTable" id="datatable">
                <thead>
                <tr><th><button class="button" onclick="selectAll()">全选/反选</button></th><th>名称</th><th>创建时间</th><th>待定</th><th>操作</th></tr>
                </thead>
                <tbody>
                <?php
                    $res = $db->dql('select * from team');
                    if ($res && $res->num_rows > 0){
                        while ($row = $res->fetch_assoc()){
                            echo sprintf("<tr><td><input type='checkbox' class='cbox' data-uid='%s' /></td><td>%s</td><td>%s</td><td>%s</td>",$row['tid'],$row['name'],$row['create_time'],'P');
                            echo "<td>";
                            $id = $row['tid'];
                            if ($isd) echo "<button class='primary' onclick='btnClick(2,$id)'>删除</button>";
                            if ($ism) echo "<button class='warning' onclick='btnClick(3,$id,this)'>修改</button><button class='success' onclick='users($id)'>成员</button>";
                            echo "</td></tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
         </div>
         </div>
         <div class="col-xs-6">
                <table id="users" class="table table-striped table-hover">
                </table>
         </div>

         </div>
         <?php
             delModel();
             tipModel();
             addModel(['name'=>'名称']);
         ?>
    </body>
</html>
