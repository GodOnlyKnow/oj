<?php
    
	include_once "db/DB.class.php";
	if (isset($_POST['uname'])){
	    $uname = $_POST['uname'];
        $psd = $_POST['psd'];
    } else if (isset($_GET['uname'])){
        $uname = $_GET['uname'];
        $psd = $_GET['psd'];
    } else {
        echo "Error";
        exit;
    }
    $db = new DB();
	$sql = sprintf("SELECT * FROM admin_user WHERE username = '%s'",$uname);
	$res = $db->dql($sql);
	try{
		if ($res && $res->num_rows > 0){
			$row = $res->fetch_assoc();
            if ($row && $row['psd'] == md5($psd)){
                $uid = $row['uid'];
			    $sql = sprintf("SELECT * FROM logininfo WHERE uid = %d ORDER BY create_time desc",$uid);
			    $res = $db->dql($sql);
			    if ($res && $res->num_rows > 0){
				    $row = $res->fetch_assoc();
				    echo "Last Login Time:<br />" . $row['create_time'];
			    } else { echo "First Login.";}
                $ip = $_SERVER["REMOTE_ADDR"];
                $sql = sprintf("INSERT INTO logininfo (uid,IPv4) VALUES(%d,'%s')",$uid,$ip);
                $db->dml($sql);
                setcookie("userid",$uid);
                setcookie("username",$uname);
            } else { echo "User or Password Error."; }
		} else { echo "Connect Error."; }
	}catch (Exception $e) { echo "-_-"; }
?>