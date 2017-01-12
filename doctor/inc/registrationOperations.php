<?php

/*--------------------------------------------------------------------------------------------
|    @desc:        index.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/

/*
*This class handle registration operations
*From mobile app and doctor site
*/


class Register {

    private $db;


    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }
	
	/*
     * register doctor in the database
     * returns respond details
     */
	
	public function insert_doctor($name, $surname, $id, $email, $phone, $gender, $special, $doctorCode, $street, $city, $postal, $password, $conn)
	{
		$doc = "doctor";
		$result = "Error occured";
		$status = "Active";
		//sql query to insert 
		$query = "INSERT INTO tblPerson(name, surname, id_number, email, phone, gender)
            		VALUES('$name', '$surname', '$id', '$email', '$phone', '$gender')";
				
		if(mysqli_query($conn, $query))
		{
			//if doctor is successfully inserted, insert the other entities
			$person_id = mysqli_insert_id($conn);//get person id
			$qry_doc = "INSERT INTO tblDoctor(person_id ,specialization, doctor_code)
              			VALUES('$person_id', '$special', '$doctorCode')";
						
			$qry_address = "INSERT INTO tblAddress(person_id, street_name, city, postal_code)
                 			VALUES('$person_id', '$street', '$city', '$postal')";
							
			$qry_login = "INSERT INTO tblLogin(person_id, password, username, role, status)
            			VALUES('$person_id', '$password', '$email','$doc','$status')";
					
			mysqli_query($conn, $qry_doc);
			mysqli_query($conn, $qry_address);
			mysqli_query($conn, $qry_login);
			//forwad respond back
			$result = "Doctor is successfully added";		
		}else{
			$result = "Doctor is not added, tecnical problems with the server connection.";
		}
		
		
		return $result;
		
	}
	
	/**
     * register patient in the database
     * returns respond details
     */
	
	public function insert_patient($name, $surname, $id, $email, $phone, $gender, $doctorCode,  $street, $city, $postal, $token, $conn)
	{
		$feedback = "Registration failed..!";
		//sql query to insert patient
		$query = "INSERT INTO tblPerson(name, surname, id_number, email, phone, gender) 
		            VALUES('$name', '$surname', '$id', '$email', '$phone', '$gender')";
				
		if(mysqli_query($conn, $query))
		{ 
			//if person inserted, insert all entities that depend on it
			$person_id = mysqli_insert_id($conn);
			$query_token = "INSERT INTO tblToken(patient_idNo, token) VALUES('$id', '$token')";
			
			$qry_patient = "INSERT INTO tblPatient(id_number, fk_doctor_code) VALUES('$id', '$doctorCode')";
			
			$qry_address = "INSERT INTO tblAddress(person_id, street_name, city, postal_code) 
			                 VALUES('$person_id', '$street', '$city', '$postal')";
			
			if(mysqli_query($conn, $qry_patient) && mysqli_query($conn, $qry_address) && mysqli_query($conn, $qry_address))
			{
				$feedback = "Registration successful";
			}
				
			
		}else{
			$feedback = "Registration not successful due to technical issues";
		}
		
		
		return $feedback;
	}
	
	/*
     * This method test doctor code in the database
     * returns respond details, yes if exists and No if false
     */
	public function testDoctorCode($doctors, $doctorCode)
	{
		$testCode = "No";
		
		while ($row = mysql_fetch_array($doctors)) {
					
		     if($row['doctor_code'] == $doctorCode)
			 {
				$testCode = "Yes";
				break;
		     }
		}
		
		
		return $testCode;
	}
	
	/*
     * This method test ID number  in the database
     * returns respond details, yes if exists and No if false
     */
	public function testPatient($patients, $id)
	{
		$result = "No";
		
		while ($row = mysql_fetch_array($patients)) {
					
		     if($row['id_number'] == $id)
			 {
				$result = "Yes";
				break;
		     }
		}
		
		return $result;
	}
	
	//updating the current sequence number
	public function updateSeq()
	{
		$update = "Update sequence SET seq_num = seq_num+3";
		mysql_query($update);
		$num = mysql_affected_rows();
		$doctorCode = 0;
		
		mysql_query("COMMIT");
		
		if($num > 0)
		{
			$result =  mysql_query("SELECT seq_num FROM sequence");
			
            if($row = mysql_fetch_assoc($result))
			{
				 $num = rand(100, 999);
				$doctorCode = $row['seq_num'].$num;
			}				
		}
		return $doctorCode;
	}
	
	/*
	*get the doctor cellphone
	*receive the doctor_code
	*return the cellphone
	*/
	
	public function getPhone($doctorCode)
	{
		$sql = "SELECT phone From tblperson, tblDoctor Where tblDoctor.person_id =
           		tblPerson.person_id AND doctor_code like '$doctorCode'";
		$phone = "";
		
		$result = mysql_query($sql);
		if($row = mysql_fetch_assoc($result))
		{
			$phone = $row['phone'];
		}
		
		return $phone;
	}
	
	
}	

?>