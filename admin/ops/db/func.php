<?php
    function getNormalAttr(&$a,&$d,&$m,$lmark,$db){
        $d = 0;
        $m = 0;
        $a = 0;
        $sql = ("select * from alevel where name like '%删除%' and alid in ($lmark)");
        $res = $db->dql($sql);
        if ($res && $res->num_rows > 0) $d = 1;
        $sql = ("select * from alevel where name like '%修改%' and alid in ($lmark)");
        $res = $db->dql($sql);
        if ($res && $res->num_rows > 0) $m = 1;
        $sql = ("select * from alevel where name like '%添加%' and alid in ($lmark)");
        $res = $db->dql($sql);
        if ($res && $res->num_rows > 0) $a = 1;
    }
    
    function getLmark(&$gid,&$lmark,$lname,$uid,$db){
        $sql = "select * from level where name = '$lname'";
        $res = $db->dql($sql);
        if ($res && $res->num_rows > 0){
            $row = $res->fetch_assoc();
            $lid = $row['lid'];
            $sql = "select * from admin_user where uid = " . $uid;
            $res = $db->dql($sql);
            if ($res && $res->num_rows > 0){
                $row = $res->fetch_assoc();
                $gid = $row['gid'];
                $sql = "select * from admin_grooup_level where gid = " . $gid . " and lid = " . $lid;
                $res2 = $db->dql($sql);
                if ($res2 && $res2->num_rows > 0){
                    $row2 = $res2->fetch_assoc();
                    $lmark = $row2['levelmark'];
                }
            }
        }
    }

    function getDir($path = null){
        if ($path != null){
            
        }
    }

    function pagination($field,$table,$where,$orderby,$pageIndex,$pageSize,$sumField,&$totalCount,&$pageCount,&$sumResult,$db){
        $sql = "call Pagination('$field','$table','$where','$orderby',$pageIndex,$pageSize,'$sumField',@total,@pages,@sums)";
        $res = $db->dql($sql);
        $sql = "select @total,@pages,@sums";
        $res2 = $db->dql($sql);
        if ($res2 && $res2->num_rows > 0){
            $row = $res2->fetch_assoc();
            $totalCount = $row['@total'];
            $pageCount = $row['@pages'];
            $sumResult = $row['@sums'];
        }
        return $res;
    }

    function showReload($class = 'btn btn-default navbar-btn'){
        echo "<button class='$class' onclick='javascript:location.reload(true);' >刷新</button>";
    }

    function getStyle(){
        $link = [
            "<link rel='stylesheet' href='../../css/bootstrap.min.css' />",
            "<script src='../../js/jquery.min.js'></script>",
            "<script src='../../js/bootstrap.min.js'></script>",
            ];
        foreach ($link as $stylelink){
            echo $stylelink;
        }
    }

    function getDataTable(){
        $link = [
            "<script src='../../js/dataTables.min.js'></script>"
        ];
        foreach ($link as $l){
            echo $l;
        }
    }

    function getAllStyle(){
        $link = [
            "<link rel='stylesheet' href='../../css/bootstrap.min.css' />",
            "<link rel='stylesheet' href='../../css/metro-bootstrap.min.css' />",
            "<script src='../../js/jquery.min.js'></script>",
            "<script src='../../js/jquery.ui.min.js'></script>",
            "<script src='../../js/metro.min.js'></script>",
            "<script src='../../js/bootstrap.min.js'></script>",
            "<script src='../../js/dataTables.min.js'></script>"
        ];
        foreach ($link as $l){
            echo $l;
        }
    }

    function getMetroStyle(){
        $link = [
            "<link rel='stylesheet' href='../../css/metro-bootstrap.min.css' />",
            "<script src='../../js/jquery.min.js'></script>",
            "<script src='../../js/jquery.ui.min.js'></script>",
            "<script src='../../js/metro.min.js'></script>"
            ];
        foreach ($link as $stylelink){
            echo $stylelink;
        }
    }

    function addModel($arr,$id='addModel',$tip = "checkTips",$in = FALSE){
        echo sprintf('<div id="%s" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">',$id);
        echo '<div class="modal-dialog modal-lg">';
        echo '<div class="modal-content">';
        echo '<div class="form-group"></div>';
        if ($in) echo '<form role="form">';
        else echo '<form class="form-horizontal" role="form">';
        foreach ($arr as $k=>$v){
            echo sprintf('<div class="form-group"><label for="%s" class="col-xs-2 control-label">%s</label><div class="col-xs-8"><input type="text" class="form-control" id="%s" placeholder="%s" /></div></div>',$k,$v,$k,$k);
        }
        echo sprintf('<div class="form-group"><div class="col-xs-offset-2 col-xs-8"><span id="%s"></span></div></div>',$tip);
        echo sprintf('<div class="form-group"><div class="col-xs-offset-2 col-xs-8"><div class="col-xs-4"><button type="submit" class="btn btn-primary">确定</button></div><div class="col-xs-4"><button onclick="javascript:$(\'#%s\').modal(\'hide\');" type="button" class="btn btn-default">取消</button></div></div></div>',$id);
    }

    function tipModel($id='tipModel'){
        echo sprintf('<div id="%s" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <span id="tipTxt"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>',$id);
    }

    function delModel($id = 'delModel'){
        echo sprintf('<div id="%s" data-lid="-1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form class="form-horizontal" role="form">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <span>W: 确定删除?</span>
                                    <button type="submit" class="btn btn-primary">确定</button>
                                    <button onclick="javascript:$(\'#%s\').modal(\'hide\');" type="button" class="btn btn-default">取消</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
              </div>',$id,$id);
    }
?>