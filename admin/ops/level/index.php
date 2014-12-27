<?php
    if (!isset($_COOKIE['userid'])){
        header("Location:index.php");
        exit();
    }
    if (!isset($_GET['lmark'])){
        echo "Error!";
        exit();
    }
    include("../../db/DB.Class.php");
    $uid = intval($_COOKIE['userid']);
    $lmark = $_GET['lmark'];
    $db = new DB();
    $mks = explode(',',$lmark);
    $isd = 0;
    $ism = 0;
    $isa = 0;
    $sql = ("select * from alevel where name like '%删除%' and alid in ($lmark)");
    $res = $db->dql($sql);
    if ($res && $res->num_rows > 0) $isd = 1;
    $sql = ("select * from alevel where name like '%修改%' and alid in ($lmark)");
    $res = $db->dql($sql);
    if ($res && $res->num_rows > 0) $ism = 1;
    $sql = ("select * from alevel where name like '%添加%' and alid in ($lmark)");
    $res = $db->dql($sql);
    if ($res && $res->num_rows > 0) $isa = 1;
    echo sprintf("<script>window.onload = function(){ setVar(%d,%d,%d); };</script>",$isd,$isa,$ism);
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
        <link rel="stylesheet" href="../../css/bootstrap.min.css" />
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../js/level.js"></script>
    </head>
    <body style="width: 100%;">
         <div id="lists" class="row" style="width: 100%;">
             <div class="col-xs-5">
                 <table class="table table-striped table-hover">
                     <tr><td colspan="2">
                     <?php
                         if ($isa) echo "<a class='btn btn-default' onclick='level(2,-1)' >添加</a>";
                         echo "<a class='btn btn-default' onclick='javascript:location.reload(true);' >刷新</a>";
                     ?>
                     </td></tr>
                     <tr><th>权限名称</th><th>操作</th></tr>
                     <?php
                         $sql = "select * from level";
                         $res = $db->dql($sql);
                         if ($res && $res->num_rows > 0){
                             while ($row = $res->fetch_assoc()){
                                 echo sprintf("<tr><td> <button id='lid%s' data-desci='%s' class='btn btn-default' onclick='getAlevel(\"%s\")'>%s</button></td>",$row['lid'],$row['desci'],$row['lid'],$row['name']);
                                 echo "<td>";
                                 if ($ism) echo sprintf("<a class='btn btn-default' onclick='level(0,%d)' >修改</a>",$row['lid']);
                                 if ($isd) echo sprintf("<a class='btn btn-default' onclick='level(1,%d)'>删除</a>",$row['lid']);
                                 echo "</td></tr>";
                             }
                         }
                     ?>
                </table>
            </div>
            <div class="col-xs-7">
                <table id="secMenu" class="table table-striped table-hover">
                
                </table>
            </div>
         </div>

        <!-- Tips -->
        <div id="tipModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <span id="tipTxt"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete -->
        <div id="delModel" data-lid="-1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form class="form-horizontal" role="form">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <span>W: 确定删除?</span>
                                <button id="delModelOk" type="submit" class="btn btn-primary">确定</button>
                                <button id="delModelCanel" onclick="javascript:$('#delModel').modal('hide');" type="button" class="btn btn-default">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--All Delete -->
        <div id="delAModel" data-lid="-1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form class="form-horizontal" role="form">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <span>W: 确定删除?</span>
                                <button type="submit" class="btn btn-primary">确定</button>
                                <button onclick="javascript:$('#delModel').modal('hide');" type="button" class="btn btn-default">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--add div-->
        <div id="addModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="form-group"></div>
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="inputName" class="col-xs-2 control-label">权限名称</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="inputName" placeholder="Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDesci" class="col-xs-2 control-label">所属目录</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="inputDesci" placeholder="Path" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-8">
                                <span id="checkTips"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-8">
                                <div class="col-xs-4">
                                    <button id="addModelOk" type="submit" class="btn btn-primary">确定</button>
                                </div>
                                <div class="col-xs-4">
                                    <button id="addModelCanel" onclick="javascript:$('#addModel').modal('hide');" type="button" class="btn btn-default">取消</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            <!--add All Level-->
            <div id="addAModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="form-group"></div>
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="inputAName" class="col-xs-2 control-label">权限名称</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="inputAName" placeholder="Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputADesci" class="col-xs-2 control-label">详细描述</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="inputADesci" placeholder="Path" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-8">
                                <span id="checkATips"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-8">
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary">确定</button>
                                </div>
                                <div class="col-xs-4">
                                    <button onclick="javascript:$('#addAModel').modal('hide');" type="button" class="btn btn-default">取消</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </body>
</html>
