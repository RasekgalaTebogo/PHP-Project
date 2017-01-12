<?php
/*--------------------------------------------------------------------------------------------
|    @desc:         viewall.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/
	session_start();//initialize the session

	//require_once './Doctor_Operations.php';
	
	//test if the session exist.
	if(!empty($_SESSION['logged_doctor']))
	{
		
		  try{
					//initialize the database object
					
					include_once 'inc/Doctor_Operations.php';
					include_once 'class/Patient.class.php';
					include_once 'class/Doctor.class.php';
					include_once 'inc/logon.php';
					include_once 'class/respond.class.php';
					
					$patient_function = new Message_Handler();
					
					$doc = new Process_Login();
					
					$tableContent = "";
					$status ="";
					$newsFeedback="";
					
					//declare variables
					$patient_no;
					$name;
					$surname;
					$cell;
					$email;
					$gender;
					$IDNo;
					$address;
					$street_name;
					$city;
					$tableContent;
					$delete_feedback = "";
					

					
				//generate doctor session
				$patient_num = 0;
				//get the doctor object
				$id = $_SESSION['doctor_code'];
		
				//unserialize doctor object from login
				$docorObj = unserialize($_SESSION['doctor']);
				$doc_code = $docorObj->getDoctor_code();// get doctor code
				$doc_functions = new Doctor_Operations();
				
					//declaring doctor variables for fields
					$doc_id = $docorObj->getPerson_id();
					$docName = $docorObj->getName();
					$docSurname = $docorObj->getSurname();
					$docCell = $docorObj->getPhone();
					$docEmail = $docorObj->getEmail();
					$docGender = $docorObj->getGender();
					$docIDNo = $docorObj->getIdNumber();
					$specialty = $docorObj->getSpecialty();
					
					//get doctor address
					$docAddress = $doc_functions->getAddress($doc_id);
					$address_results = mysql_fetch_assoc($docAddress);
					$doc_street_name = $address_results['street_name'];
					$doc_city = $address_results['city'];
					$postal = $address_results['postal_code'];
					
				$doctor = $doc_functions->getDoctor($id);
				$doc_results = mysql_fetch_assoc($doctor);
			
				
				//get number of messages that doctor have
				$msg_number = $doc_functions->getAllDocMessages($doc_code);
				
				if($msg_number > 0)
				{
					//if messages exists then create a div to display on the page
					$status = "<div class='well well-sm' style='text-align:center; color:green;'>You have $msg_number new Message(s)</div>";
				}
				
				//initialize the header for the page tha tell if doctor have registered patient or not
				$head ="<div class='well well-sm'><p style='color:red;'>No Registered Patient</p></div>";	
				 	
					
				if($results = $doc_functions->getAllPatients($doc_code))
				{
					if(mysql_num_rows($results) > 0)
					{
						//patient exists and now we add the header to show that the patient have registered patients
						$head ="<div class='well well-sm'><p>List Of Registered Patient</p></div>";
					
					    //update patient number.
						$patient_num = 1;
						
						//populate the fields
						
						while($rows = mysql_fetch_array($results)){	
						
							//loop through array of patient and initialize an object with values
						   $patient = new Patient($rows['name'], $rows['surname'], $rows['email'],
            						   $rows['id_number'], $rows['phone'], $rows['gender'], $rows['fk_doctor_code'], $rows['person_id']);
									   
							//get values from object and set to variables	 
							$patient_no = $patient->getPerson_id();
							$name = $patient->getName();
							$surname = $patient->getSurname();
							$cell = $patient-> getPhone();
							$email =  $patient->getEmail();
							$gender = $patient->getGender();
							$IDNo = $patient->getIdNumber();
							
							$street_name = $rows['street_name'];
							$city = $rows['city'];
							
							//get patient message status. if patient have new message the an approprate message will be shown
							$msg_state = $doc_functions->getMessageStatus($IDNo);
							
							$address = $street_name." ".$city;
							//populate patient list
									$tableContent .= "<tr>
									<td>$patient_no</td>        
									<td>$name</td>
									<td>$surname</td>
									<td>$cell</td>
									<td>$email</td>
									<td>$gender</td>
									<td>$IDNo</td>
									<td>$address</td>
									
									<td style='background:white;'><p style='color:#8CCA33;';><input 
									style='color:white;' type='submit' id='inbox' name='inbox' value='       $patient_no'/> $msg_state</p></td>
									
									<form action='' method='POST' onsubmit='return deletePatient()'>
									<td style='background:white;'><input style='color:white;'  type='submit' id='del' name='delete'
        									value='       $patient_no'/></td>
									</form>
								</tr>";
						
						}
					
				   }else{
					   //doctor doesn't have any patient
					   $tableContent="";
					   
					}


					
				}else{
					
					echo "Failed to connect to Server...";
					exit;
				}
				
				if(isset($_POST['inbox']))
				{
					//when inbox is clicked we set session of patient id to the chatting.php 
					$_SESSION['patient_inbox'] = md5(uniqid());
					$_SESSION['patient_id'] = $_POST['inbox'] ; 
					
				
					header("location: chat.php");
					
				}else if(isset($_POST['delete']))
				{
					
					
					$patientNo = str_replace(' ', '',$_POST['delete']); 
					$feedback = $doc_functions->deletePatient($patientNo);
					
						$_SESSION['result'] = "delete"; 
	                    header('location: result.php');
					
				}else if(isset($_POST['logout']))
				{
					//logout destroy all sessions and head to input page
					session_destroy();
					header("location: index.php");
					
				}else if(isset($_POST['update']))
				{
					//updating details
					$update_msg = $doc_functions->updatePerson($doc_id, stripcslashes($_POST['docphone']), 
					           stripcslashes($_POST['docStreet']), stripcslashes($_POST['doccity']),  stripcslashes($_POST['docPostalcode']),
     							   stripcslashes($_POST['docspecialty']));
					
				}else if(isset($_POST['newPasswordUpdate']))
				{
					//updating password
					$oldPassword = $_SESSION['password'];
					$oldpass = md5($_POST['password']);
					$pass_msg = "Incorrect old password entered.";
					

					if(strcasecmp($oldPassword,$oldpass)==0)
					{
						$password = stripcslashes($_POST['newPassword']);
						$pass_msg = $doc_functions->updatePassword($password, $doc_id);
					}else{exit;}

					
				}else if(isset($_POST['send']))
				{
					//post news
					$newsFeedback = "<div class='well well-sm'><p style='text-align:center; color:red;'>News not send.</p></div>";
					$title = stripcslashes($_POST['title']);
					$message = stripcslashes($_POST['message']);
					if(!empty($title) && !empty($message))
					{
						$arr = array('news'=>$message, 'doctor'=>$docName, 'title'=>$title);
					
						$msg_to_patient = json_encode($arr);
						$state = $doc_functions->sendNews($title, $msg_to_patient);
						
						if(strcasecmp($state, "1")==0)
						{
							$post_msg = $doc_functions->postNews($title, $message);
							$newsFeedback = "<div class='well well-sm'><p style='text-align:center; color:green;'>News Send, Thank you for information.</p></div>";
						}

					}else{
						$newsFeedback = "<div class='well well-sm'><p style='text-align:center; color:red;'>Enter Message and title</p></div>";
						exit;
					}

				}

		}catch(Exception $ex)
		{
			/* If something goes wrong we catch the exception thrown by the object, print the message, and stop the execution of script */
			print 'Error! <br />' . $ex->getMessage() . '<br />';
			exit;
		}
