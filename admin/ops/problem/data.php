<?php
	include ('../db/func.php');
	include ('../../conf.php');
	$msg = '';
	$cnt = 0;
	if (isset($_GET['path'])){
		$path = $_GET['path'];
		if (file_exists($path)){
			unlink($path);
			$msg = "Delete success.";
		} else {
			$msg = "File Not Exists.";
			exit();
		}
	}
	if (isset($_GET['pid'])){
	
		$pid = $_GET['pid'];
		$path = DATA_PATH . '/' . $pid;
		if (!is_dir($path)){
			if (mkdir($path)) $msg = "File Not Exists,Create New.";
			else {$msg = "Create Failed.";exit();}
			@chmod($path,0777);
		}
	}
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<?php getMetroStyle(); ?>
</head>
<body class="metro">
	<div id="main">
		<nav class="navigation-bar">
			<nav class="navigation-bar-content">
				<div class="element">
					<p>Tools</p>
				</div>
				<span class="element-divider"></span>/
				<a class="element brand" href='addData.php?pid=<?php echo $pid; ?>'>添加</a>
			</nav>
		</nav>
		<div><?php echo $msg; ?></div>
		<table class='table'>
			<tbody>
				<?php
					$dir = opendir($path);
					while (($file = readdir($dir)) !== FALSE){
						$sub_path = $path . '/' . $file;
				        if ($file == '.' || $file == '..'){
						    continue;
						} else if (is_dir($sub_path)) {

						} else {
						    echo "<tr>";
						    echo "<td><a class='button primary' href='case.php?pid=$pid&name=$file'>" . $file . "</a></td>";
						    echo "<td>" . filesize($sub_path) . "&nbsp;Bytes</td>";
						    echo "<td><a class='button warning' href='data.php?pid=$pid&path=$sub_path'>删除</a></td>";
						    echo "</tr>";
						}
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>
