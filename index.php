<?php
include('./config.php');
include('./inc/LogParser.class.php');
$results = array();
echo "<br/>";
?>

<!doctype html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
	<link rel="shortcut icon" href="" />
	<link rel="stylesheet" href="./css/style.css">
	<script src="./js/jquery-3.2.1.min.js"></script>
	<script src="./js/main.js"></script>
</head>

<body>
	<h2>Log File Viewer</h2>
	<span class="info">e.g. Type the path of the file under server log directory which is set as base path in config.php</span>
	<input placeholder="Type path/to/file here ..." id="filelocation" type="text">
	<button class="cta_btn" data-id="load" id="search">View</button>
	<div id="results">
		<?if($results){ include_once('./templates/PrintLogs.tpl.php'); }?>
	</div>
	<span id="err1" style="display:none" class="alert">**Please enter a valid file path!</span>
	<br/>
	<div id="btnnav">
		<a href="#" class="deselect cta_btn" data-id="begin">&laquo;&nbsp;Beginning</a>
		<a href="#" class="deselect cta_btn" data-id="next">Next&nbsp;&#8250;</a>
		<a href="#" class="deselect cta_btn" data-id="prev">&#8249;&nbsp;Prev</a>
		<a href="#" class="deselect cta_btn" data-id="end">End&nbsp;&raquo;</a>
	</div>
</body>
