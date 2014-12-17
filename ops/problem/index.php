<?php
    if (!isset($_COOKIE['userid'])){
        header("Location:../../index.php");
        exit();
    }
    $uid = intval($_COOKIE['userid']);
    $uname = $_COOKIE['username'];
    include ("../../db/DB.Class.php");
    include ("../db/func.php");
    $db = new DB();
    if (!isset($_GET['lmark'])){
        getLmark($gid,$lmark,"题目",$uid,$db);
        
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
        <?php  getAllStyle(); ?>
        <script src="../js/problem.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div id="toolbar" class="row">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <span class="navbar-brand">Tools</span>
                    </div>
             <?php
                 if ($isd) echo "<button class='btn btn-default navbar-btn' onclick='btnClick(4,-1)'>删除选中</button>";
                 if ($isa) echo "<a class='btn btn-default navbar-btn' href='add.php'>添加</a>";
                 showReload();
             ?>
                    <a class="btn btn-default navbar-btn" href="rejudge.php">Rejudge</a>
                 </nav>
            </div>
            <div id="lists" class="row metro" style="width: 100%;">
                <table class="table striped hovered dataTable" id="datatable">
                    <thead>
                        <tr><th><button onclick="selectAll()">全选/反选</button></th><th>编号</th><th>名称</th><th>描述</th><th>来源</th><th>作者</th><th>通过次数</th><th>提交人数</th><th>解决人数</th><th>操作</th></tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql = "select * from problem";
                        $res = $db->dql($sql);
                        if ($res && $res->num_rows > 0){
                               while ($row = $res->fetch_assoc()){
                                    echo "<tr><td><input type='checkbox' class='cbox' data-pid='" . $row['pid'] . "' /></td>";
                                    echo "<td>" . $row['pid'] . "</td>";
                                    echo "<td>" . $row['pname'] . "</td>";
                                    echo "<td>" . $row['desci'] . "</td>";
                                    echo "<td>" . $row['source'] . "</td>";
                                    echo "<td>" . $row['author'] . "</td>";
                                    echo "<td>" . $row['accepted'] . "</td>";
                                    echo "<td>" . $row['submit'] . "</td>";
                                    echo "<td>" . $row['solved'] . "</td>";
                                    echo "<td>";
                                    $id = $row['pid'];
                                    if ($isd) echo "<button class='primary' onclick='btnClick(2,$id)'>删除</button>";
                                    if ($ism) echo "<a class='button warning' href='add.php?pid=$id'>修改</a>";
                                    echo "<a class='button success' href='data.php?pid=$id'>配置数据</a>";
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
