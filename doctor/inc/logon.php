<?php

/*--------------------------------------------------------------------------------------------
|    @desc:        pagination chat.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/
	
	class Process_Login{
		
		private $db;
		
	
		// constructor
		function __construct() {
			
			include_once 'db_connect.php';
			// connecting to database
			$this->db = new DB_Connect();
			$this->db->connect();
		
		}

		// destructor
		function __destruct() {
			
		}
		
		/**
		 * Login to the system
		 * returns user details
		 */
		 
		 public function login($username, $password)
		 {
			 //prevent mysql injection
			$username = stripcslashes($username);
			$password = stripcslashes($password);
			$username = mysql_real_escape_string($username);
			$password = mysql_real_escape_string($password);
			
			 //query the database to get the user.
			$query = "SELECT * FROM tbllogin WHERE username like '$username' AND password like '$password'";
			$login = mysql_query($query);
			
			return $login;
		 }
		 
		 /**
		 * get the doctor who logged in
		 * returns user details
		 */
		 
		 public function getLoggedDoctor($id)
		 {
			 $query = "SELECT * FROM tbldoctor, tblperson WHERE tbldoctor.person_id = tblperson.person_id 
			           AND tblperson.person_id like '$id' LIMIT 1";
						
			$doctor = mysql_query($query);
			
			return $doctor;
		 }
	
	
	}


?>