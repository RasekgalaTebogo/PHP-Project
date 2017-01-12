<?php

	require_once 'class/Message.class.php';
	
	class Message_Handler{
	
	    
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
	
	public function getPatient($patient_id)
	{
		
		$query = "SELECT * FROM tblPerson, tblPatient WHERE tblPerson.id_number = tblPatient.id_number
		AND person_id like '$patient_id'";
		$result = mysql_query($query);
		
		return $result;
	}
	

	
	public function getAllMessages($patient_id, $doctor_code)
	{
		$query = "select * from message where  message.to_id like '$doctor_code' 
		  AND message.from_id like '$patient_id' OR message.from_id like '$doctor_code'
		  AND message.to_id like '$patient_id' order by message_id";
		// DESC
		$result = mysql_query($query);
		
		return $result;
	}
	
  	/*
	*The get the patient token.
	*The method receive patient id
	* return the token
	*/
	
	private function getPatientToken($patient_id)
	{
		$token = "";
		
			$sql= "SELECT * FROM tbltoken WHERE patient_idNo like '$patient_id'";
			$result = mysql_query($sql);
			//$rows = mysql_fetch_assoc($result)
		     if($result)
	         {
				// $token = $rows['token'];
				 $token = mysql_result($result, 0, 'token');
				 
			 }
		return $token;	 
		
	}	
	
	/*
	*The method send message.
	*The method receive the  message & token
	* return response
	*/
	
	public function  sendMessage($message, $patient_id)
	{
			
			$path_to_fc = 'https://fcm.googleapis.com/fcm/send';
			
			$server_key = "AIzaSyAD_qcMl6-IDuRKdifkNFB3n5cdeGvr1Ec";
			
			$title = "New Message";
			
			$result = "Message Not send";
			
			$token = $this->getPatientToken($patient_id);
			
			if($message != "" && $token != "")
			{
		
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
				
				$this->db->close();
			}
			
			return $success;
	}
	
	
	public function saveMessage($message, $patient_id, $doctorCode)
	{
		 include_once './inc/db_functions.php';
		//Create Object for DB_Functions clas
		
		$db = new DB_Functions(); 
		//Store Respond into MySQL DB
		$feedback = "Message not send";
		$message = stripcslashes($message);
		$message = mysql_real_escape_string($message);

		$res = $db->storeRespond($message, $patient_id, $doctorCode, "");
			//Based on inserttion, create JSON response
			if($res){ 
				 $feedback =  "Send successful";
			 }else{ 
				$feedback = "Message not send";
			}
		
		return $feedback;
		
	}
	
	/**
     * Storing new respond
     * returns respond details
     */
    public function storeRespond($respond, $patientNo, $doctorCode) {
        // Insert respond into database
        $result = mysql_query("INSERT INTO tblRespond(patient_id,
		doctor_code,respond) VALUES('$patientNo','$doctorCode', '$respond')");
		
        if ($result) {
			return true;
        } else {			
				// For other errors
				return false;
		}
    }
	
	public function sendEmailMessage($message, $email, $subject)
	{
		
	}
	
	public function deleteChat($patient_id, $doctor_code)
	{
		
		$feedback = "Message not deleted";
		$query = "DELETE FROM message where  message.to_id like '$doctor_code' 
		      AND message.from_id like '$patient_id' OR message.from_id like '$doctor_code'
			  AND message.to_id like '$patient_id'";
		
		mysql_query($query);
		
		if(mysql_affected_rows() > 0)
		{
			$query2 = "DELETE FROM tblstatus where message_id like '$patient_id'";
			mysql_query($query2);
			$feedback = "Messages deleted";
		}
		//$this->db->close();
		return $feedback;
	}
	
}
	
?>