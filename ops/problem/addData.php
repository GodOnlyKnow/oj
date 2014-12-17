<?php
	include ('../db/func.php');
	include ('../../conf.php');
	$msg = '';
	$pid = 0;
	if (isset($_GET['pid'])) $pid = $_GET['pid'];
	if (isset($_POST['pid'])){
		$pid = $_POST['pid'];
		$in = $_POST['in'];
		$out = $_POST['out'];
		$path = DATA_PATH . '/' . $pid;
		$scan = scandir($path);
		$cnt = count($scan) / 2;
		$i = $path . '/in' . $cnt . '.txt';
		file_put_contents($i, $in) or die("Error for Input file.") ;
		$o = $path . '/out' . $cnt . '.txt';
		file_put_contents($o, $out) or die("Error for Output file.");
		$msg = "Create success.";
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
	<div>
		<form action="addData.php" method="post">
			<input type="hidden" name="pid" value="<?php echo $pid; ?>" />
			<label><?php echo $msg; ?></label>
			<div class="input-control textarea">
				<label for="in">Input Data:</label>
				<textarea name="in"></textarea>
			</div>
			<div class="input-control textarea">
				<label for="out">Output Data:</label>
				<textarea name="out"></textarea>
			</div>
			<div class="place-right">
				<button type="submit" class="primary">Submit</button>
			</div>
		</form>
	</div>
</body>
</html>