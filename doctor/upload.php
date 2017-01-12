
<?php
/*--------------------------------------------------------------------------------------------
|    @desc:         upload.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/


	if(isset($_POST['message']) && isset($_POST['patient_id']) && isset($_POST['doctor_code']))
	{
		include_once 'inc/db_connect.php';
		
		// connecting to database
        $db = new DB_Connect();
        $db->connect();
		
		$message = $_POST['message'];
		$image = $_POST['image'];
		$patient_id = $_POST['patient_id'];
		$doctor_code = $_POST['doctor_code'];
		$date = date("d-F-Y");
		$unread = "unread";
		
		if(empty($image))
		{
			$sql = "INSERT INTO message(from_id, to_id, message, date)
         			VALUES('$patient_id', '$doctor_code', '$message', '$date')";
					
			$result = mysql_query($sql);
			if($result)
			{
				mysql_query("INSERT INTO tblstatus(status, doctor_id, patient_id) 
				            VALUES('$unread', '$doctor_code', '$patient_id')");
							
				echo "Message sent";
				exit;
			}else{
				echo "Error occured";
				exit;
			}
		}else{
			
			$sql = "INSERT INTO message(from_id, to_id, message,, date, image)
         			VALUES('$patient_id', '$doctor_code', '$message', '$date', '$image')";
					
			$result = mysql_query($sql);
			if($result)
			{
				mysql_query("INSERT INTO tblstatus(status, doctor_id, patient_id) 
				           VALUES('$unread', '$doctor_code', '$patient_id')");
				echo "Message sent";
				exit;
			}else{
				echo "Error occured";
				exit;
			}
			
		}
		$db->close();
		
	}else{
		
		header("location: 404.php");
		exit;
	}
?>