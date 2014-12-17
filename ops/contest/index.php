<?php
    if (!isset($_COOKIE['userid'])){
        header("Location:../../index.php");
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
        getLmark($gid,$lmark,"比赛",$uid,$db);
        
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
        <script src="../js/contest.js"></script>
    </head>
    <body>
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
                        <tr><th><button class="btn btn-default" onclick="selectAll()">全选/反选</button></th><th>编号</th><th>创建者</th><th>名称</th><th>开始时间</th><th>结束时间</th><th>描述</th><th>是否私有</th><th>比赛类型</th><th>操作</th></tr>
                    </thead>
                    <tbody>
                    <?php
                        //$res = pagination('*','contest','1 = 1','cid',$pageIndex,$pageSize,'cid',$totalCount,$pageCount,$sumResult,$db);
                        $res = $db->dql('select * from contest');
                        if ($res && $res->num_rows > 0){
                               while ($row = $res->fetch_assoc()){
                                    echo "<tr><td><input type='checkbox' class='cbox' data-cid='" . $row['cid'] . "' /></td>";
                                    echo "<td>" . $row['cid'] . "</td>";
                                    echo "<td>" . $row['uid'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['start_time'] . "</td>";
                                    echo "<td>" . $row['end_time'] . "</td>";
                                    echo "<td>" . $row['desci'] . "</td>";
                                    echo "<td>" . $row['private'] . "</td>";
                                    echo "<td>" . $row['type'] . "</td>";
                                    echo "<td>";
                                    $id = $row['cid'];
                                    if ($isd) echo "<button class='primary' onclick='btnClick(2,$id)'>删除</button>";
                                    if ($ism) echo "<a class='button warning' href='add.php?cid=$id'>修改</a><a class='button success' href='modify.php?cid=$id'>配置比赛</a>";
                                    echo "</td></tr>";
                               }
                        }
                    ?>
                    </tbody>
                </table>
            </div>

            <?php
                delModel();
                tipModel();
            ?>
            
        </div>
    </body>
</html>
