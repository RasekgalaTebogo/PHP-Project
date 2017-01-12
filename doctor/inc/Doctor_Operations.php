<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Doctor_Operations
 *
 * @author Rasekgala
 */

  require_once './class/Message.class.php';
  
class Doctor_Operations {
    
    private $db;


    // constructor
    function __construct() {
        
        include_once './inc/db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }
	
	/*
	*the method search the list of patients
	*The method receive the doctor_code
	* and query the database and return the sql results
	*/
    
    public function getAllPatients($doctor_code) {
        
		//sql query to database
        $query = "SELECT tblPerson.person_id, name, surname, gender,phone, email, tblPatient.fk_doctor_code,
            		tblPatient.id_number, street_name, city, postal_code from tblPerson, tblPatient, tbladdress
		WHERE tblPerson.id_number = tblPatient.id_number
		AND tblPerson.person_id =  tbladdress.person_id
		AND tblPatient.fk_doctor_code = '$doctor_code';";
        
		//return the result
		
        return mysql_query($query);
    }
	
	/*
	*The method search doctor from the database.
	*The method receive the doctor_code
	* and query the database and return the sql results
	*/
	public function getDoctor($doctor_code)
	{
		//mysql query
		$query = "SELECT * FROM tblDoctor WHERE doctor_code like '$doctor_code'";
		$result = mysql_query($query);
		//return result
	
		return $result;
	}
	
	/*
	*The method search doctor  address from the database.
	*The method receive the person id
	* and query the database and return the sql results
	*/
	public function getAddress($person_id)
	{
		//mysql query
		$query = "SELECT * FROM tblAddress WHERE person_id like '$person_id'";
		$result = mysql_query($query);
		//return result
	
		return $result;
	}
	
	/*
	*The method update doctor password.
	*The method receive the person id
	* and query the database and return the sql results
	*/
	public function updatePassword($password, $person_id)
	{

		$result = "Not updated, please check connection";
		//mysql query
		if($password != "")
		{
			$pass = md5($password);
			$query = "Update tblLogin SET password='$pass' WHERE person_id='$person_id'";
			$results = mysql_query($query);
			if(mysql_affected_rows() > 0)
			{
				$result ="Successfully updated password";
			}
		}

		
		
		//return result
		return $result;
	}
	
	
	/*
	*The get the patient token.
	*The method receive patient id
	* return the token
	*/
	
	public function getPatientToken($patient_id)
	{
		$token = "";
		
		
		$sql = "SELECT * FROM tbltoken WHERE patient_id like '$patient_id'";
		$result = mysql_query($sql);
			
		if($row = mysql_fetch_row($result))
	    {
		   $token = $row['token'];
				 
		}
		
		return $result;	 
		
	}
	
	/*
	*The get the current password
	*The method receive doctor
	* return the password
	*/
	
	public function getPassword($doctor_code)
	{
		$password = "";
		
			$sql=  "SELECT * FROM btllogin WHERE doctor_code like '$doctor_code'";
			$result = mysql_query($sql);
			
		     if($row = mysql_fetch_row($result))
	         {
				 $password = $row['password'];
				 
			 }
		 
		return $password;	 
		
	}
	
	/*
	*The method send news to patient.
	*The method receive the title & message
	* 
	*/
	
	public function sendNews($title, $message)
	{
		
			$path_to_fc = 'https://fcm.googleapis.com/fcm/send';
			
			$server_key = "AIzaSyAD_qcMl6-IDuRKdifkNFB3n5cdeGvr1Ec";
			
			$sql = "SELECT * FROM tbltoken;";

			
			if($message != "" && $title != "")
			{
				
				$sql_result = mysql_query("SELECT token FROM tbltoken");
				
				$numRows = mysql_num_rows($sql_result);
				
				if($numRows > 0)
				{
					while($row = mysql_fetch_array($sql_result))
					{
					
							$token = $row['token'];
							
							$headers = array(
										'Authorization:key=' .$server_key, 
										'Content-Type:application/json'
							);
							
							$fields = array('to'=>$token,
									'notification'=>array('title'=>$title, 'message'=>$message));
						
							$payload = json_encode($fields);
							
							
							
							$curl_session = curl_init();
							
							curl_setopt($curl_session, CURLOPT_URL, $path_to_fc);
							curl_setopt($curl_session, CURLOPT_POST, true);
							curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
							curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
							
							$result = curl_exec($curl_session);
							curl_close($curl_session);
							
							$status = json_decode($result);
							$success = $status->{'success'};

					}
				}
			}
			
			return $success;
			
	}
	
    
	/*
	*The method post news to the database.
	*The method receive the title & message
	* 
	*/
	public function postNews($title, $message)
	{
		$result = "Message not send";
		
		if($title != "" && $message != "")
		{
			//mysql query
			$query = "INSERT INTO tblPost(message, title) VALUES('$message', '$title')";
			mysql_query($query);
			if(mysql_affected_rows() > 0)
			{
				$result = "Message send..";
			}
		}

		
		//return result
		return $result;
	}
	
	/*
	*The method update personal details of doctor.
	*The method receive the title & message
	* 
	*/
	public function updatePerson($person_id, $phone, $street_name, $city, $posta_code, $speciality)
	{
		$result = "Not Updated, error occured.";
		
		if(!empty($phone) && !empty($street_name) && !empty($city) && !empty($posta_code) && !empty($speciality))
		{
					//mysql query
				$query = "UPDATE tblPerson SET phone = '$phone' WHERE person_id like '$person_id'";
				$query1 = "UPDATE tblAddress SET street_name = '$street_name', city ='$city', postal_code = '$posta_code' WHERE person_id = '$person_id'";
				$query2 = "UPDATE tblDoctor SET specialization = '$speciality' WHERE person_id = '$person_id'";
				
				$result1 = mysql_query($query);
				$result2 = mysql_query($query1);
				$result3 = mysql_query($query2);
					
				$result = "Details Updated,  refresh to witness changes";
				
				mysql_query("COMMIT");

		}
		
		//return result
		return $result;
	}
	
	/*
	*The method search all doctor' patient messages from the database.
	*The method receive the doctor_code
	* and query the database and return the patient
	*/
    public function searchMessage($doctor_code) {
        
        $num_msg = 0;
        if(mysql_num_rows($this->getAllPatients($doctor_code)) > 0)
        {
            while ($row = mysql_fetch_array($this->getAllPatients($doctor_code))) {
                
               $patient = new Patient($row['name'], $row['surname'], $row['email'], $row['id_number'], $row['phone'], $row['gender'], $row['doctor_code'],
                     $row['specialization'], $row['person_id'], $row['person_id']);
            }
        }
    }
    

		/*
	*The method update message status to show that the message is now read by doctor.
	*The method receive the patient_id
	* 
	*/
    public function updateMessage($patient_id) {
        
		$query = "UPDATE tblStatus SET status = 'read' WHERE patient_id = '$patient_id'";
		$result = mysql_query($query);
		$feedback = 0;
		if(mysql_affected_rows() > 0)
		{
			$feedback = 1;
		}
		
		return $feedback;
    }
    
		/*
	*The method search how many message doctor have from the database.
	*The method receive the doctor_code
	* return the total number of messages
	*/
    
	
	public function getAllDocMessages($doctor_id)
    {
        $query = "SELECT * FROM tblstatus WHERE doctor_id = '$doctor_id'";
		  
        $results = mysql_query($query);
        $number = 0;//initialize to zero
		while($row = mysql_fetch_array($results))
		{
			//loop and test is there is any unread message and inrement the number
			if(strcasecmp($row['status'],'unread') == 0)
			{
				$number += 1;
			}
			
		}
	
        return $number;
        
    }
	
	/*
	*The method search message status of the patient.
	*The method receive the patient_id
	* and query the database and return the status either new message or null
	*/
    public function getMessageStatus($patient_id) {
		
        $query = "SELECT * FROM tblStatus where patient_id like '$patient_id'";
		
		
        $status = "";
        
        $result = mysql_query($query);
        
        while($rows = mysql_fetch_array($result))
        {

           if(strcasecmp($rows['status'],'unread') == 0)
           {
			   //set status if found that new message exist
               $status = "New Message";
           }
        }
		
		return $status;//return status
    }
	
	public function deletePatient($patient_id)
	{
		$result = "Something went wrong while deleting, try again";
		$idNumber;
		
		if($row = mysql_fetch_assoc($this->getPatient($patient_id)))
		{
			$idNumber = $row['id_number'];
		}
		$sql = "DELETE FROM tblPerson where id_number like '$idNumber'";
		$query = mysql_query($sql);
		//$rowno = mysql_affected_rows($query);
		
		if($query)
		{
			$sqlAddress = "DELETE FROM tblAddress WHERE person_id like '$patient_id'";
			$sqlToke = "DELETE FROM tblToken WHERE patient_idNo like '$idNumber'";
			
			$sqlMessage = "DELETE FROM message WHERE message.from_id like '$idNumber' OR  message.to_id like '$idNumber'";
			
			$sqlPatient = "DELETE FROM tblPatient WHERE id_number like '$idNumber'";	
			
			mysql_query($sqlAddress);
			mysql_query($sqlToke);
			mysql_query($sqlMessage);
			mysql_query($sqlPatient);
			$result = "Patient successfully deleted";
		}
		
		
		return $result;
		
	}	
	
	public function getPatient($patient_id)
	{
		
		$query = "SELECT * FROM tblPerson WHERE person_id like '$patient_id'";
		$result = mysql_query($query);
		
		
		return $result;
	}
	
	public function close()
	{
		$this->db->close();
	}
	
}
