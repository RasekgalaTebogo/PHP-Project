<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Doctor
 *
 * @author Rasekgala
 */
 include_once 'class/Person.class.php';
 
class Doctor extends Person {
    //put your code here
    
    //data members
    private $specialty;
    private $doctor_code;
    private $doctor_id;
    
    function __construct($name, $surname, $email, $idNumber, $phone, $gender, $doctor_code, $specialty, $doctor_id, $person_id)
    {
		
        //defining parent constructor of person
        parent::__construct($person_id, $name, $surname , $email, $idNumber, $phone, $gender);
        $this->doctor_code = $doctor_code;
        $this->doctor_id = $doctor_id;
        $this->specialty = $specialty;
        
    }    
    
    public function getSpecialty() {
        return $this->specialty;
    }

    public function getDoctor_code() {
        return $this->doctor_code;
    }

    public function getDoctor_id() {
        return $this->doctor_id;
    }

    public function setSpecialty($specialty) {
        $this->specialty = $specialty;
    }

    public function setDoctor_code($doctor_code) {
        $this->doctor_code = $doctor_code;
    }

    public function setDoctor_id($doctor_id) {
        $this->doctor_id = $doctor_id;
    }


}
