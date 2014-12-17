<?php
    if (!isset($_GET['cid'])){
        echo "Error";
        exit;
    }
    $cid = $_GET['cid'];
    include ("../../db/DB.Class.php");
    include ("../db/func.php");
    
    $db = new DB();
    $sql = "select * from contest where cid = $cid";
    $res = $db->dql($sql);
    if ($res && $res->num_rows < 1) {
        echo "Error";
        exit;
    }
    $row = $res->fetch_assoc();
    $type = intval($row['type']) == 0 ? 'contest_user' : 'contest_team';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <?php getMetroStyle(); ?>
    <script src="modify.js"></script>
</head>
<body class="metro">
    <div style="width: 100%;" class="grid">
        <div class="tab-control" data-role="tab-control">
            <ul class="tabs">
                <li class="active"><a href="#tab_1">参赛人员</a></li>
                <li><a href="#tab_2">比赛题目</a></li>
                <li><a href="#tab_3">比赛新闻</a></li>
            </ul>
            <div class="frames">
                <div class="frame" id="tab_1">
                <div class="row">
                    <?php 
                        echo "<button onclick='addUser($cid)'>添加</button>";
                        showReload('info');
                    ?>
                </div>
                <div class="row">
                    <table class="table striped">
                        <thead>
                            <tr><td>编号</td><td>操作</td></tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "select * from $type where cid = $cid";
                                $res = $db->dql($sql);
                                if ($res && $res->num_rows > 0){
                                    if ($type == 'contest_user'){
                                        while ($row = $res->fetch_assoc()){
                                            echo "<tr><td>" . $row['uid'] . "</td>";
                                            echo "<td>";
                                            echo sprintf("<button onclick='delUser(%d,%d)'>删除</button>",$row['uid'],$cid);
                                            if (intval($row['ischeck']) == 0) echo sprintf("<button class='success' onclick='checkUser(%d,%d)'>审核</button>",$row['uid'],$cid);
                                            echo "</td></tr>";
                                        }
                                    } else {
                                        while ($row = $res->fetch_assoc()){
                                            echo "<tr><td>" . $row['tid'] . "</td>";
                                            echo "<td>";
                                            echo sprintf("<button onclick='delUser(%d,%d)'>删除</button>",$row['tid'],$cid);
                                            if (intval($row['ischeck']) == 0) echo sprintf("<button class='success' onclick='checkUser(%d,%d)'>审核</button>",$row['tid'],$cid);
                                            echo "</td></tr>";
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <div class="frame" id="tab_2">
                <div class="row">
                   <?php
                       echo "<button onclick='addProblem($cid)'>添加</button>";
                       showReload('info');
                   ?> 
                </div>
                <div class="row">
                    <table class="table striped">
                        <thead>
                            <tr><td>编号</td><td>重定义编号</td><td>重定义名称</td><td>操作</td></tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "select * from contest_problem where cid = $cid";
                                $res = $db->dql($sql);
                                if ($res && $res->num_rows > 0){
                                    while ($row = $res->fetch_assoc()){
                                            echo "<tr><td>" . $row['pid'] . "</td>";
                                            echo "<td>" . $row['newid'] . "</td>";
                                            echo "<td>" . $row['newname'] . "</td>";
                                            echo "<td>";
                                            echo sprintf("<button onclick='delProblem(%d,%d)'>删除</button>",$row['pid'],$cid);
                                            echo "</td></tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <div class="frame" id="tab_3">
                    <div class="tab-control" data-role="tab-control">
                        <ul class="tabs">
                            <li class="active"><a href="#tab_3_1">查看</a></li>
                            <li><a href="#tab_3_2">添加新闻</a></li>
                        </ul>
                    <div class="frames">
                        <div class="frame" id="tab_3_1">
                    <div class="row">
                       <?php
                           showReload('info');
                       ?>
                    </div>
                    <div class="row">
                        <table class="table striped">
                            <thead>
                                <tr><td>编号</td><td>创建者</td><td>标题</td><td>创建时间</td><td>操作</td></tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "select * from news where cid = $cid";
                                    $res = $db->dql($sql);
                                    if ($res && $res->num_rows > 0){
                                        while ($row = $res->fetch_assoc()){
                                                echo "<tr><td>" . $row['cnid'] . "</td>";
                                                echo "<td>" . $row['uid'] . "</td>";
                                                echo "<td>" . $row['title'] . "</td>";
                                                echo "<td>" . $row['create_time'] . "</td>";
                                                echo "<td>";
                                                echo sprintf("<button onclick='delNews(%d,%d)'>删除</button>",$row['cnid'],$cid);
                                                echo "</td></tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="frame" id="tab_3_2">
                        <form>
                            <label>标题：</label>
                            <div class="input-control text">
                                <input type="text" id="title" />
                                <span class="btn-clear"></span>
                            </div>
                            <label>正文：</label>
                            <div class="input-control textarea">
                                <textarea id="context"></textarea>
                            </div>
                            <?php echo "<input type='hidden' value='$cid' id='fcid' />" ?>
                            <div class="place-left">
                            <button type="submit" class="primary">提交</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>