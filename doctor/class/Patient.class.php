<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Patient
 *
 * @author Rasekgala
 */
require_once 'Person.class.php';
 
class Patient extends Person{
    //put your code here
    private $_idNumber;
    private $fk_doctor_code;
    
    public function __construct($name, $surname, $email, $idNumber, $phone, $gender,  $fk_doctor_code, $person_id) {
        
        //defining psrent constructor of person
        parent::__construct($person_id,$name, $surname, $phone, $idNumber, $gender, $email);
        $this->_idNumber = $idNumber;
        $this->fk_doctor_code = $fk_doctor_code;
    }
    
    public function get_idNumber() {
        return $this->_idNumber;
    }

    public function getFk_doctor_code() {
        return $this->fk_doctor_code;
    }

    public function set_idNumber($_idNumber) {
        $this->_idNumber = $_idNumber;
    }

    public function setFk_doctor_code($fk_doctor_code) {
        $this->fk_doctor_code = $fk_doctor_code;
    }



}
