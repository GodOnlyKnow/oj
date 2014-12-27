<?php
    include ("../../db/DB.Class.php");
    $db = new DB();
    if (isset($_GET['pid'])){
        $sql = "update solution set status = 1 where pid = " . $_GET['pid'];
        $db->dml($sql);
    } else if (isset($_GET['sid']) && isset($_GET['eid'])){
        $s = intval($_GET['sid']);
        $e = intval($_GET['eid']);
        $sql = "update solution set status = 1 where sid >= $s and sid <= $e"
        $db->dml($sql);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="../../css/metro-bootstrap.min.css" />
        <link rel="stylesheet" href="../../css/iconFont.min.css" />
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/jquery.ui.min.js"></script>
        <script src="../../js/metro.min.js"></script>
    </head>
    <body class="metro">
        <div class="tab-control" data-role="tab-control">
            <ul class="tabs">
                <li class="active"><a href="#tab_1">根据题目ID</a></li>
                <li><a href="#tab_2">根据提交记录</a></li>
            </ul>

            <div class="frames">
                <div class="frame" id="tab_1">
                    <form method="get">
                    <div class="input-control text">
                        <input type="number" name="pid" placeholder="输入题目ID" />    
                    </div>
                    <div>
                        <button type="submit" class="primary">确定</button>
                    </div>
                    </form>
                </div>
                <div class="frame" id="tab_2">
                    <form method="get">
                    <div class="input-control text">
                            <input type="number" name="sid" placeholder="输入起始ID" />
                    </div>
                    <div class="input-control text">
                            <input type="number" name="eid" placeholder="输入结束ID" />
                    </div>
                    <button type="submit" class="primary">确定</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
