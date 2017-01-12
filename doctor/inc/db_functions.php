<?php
/*--------------------------------------------------------------------------------------------
|    @desc:        pagination chat.php
|    @author:      Nicolas Rasekgala
|    @date:        12 November 2016
|    @email        Nicolasrasekgala@gmail.com 
|                  
---------------------------------------------------------------------------------------------*/	

class DB_Functions {

    private $db;

    //put your code here
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
     * Storing new respond
     * returns respond details
     */
    public function storeRespond($respond, $patientNo, $doctorCode, $image) {
        // Insert respond into database
		$date = date("d-F-Y");
        $result = mysql_query("Insert into message(message, from_id, to_id, date, image)
                		Values('$respond', '$doctorCode', '$patientNo', '$date', '$image')");
		
        if ($result) {
			mysql_query("Insert into tblstatus(message_id) Values('$patientNo')");
			return true;
        } else {			
				// For other errors
				return false;
		}
    }
	 /**
     * Getting all patient respond
     */
    public function getAllRespond($id ,$doctor_code) {
        $result = mysql_query("select * FROM tblRespond where patient_id = '$id' AND doctor_code = '$doctor_code'");
        return $result;
    }

	
	/**
     * Getting all persons
     */
    public function getAllDoctors() {
        $result = mysql_query("select id_number,doctor_code, email  FROM tblPerson, tblDoctor where tblDoctor.person_id  = tblPerson.person_id");
        return $result;
    }
	
	/**
     * Getting all patient
     */
    public function getAllPatient() {
        $result = mysql_query("select id_number FROM  tblPatient;");
        return $result;
    }
	

}

?>
