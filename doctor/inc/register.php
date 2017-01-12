<?php

/*--------------------------------------------------------------------------------------------
|    @desc:        index.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/

	session_start();
		

	
	if(isset($_POST['decision']))
	{
			require "connect.php";
	
		//initialize database function object
		include_once 'db_functions.php';
		include_once 'registrationOperations.php';
		$db = new DB_Functions();
		$register = new Register();
		
		//get all doctors
		$doctors = $db->getAllDoctors();
	   /*
		*This portion is for doctor registration from admin site.
		*/
		
		//get values from the value
		$name = mysqli_real_escape_string($conn, stripcslashes($_POST['txtFname']));
		$surname = mysqli_real_escape_string($conn, stripcslashes($_POST['txtSurname']));
		$id =  mysqli_real_escape_string($conn, stripcslashes($_POST['txtPassport']));
		$email = mysqli_real_escape_string($conn, stripcslashes($_POST['txtEmail']));
		$phone = mysqli_real_escape_string($conn, stripcslashes($_POST['txtTel']));
		$street = mysqli_real_escape_string($conn, stripcslashes($_POST['txtAddress1']));
		$city = mysqli_real_escape_string($conn, stripcslashes($_POST['txtCity']));
		$postal = mysqli_real_escape_string($conn, stripcslashes($_POST['txtPostCode']));
		$gender = mysqli_real_escape_string($conn, stripcslashes($_POST['txtGender']));
		$doctorCode = mysqli_real_escape_string($conn, stripcslashes($_POST['txtDoctorCode']));
		$username = mysqli_real_escape_string($conn, stripcslashes($_POST['txtUsername']));
		$password = md5(mysqli_real_escape_string($conn, stripcslashes($_POST['txtPassword'])));
		$special = mysqli_real_escape_string($conn, stripcslashes($_POST['txtSpecial']));
		
		if(strcmp($name,"") != 0 && strcmp($surname,"") != 0 && strcmp($id,"") != 0 && strcmp($email ,"") != 0 && strcmp($phone,"") != 0 && strcmp($street,"") != 0 && strcmp($city,"") != 0 && strcmp($postal,"") != 0 && strcmp($gender,"") != 0 && strcmp($doctorCode,"") != 0 && strcmp($username,"") != 0 && strcmp($password,"") != 0 && strcmp($special,"") != 0)
		{
			return;
		}			
		
		
		//get number of rows
		 if ($doctors != false)
               $no_of_doc = mysql_num_rows($doctors);
		 else
            $no_of_doc = 0;
		
		$test = false;
		//we test if any doctor exists in the database for validation purpose
		if ($no_of_doc > 0) {
			
			while ($row = mysql_fetch_array($doctors)) {
				
				//if avaliable doctor exists we test the doctor code if they dont match any in the database
				//and email address. we return true if they exists
				if($row['doctor_code'] == $doctorCode || $row['id_number'] == $id || $row['email'] == $email)
				{
					$test = true;
					break;
				}
			}
			
			//if doct and email doesn't exists we insert a doctor to the database
		  if($test == false)
		   {

			  
			   $doc_code = $register->updateSeq();
			   
			   $registration_status = $register->insert_doctor($name, $surname, $id, $email, $phone, $gender,
                        			   $special, $doc_code, $street, $city, $postal, $password, $conn);
				//set session for status and redirect
				$_SESSION['status'] = $registration_status;
				header("location: ../profile.php");
				
		   }else{
			   //else set a status session and re direct the the registration site
			    
			   	$_SESSION['status'] = "Sorry I can't add the doctor because either doctor code,
                      				ID number and or email already exist in the database.";
				header("location: ../registration.php");
			
		   }	
		   
		}else{
			//we reach this side if this is the new doctor to be inserted
			$doc_code = $register->updateSeq();
			
			$registration_status = $register->insert_doctor($name, $surname, $id, $email, $phone, $gender,
                     			$special, $doc_code, $street, $city, $postal, $password, $username, $conn);
			$_SESSION['status'] = "Doctor is  added";
			header("location: ../profile.php");
			
		}
		
	}else if(isset($_POST['phone'])){
		
			require "connect.php";
	
		//initialize database function object
		include_once 'db_functions.php';
		include_once 'registrationOperations.php';
		$db = new DB_Functions();
		$register = new Register();
		
		//get all doctors
		$doctors = $db->getAllDoctors();
		
		/*
		*This portion is the mobile side of mobile registration.
		*it perform registration from mobile application
		*/
		 
		 //get values from mobile app
		   $name = mysqli_real_escape_string($conn, stripcslashes($_POST['name']));
			$surname = mysqli_real_escape_string($conn, stripcslashes($_POST['surname']));
			$id =  mysqli_real_escape_string($conn, stripcslashes($_POST['id']));
			$email = mysqli_real_escape_string($conn, stripcslashes($_POST['email']));
			$phone = mysqli_real_escape_string($conn, stripcslashes($_POST['phone_number']));
			$street = mysqli_real_escape_string($conn, stripcslashes($_POST['street']));
			$city = mysqli_real_escape_string($conn, stripcslashes($_POST['city']));
			$postal = mysqli_real_escape_string($conn, stripcslashes($_POST['postal']));
			$gender = mysqli_real_escape_string($conn, stripcslashes($_POST['gender']));
			$doctorCode = mysqli_real_escape_string($conn, stripcslashes($_POST['doctor_code']));
			$token = mysqli_real_escape_string($conn, stripcslashes($_POST['token']));
			
			//get all patients and doctors from database
			$patients = $db->getAllPatient();
			$doctors = $db->getAllDoctors();
			//get number of doctors 
			 if ($doctors != false)
			 { $no_of_doc = mysql_num_rows($doctors);}
			 else
			 {$no_of_doc = 0;}
		 
			//get number of patients
			 if ($patients != false)
			 { $no_of_patient = mysql_num_rows($patients);}
			 else
			 {$no_of_patient = 0;}
			
			$arrayResult = array();
			/*
			*Take note: Patient can only register if doctor is already available
			*if there is no doctor probably patient doesnt have doctor_code!
			*/
			
			//test if doctor exists
			if ($no_of_doc > 0) {
				//test if patient exists
				if ($no_of_patient > 0){
					
				//calling methods that valid doctor code and patient ID
				  $doctorCodeCheck = $register->testDoctorCode($doctors, $doctorCode);
				  $patientIdCheck = $register->testPatient($patients, $id);
		
					//test if the  doctor Code and ID number
					if($doctorCodeCheck == "Yes")
					{
						if($patientIdCheck == "No")
						{
							//insert the patient
							$feetback = $register->insert_patient($name, $surname, $id, $email, $phone, $gender,
            							$doctorCode,  $street, $city, $postal, $token, $conn);
							$arrayResult['feetback'] = $feetback;
							$arrayResult['phone'] = $register->getPhone($doctorCode);
							
							echo json_encode($arrayResult);
						}else{
							//display approprote message for error
							echo "Error, ID number is registered already.";
						}

					}else{
						echo "Error, doctor code doesn't exist";
						
					}
					
				}else{
					  //insert new patient 
						$feetback = $register->insert_patient($name, $surname, $id, $email, $phone,
            						$gender, $doctorCode,  $street, $city, $postal, $conn);
						
						$arrayResult['feetback'] = $feetback;
						$arrayResult['phone'] = $register->getPhone($doctorCode);
							
						echo json_encode($arrayResult);
								
				}

				
				
			}else{
				echo "Error no doctor available in the system";
			}	
	}
?>