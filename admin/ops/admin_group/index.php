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
    $lmark = $_GET['lmark'];
    if (!isset($_GET['lmark'])){
        getLmark($gid,$lmark,"管理员用户组",$uid,$db);
    }
    getNormalAttr($isa,$isd,$ism,$lmark,$db);

    $arr = [
        "name"=>"名称",
        "desci"=>"描述"
    ];
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <?php getStyle(); ?>
        <script src="../js/admin_group.js"></script>
    </head>
    <body style="width: 100%;">
        <div class="container-fluid">
            <div class="col-xs-6">
                <div id="toolbar" class="col-xs-offset-1 col-xs-11">
                    <?php
                        if ($isa) echo "<button type='button' class='btn btn-default' onclick='btnClick(1,-1)'>添加</button>";
                        showReload();
                    ?>
                </div>
                <div id="list">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr><th>名称</th><th>描述</th><th>操作</th></tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "select * from admin_group";
                            $res = $db->dql($sql);
                            if ($res && $res->num_rows > 0){
                                while ($row = $res->fetch_assoc()){
                                    echo sprintf("<tr><td>%s</td><td>%s</td>",$row['name'],$row['desci']);
                                    echo "<td>";
                                    if ($ism) echo sprintf("<button type='button' class='btn btn-default' onclick='btnClick(3,%d,this)' >修改</button>",$row['gid']);
                                    if ($isd) echo sprintf("<button type='button' class='btn btn-default' onclick='btnClick(2,%d,this)' >删除</button>",$row['gid']);
                                    if ($ism) echo sprintf("<button type='button' class='btn btn-default' onclick='getLevel(%d)'>配置权限</button>",$row['gid']);
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-6">
                <div>
                    <span>权限配置</span>
                    
                </div>
                <div id="predom">
                    
                </div>
            </div>
        </div>
        <?php delModel(); tipModel(); ?>

        <?php addModel($arr); ?>

    </body>
</html>
