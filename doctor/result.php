<?php
	session_start();
	
	$result = $_SESSION['result'];
	$button_label = "";
	
	$title = "";
	$link = "";
	
	if(strcmp($result,'chat') == 0)
	{
		$title = "All patient chat deleted successfully..";
		$button_label  ="Back to menu";
		$link = "chat.php";
		
	}else if(strcmp($result,'delete') == 0)
	{
	    $title = "All patient details deleted successfully..";
		$button_label  ="Back to menu";
		$link = "viewall.php";
	
	}else if(strcmp($result,'register') == 0)
	{
	
	}
	
	else if(isset($_POST['click'])){
		header('location: index.php');
	}
	
 ?>


<!doctype html>

<html>

<head>
	<title>Result</title>
	<meta name="viewport" content="width, initial-scale=1.0"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="css/result.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<style type="text/css">
	

	
	</style>
</head>

<body>


<h1> <?php echo $title; ?></h1>
<div class="box">
	<a class="button" name="click" href="<?php echo $link;?>"><?php echo $button_label;?></a>
</div>

<div id="popup1" class="overlay">
	<div class="popup">
		<h2>Here i am</h2>
		<a class="close" href="#">&times;</a>
		<div class="content">
			Thank to pop me out of that button, but now i'm done so you can close this window.
		</div>
	</div>
</div>

</body>

</html>