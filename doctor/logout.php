<?php
	/*--------------------------------------------------------------------------------------------
|    @desc:        logout.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/
	session_start();
	session_destroy();
	unset($_SESSION['logged']);
	unset($_SESSION['doctor']);
	unset($_SESSION['id']);
	header("location: index.php");

?>