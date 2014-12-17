<?php
	include ('../db/func.php');
	include ('../../conf.php');
	$str = '';
	$err = '';
	if (isset($_GET['pid']) && isset($_GET['name'])){
		$pid = $_GET['pid'];
		$name = $_GET['name'];
		$path = DATA_PATH . '/' . $pid . '/' . $name;
		if (file_exists($path)){
			$str = file_get_contents($path);
		} else {
			$err = "File Not Exists.";
		}
	} else if (isset($_POST['path']) && isset($_POST['data'])){
		$path = $_POST['path'];
		$data = $_POST['data'];
		if (file_exists($path)){
			file_put_contents($path, $data);
			$str = file_get_contents($path);
			$err = "Update success.";
		} else {
			$err = "File Not Exists.";
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
	<form action="case.php" method="post">
			<input type="hidden" name="path" value="<?php echo $path; ?>" />
			<label><?php echo $err; ?></label>
			<div class="input-control textarea">
				<label for="in">Data:</label>
				<textarea name="data"><?php echo $str; ?></textarea>
			</div>
			<div class="place-right">
				<button type="submit" class="primary">Submit</button>
			</div>
		</form>
</body>
</html>