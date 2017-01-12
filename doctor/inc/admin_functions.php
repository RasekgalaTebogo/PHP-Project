<?php

/*--------------------------------------------------------------------------------------------
|    @desc:        pagination chat.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/
	
	class Admin_Function
	{
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
		
		
		public function searchDoctor($doctorCode)
		{
			$result = mysql_query("select * FROM tblPerson, tblDoctor, tblAddress where tblDoctor.person_id 
      			= tblPerson.person_id AND tblAddress.person_id  = tblPerson.person_id AND tblDoctor.doctor_code = '$doctorCode'");
			
			return $result;
		}
		
		public function blockDoctor($doctorCode)
		{
			$result = mysql_query("SELECT * FROM tblDoctor WHERE doctor_code like '$doctorCode' Limit 1");
			$feeback = "Doctor not blocked, verify doctor code.";
			if($row = mysql_fetch_assoc($result)) {
				
				$id =$row['person_id'];
				$status = "Blocked";
				$result = mysql_query("Update tblLogin SET status ='$status' WHERE person_id ='$id'");
				$feeback = "Doctor is blocked.";
			}
			
			return $feeback;
		}
		
		public function getAllDoctor()
		{
			$result = mysql_query("select * FROM tblPerson, tblDoctor where tblDoctor.person_id  = tblPerson.person_id");
			
			return $result;
		}
		
		public function deleteDoctor($id)
		{
			$query = mysql_query("select * FROM tblDoctor where tblDoctor.doctor_code  = '$id'");
			$status = "Error while deleting the doctor, verify ID Number";
			
			if($row = mysql_fetch_assoc($query))
			{
				$person_id = $row['person_id'];
				$result = mysql_query("DELETE FROM tblPerson WHERE person_id = '$person_id'");
	
					$address = mysql_query("DELETE FROM tblAddress WHERE person_id='$person_id'");
					$doctor = mysql_query("DELETE FROM tblDoctor WHERE person_id='$person_id'");
					$login = mysql_query("DELETE FROM tblLogin WHERE doctor_id='$person_id'");
					
					$status = "Doctor successfully deleted";
			}

			
			return $status;
		}
	
		public function deletePatient($id)
		{
			$result = mysql_query("DELETE FROM tblPerson WHERE id_number='$id'");
			$person_id = mysql_insert_id($db);
			$status = "Error while deleting the patient, verify ID Number";
			if($result)
			{
				$address = mysql_query("DELETE FROM tblAddress WHERE person_id='$person_id'");
				$doctor = mysql_query("DELETE FROM tblPatient WHERE id_number='$id'");
		
				$status = "Patient successfully deleted";
			}
			
			return $result;
		}
		
	}

?>