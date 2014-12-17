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
        getLmark($gid,$lmark,"管理员",$uid,$db);
    } else {
        $lmark = $_GET['lmark'];
    }
    getNormalAttr($isa,$isd,$ism,$lmark,$db);

    $arr = [
        "name"=>"名称",
        "desci"=>"描述"
    ];

    $adminGroup = array();
    $sql = "select * from admin_group";
    $res = $db->dql($sql);
    if ($res && $res->num_rows > 0){
        while ($row = $res->fetch_assoc()){
            $adminGroup[intval($row['gid'])] = $row['name'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <?php getStyle(); ?>
        <script src="../js/admin_user.js"></script>
    </head>
    <body style="width: 100%;">
        <div class="container-fluid">
         <div id="toolbar" class="row">
             <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <span class="navbar-brand">Tools</span>
                    </div>
             <?php
                 if ($isd) echo "<button class='btn btn-default' onclick='btnClick(4,-1,this)'>删除选中</button>";
                 if ($isa) echo "<button class='btn btn-default' onclick='btnClick(1,-1)'>添加</button>";
                 showReload();
             ?>
                 </nav>
         </div>
         <div id="lists" class="row" style="width: 100%;">
            <table class="table table-striped table-hover">
                <tr><th><button class="btn btn-default" onclick="selectAll()">全选/反选</button></th><th>用户名</th><th>密码</th><th>真实姓名</th><th>邮箱</th><th>联系电话</th><th>所在组</th><th>操作</th></tr>
                <?php
                    $res = $db->dql('select * from admin_user');
                    if ($res && $res->num_rows > 0){
                        while ($row = $res->fetch_assoc()){
                            echo sprintf("<tr><td><input type='checkbox' class='cbox' data-uid='%s' /></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",
                                    $row['uid'],$row['username'],$row['psd'],$row['name'],$row['email'],$row['phone'],$adminGroup[intval($row['gid'])]);
                            echo "<td>";
                            $id = $row['uid'];
                            if ($isd) echo "<button class='btn btn-default' onclick='btnClick(2,$id)'>删除</button>";
                            if ($ism) echo "<button class='btn btn-default' onclick='btnClick(3,$id,this)'>修改</button>";
                            echo "</td></tr>";
                        }
                    }
                ?>
            </table>
         </div>
         </div>

         <?php
             delModel();
             tipModel();
             $arr = [
                'username'=>'用户名',
                'psd'=>'密码',
                'name'=>'真实姓名',
                'email'=>'邮箱',
                'phone'=>'联系电话'
             ];
             echo '<div id="addModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">';
             echo '<div class="modal-dialog modal-lg">';
             echo '<div class="modal-content">';
             echo '<div class="form-group"></div>';
             echo '<form class="form-horizontal" role="form">';
             foreach ($arr as $k=>$v){
                 echo sprintf('<div class="form-group"><label for="%s" class="col-xs-2 control-label">%s</label><div class="col-xs-8"><input type="text" class="form-control" id="%s" placeholder="%s" /></div></div>',$k,$v,$k,$k);
             }
             echo '<div class="form-group"><label for="gid" class="col-xs-2 control-label">所在组</label><div class="col-xs-8"><select class="form-control" id="gid">';
             foreach ($adminGroup as $gname){
                 echo "<option>$gname</option>";
             }
             
             echo '</select></div></div>';
             echo '<div class="form-group"><div class="col-xs-offset-2 col-xs-8"><span id="checkTips"></span></div></div>';
             echo '<div class="form-group"><div class="col-xs-offset-2 col-xs-8"><div class="col-xs-4"><button type="submit" class="btn btn-primary">确定</button></div><div class="col-xs-4"><button onclick="javascript:$(\'#addModel\').modal(\'hide\');" type="button" class="btn btn-default">取消</button></div></div></div>';
         ?>
    </body>
</html>
