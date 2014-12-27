<?php
    if (!isset($_COOKIE['userid'])){
        header("Location:index.html");
        exit();
    }
    $uid = intval($_COOKIE['userid']);
    $uname = $_COOKIE['username'];
    include("db/DB.Class.php");
    include ("conf.php");
	$icons = array('icon-flag','icon-user-3','icon-user','icon-file','icon-user-2','icon-layers','icon-star-2','icon-newspaper');
    $db = new DB();
    $sql = "select * from admin_user where uid = " . $uid;
    $res = $db->dql($sql);
    if ($res){
        $row = $res->fetch_assoc();
        $gid = $row['gid'];
        $sql = "select * from admin_group where gid = " . $gid;
        $res = $db->dql($sql);
        if ($res){
            $row = $res->fetch_assoc();
            $groupname = $row['name'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="css/metro-bootstrap.min.css" />
        <link rel="stylesheet" href="css/admin.css" />
        <link rel="stylesheet" href="css/iconFont.min.css" />
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.ui.min.js"></script>
        <script src="js/metro.min.js"></script>
    </head>
    <body class="metro">
        <div id="top">
            <nav class="navigation-bar">
                <nav class="navigation-bar-content">
                    <div class="element">
                        OJ
                    </div>
                    <span class="element-divider"></span>
                    <div data-hint="Sign Out" data-hint-position="left" class="element place-right">
                        <i class="icon-switch"></i>
                    </div>
                    <div class="element place-right">
                        <span><?php echo $uname ?></span>
                        [
                        <span><?php echo $groupname ?></span>
                        ]
                    </div>
                </nav>
            </nav>
        </div>
        <div id="main">
        <div id="left">
            
                <div class="listview-outlook">
                    <?php
                        $sql = "select * from admin_grooup_level where gid = " . $gid;
                        $res = $db->dql($sql);
                        if ($res){
                            if ($res->num_rows > 0){
								$cnt = 0;
                                while ($row = $res->fetch_assoc()){
                                    $lmark = $row['levelmark'];
									$cnt++;
                                    $sql2 = "select * from level where lid = " . $row['lid'];
                                    if (intval($row['lid']) == 1 && !IS_PREDOM) continue;
                                    $res2 = $db->dql($sql2);
                                    if ($res2){
                                        $row2 = $res2->fetch_assoc();
                                        echo "<a class='list'><div class='list-content' onclick='show(\"ops/". $row2['desci'] ."/index.php?lmark=$lmark\")'><i class='" . $icons[$cnt - 1] . "'><span>" . $row2['name'] . "</span></i></div></a>";
                                    }
                                }
                            }
                        }
                    ?>
                </div>
                
        </div>
        <div id="context">
        <iframe id="cframe" frameborder="0" width="100%" height="100%"></iframe>
        </div>
        </div>
        <div id="bottom" class="">Copyright 2014</div>
    </body>
</html>
<script>
    function show(url) {
        $("#cframe").attr("src",url);
    }
</script>
