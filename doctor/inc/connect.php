<?php
/*--------------------------------------------------------------------------------------------
|    @desc:        connect.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/	
	$database_name = "doctordbase";
	$username ="root";
	$password = "213108190";
	$server_loc = "localhost";
	
	$conn = mysqli_connect($server_loc, $username, $password, $database_name);

?>