?>


<!doctype html>
<html>
	<head>
		<title>Patients</title>
		<link rel="stylesheet" href="css/viewall.css" type="text/css" />
		<script src="js/validate.js"></script>
		<link href="css/tab/bootstrap.min.css" rel="stylesheet">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width, initial-scale=1.0"/>
		 <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		 
	</head>
	<body>
	
		<!-- Header-->
		<header>
			<div id="container"> 

			            <nav class="navbar navbar-default" id="mainnav">
                        <div class="container-fluid">
                            <div class="navbar-header">
								<p class="pull-right" style="padding-top:15px;">Logged In As <mark> <?php  echo 'Dr '. $docSurname.' ' .$docName; ?></mark> </p>
                                
                            </div>
                            
                            <div class="collapse navbar-collapse">
                              <ul class="nav navbar-nav-right pull-right">
                                   <li><a href="logout.php">Log Out</a></li>
                              </ul>
                            </div>
                        </div>

                    </nav>
			</div>		
		</header>	
		<?php echo $status; ?>
		 <br>

	<div id="wrapper">
		<?php echo $newsFeedback; ?>			
	<section>
    <div class="container">
     <div id="tab-container">
                <div class="row">
                    <div class="col-md-12">
                    
                    </div>
                    <div class="col-md-6">
                        <ul id="tab1" class="nav nav-tabs">
                            <li class="active"><a href="#tab1-item1" data-toggle="tab">Patient Manager</a></li>
                            <li><a href="#tab1-item2" data-toggle="tab">Post News</a></li>
                            <li><a href="#tab1-item3" data-toggle="tab">Update Details</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="tab1-item1">
								<div>
								<form action="" method="POST">	
								<?php echo $delete_feedback; ?>
								<table style="width: auto;" class="bordered">
									<thead>
									
									<?php
										if($patient_num == 1)
										{
									?>		
									<tr id="head">
										<th>#</th>        
										<th >Name</th>
										<th>Surname</th>
										<th>Cell Number</th>
										<th>Email</th>
										<th>Gender</th>
										<th>ID Number</th>
										<th>Address</th>
										
									</tr>
									</thead>
									<tr><?php echo $tableContent;?></tr>
									<?php
										}else{
											echo $head;
										}
									?>	
									
									

								</table>
							 </form>
							</div>
                            </div>
                            <div class="tab-pane fade" id="tab1-item2">
								
								<br>
								<p style="color:green; background:white;">This message is going to reach all Patients using the First Aid App. Please lets help the world and ensure everyone is healthy and have access to information.<p>
							
								<p>
									<form action="viewall.php" method="POST" class="parallax" onsubmit="return validatePost()">
										<p style="color:blue;"><?php echo $post_msg; ?></p>
										<p>
											<input type="text" class="form-control" name="title" placeholder="Enter message title" id="msgs" required="required" />
										</p>
									
											<div class="form-group">
												<textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter your message" required="required"></textarea>
											</div>   
										<p>	
											<input type="submit" class="btn btn-success" name="send" value="Post News" />
										</p>
									</form>
								</p>
							
							</div>
                            <div class="tab-pane fade" id="tab1-item3">
                                <p>
								
									<form method="post" action="viewall.php" onsubmit="return validateUpdateDetails()">
										<fieldset>
											<h4>Update Personal Details</h4>
										<p style="color:green;"><?php echo $update_msg; ?></p>
										<p>Name:<input style="width:300px;" type="text" class="form-control" name="docname" id="docname" value="<?php echo $docName?>" /> Surname:<input style="width:300px;" type="text" class="form-control" id="docsurname" name="docsurname" value="<?php echo $docSurname?>" /> Id Number:<input type="text" disabled style="width:300px;" class="form-control" id="docID" name="docID" value="<?php echo $docIDNo?>" /></p>
										 Phone:<input style="width:300px;" type="text" id="docphone" name="docphone" class="form-control" value="<?php echo $docCell?>" />  <p style="margin-left:450px; margin-top:-235px;">Speciality:<input type="text" style="width:300px;" class="form-control" id="docspecialty" name="docspecialty" value="<?php echo $specialty?>" /></p>  <p style="width:300px; margin-left:450px;" >Streen Name:<input  type="text" class="form-control" id="docStreet" name="docStreet" value="<?php echo $doc_street_name?>" /></p>
										<p style="width:300px; margin-left:450px;">City:<input style="width:300px;" type="text" id="doccity" name="doccity" class="form-control" value="<?php echo $doc_city?>" /> </p> <p style="width:300px; margin-left:450px;">Postal code:<input type="text" style="width:300px;" class="form-control" id="docPostalcode" name="docPostalcode" value="<?php echo $postal?>" /> </p>
										<p>	
											<input type="submit" class="btn btn-success" name="update" value="Update Info" />
										</p>
										</fieldset>
									</form>
									
									<span>
										<h4 style="background:red; color:white; border-radius:04px;">Update Password</h4>
										<p style="color:red;"><?php echo $pass_msg; ?></p>
										<form action="viewall.php" method="post" onsubmit="return changePassword()">
											<p>Current Password:<input style="width:300px;" type="password" placeholder="Enter Current Password" class="form-control"  id="password" name="password" value="" /></p>
											<p>New Password:<input style="width:300px;" type="password" class="form-control" placeholder="Enter New Password" id="newPassword" name="newPassword" value="" /></p>
											<p>New Password(Again):<input style="width:300px;" type="password" class="form-control" placeholder="R-Enter new Password" id="reNewPass" name="reNewPass" value="" /></p>
											<input type="submit" style="background:red;" class="btn btn-success" name="newPasswordUpdate" value="Change Password" />
										</form>
									</span>
								
								</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/#table-container-->
		</div>	
	</section>
					   
					   
					  
			<br/>

			<br><br>
			<hr />
				
			<footer>
				<form method="get">	
					
				
						<p style="font-family: Helvetica Neue; margin-top:30px; text-align:center;, Helvetica, sans-serif; font-size: 12px; ">Copyright (c) 2016 - Hibro-Technology <a href="t&cs.php" > Terms & Conditions</a></p>
				
				</form>
			</footer>
					
		</div>
   <script type="text/javascript" src="js/tab/jquery.js"></script>
    <script type="text/javascript" src="js/tab/bootstrap.min.js"></script>
	</body>
</html>

<?php
	echo $msg_state;
	
	}else
	{
		header("location: index.php");
	}
?>

			