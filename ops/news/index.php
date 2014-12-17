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
        <script src="../js/news.js"></script>
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
                    <button class="btn btn-default navbar-btn navbar-left" onclick="IndexNews()">首页新闻</button>
                    <form class="navbar-form navbar-left" role="search">
                        <label>比赛新闻： </label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtSearch" placeholder="比赛编号" />
                        </div>
                    </form>
                 </nav>
            </div>
            <div id="lists" class="row metro" style="width: 100%;">
                <table class="table striped hovered dataTable" id="datatable">
                    <thead>
                        <tr><th><button onclick="selectAll()">全选/反选</button></th><th>编号</th><th>所属比赛</th><th>创建者</th><th>题目</th><th>创建时间</th><th>最后修改时间</th><th>操作</th></tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql = "select * from news";
                        $res = $db->dql($sql);
                        if ($res && $res->num_rows > 0){
                               while ($row = $res->fetch_assoc()){
                                    echo "<tr><td><input type='checkbox' class='cbox' data-cnid='" . $row['cnid'] . "' /></td>";
                                    echo "<td>" . $row['cnid'] . "</td>";
                                    echo "<td>" . $row['cid'] . "</td>";
                                    echo "<td>" . $row['uid'] . "</td>";
                                    echo "<td>" . $row['title'] . "</td>";
                                    echo "<td>" . $row['create_time'] . "</td>";
                                    echo "<td>" . $row['last_time'] . "</td>";
                                    echo "<td>";
                                    $id = $row['cnid'];
                                    if ($isd) echo "<button class='primary' onclick='btnClick(2,$id)'>删除</button>";
                                    if ($ism) echo "<a class='button warning' href='add.php?cnid=$id'>修改</a>";
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
