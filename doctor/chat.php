<?php
/*--------------------------------------------------------------------------------------------
|    @desc:        chat chat.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/
  session_start();
	
	
if(!empty($_SESSION['patient_inbox']))
{
	//initialize the database object
	require "inc/connect.php";
		
try{
	
include_once ('inc/paginate.php'); //include of paginat page
include_once 'inc/db_connect.php';
include_once 'class/respond.class.php';
include_once 'class/Patient.class.php';
include_once 'class/Message.class.php';
include_once 'inc/Doctor_Operations.php';

// connecting to database
$db = new DB_Connect();
$db->connect();

$doc_functions = new Doctor_Operations();
				
$patient_msg = new Message_Handler();
$patient;
$respond_rows = "";
$message_rows = "";
				
$id = str_replace(' ', '',$_SESSION['patient_id']);
				
				
				
if($result = $patient_msg->getPatient($id))
{
	$rows = mysql_fetch_assoc($result);
					
	$patient = new Patient($rows['name'], $rows['surname'], $rows['email'], $rows['id_number'], 
	 $rows['phone'], $rows['gender'], $rows['fk_doctor_code'], $rows['person_id']);
					
	$feedback = $doc_functions->updateMessage($patient->getIdNumber());
	$name = $patient->getName();
	$surname = $patient->getSurname();
						
						
}else{
	echo "Failed to connect to Server...";
	exit;
}

$per_page = 5;         // number of results to show per page
$result = $patient_msg->getAllMessages($patient->get_idNumber(), $patient->getFk_doctor_code());
$total_results = mysql_num_rows($result);
$total_pages = ceil($total_results / $per_page);//total pages we going to have

//-------------if page is setcheck------------------//
if (isset($_GET['page'])) {
    $show_page = $_GET['page'];             //it will telles the current page
    if ($show_page > 0 && $show_page <= $total_pages) {
        $start = ($show_page - 1) * $per_page;
        $end = $start + $per_page;
    } else {
        // error - show first set of results
        $start = 0;              
        $end = $per_page;
    }
} else {
    // if page isn't set, show first set of results
    $start = 0;
    $end = $per_page;
}
// display pagination
$page = intval($_GET['page']);

$tpages=$total_pages;
if ($page <= 0)
    $page = 1;


   //doctor id and patient id
  $patient_idNo = $patient->getIdNumber();
  $doctor_code = $patient->getFk_doctor_code();	
			
//when send button is clicked
if(isset($_POST['submit']))
{
	$text = $_POST['respond'];

	if(!empty($text))
	{
						
		$feedback = $patient_msg->sendMessage($text, $patient_idNo);
						
		if(strcasecmp($feedback, "1")==0)
		{
			$msg_feedback = $patient_msg->saveMessage($text, $patient_idNo, $doctor_code);
			
		}else{
			$msg_feedback = "An error occured, Message not send";
		}
						
	}else{exit;}
					
}else if(isset($_POST['deletePatientChat']))//when delete chat button is clicked
{
	$msg_feedback = $patient_msg->deleteChat($patient_idNo, $doctor_code);
	$_SESSION['result'] = "chat"; 
	header('location: result.php');
}	
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatting</title>
    <link rel="stylesheet" type="text/css" href="css/chat/style.css" />
	<link href="css/doc_style/bootstrap.css" rel="stylesheet">
    <style type="text/css">
	.logo
	{
		text-align: center;
	}
	.container{

	}
	
	input[type=submit]{
	
	border: none;
	width:250px;
	color:white;
	height: 36px;
	background : #2bc1f2;
	}
	.buttons{
		background : #2bc1f2;
		height:23px;
		width:250px;
		margin-top:-15px;
	}
	
	textarea {
	padding :6px;
	font-size :15px;
	border-radius : 2px;
	border : 3px solid #98d0f1;
	margin-top :10px;
	height : 80px;
	width :96%;
	}img{
		height:8%;
	}#icons{
		margin:auto;
		width:160px;
		padding-bottom:35px;
		padding-top:20px;
	}
	#photo{
		height:8%;
		width:25%;
	}#delete{
		
		background:#a9a9a9;
		width:25%;
		height:30px;
	}
</style>
<script src="js/validate.js"></script>
<script type="text/javascripts">
function deleting()
{
	alert("Are you sure to delete all message(You cant undo this)?");
}

</script>
</head>
<body>
	
	<nav class="navbar navbar-default">
		<div>
			<ul class="nav navbar-nav pull-right">
				<li><a href="viewall.php">Back</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
		
	</nav>
	<br/>
    <div class="container" >
        <div class="row">

        <div class="row">
            <div class="span6 offset3">
				<form action="chat.php" method="POST" onsubmit="return validateChat()">
                <div class="mini-layout">
                 <?php
				 
                    $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
                    echo '<div class="pagination"><ul>';
                    if ($total_pages > 1) {
                        echo paginate($reload, $show_page, $total_pages);
                    }
                    echo "</ul></div>";
                    // display data in table
                    echo "<table class='table table-bordered'>";
                    echo "<thead><tr><th>Messages With ($surname $name)</th></tr></thead>";
                    // loop through results of database query, displaying them in the table 
                    for ($i = $start; $i < $end; $i++) {
                        // make sure that PHP doesn't try to show results that don't exist
                        if ($i == $total_results) {
                            break;
                        }
                      
                        // echo out the contents of each row into a table
                        echo "<tr " . $cls . ">";
                        echo '<td>' . mysql_result($result, $i, 'message') . '</td>';
						if(mysql_result($result, $i, 'image') != "")
						{
							$img = "image/logos.jpg";
							$imgbinary = fread(fopen($img, "r"), filesize($img));
							$img_str = base64_encode($imgbinary);
							//echo '<img id="photo" src="data:image/jpg;base64,'.$img_str.'"/>';
							
						}
						
                        echo "</tr>";
                    }       
					?>
					<tfoot>
					<tr>
						<td>
							<textarea col="40" width="500px" name="respond" id="message" placeholder="Type message here"></textarea>
							<p style="font-size:11px; color:#2bc1f2;"><?php echo $msg_feedback; ?></p>
							<p>
								<input type="submit" id="send" name="submit" value="Send" />
								
							</p>
				</form>		
					
					<form action="chat.php" method="post" onsubmit="return deleteChat()">
							<p><input type="submit" id="delete"  name="deletePatientChat"  value="Delete chat" /></p>
					</form>		
						</td>
					</tr>
				</tfoot>
				<?php
                    // close table>
                echo "</table>";
            // pagination
            ?>
			
            </div>
        </div>
    </div>
		<footer id="foote">
			
         <p id="copy"style="font-family: Helvetica Neue; margin-top:10px;text-align:center;, Helvetica, sans-serif; font-size: 11px; ">Copyright © 2016 - Hibro-Tech</p>
      </footer>
</div>
</body>
</html>
<?php

}catch(Exception $ex)
{
	/* If something goes wrong we catch the exception thrown by the object, print the message, and stop the execution of script */
	print 'Error! <br />' . $ex->getMessage() . '<br />';
	exit;
}

}else
{
	header("location: index.php");
}
?>



