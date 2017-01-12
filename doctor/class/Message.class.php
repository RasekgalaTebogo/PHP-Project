<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author Rasekgala
 */
class Message {
    //put your code here
    
    private $message_id;
    private $message;
    private $patient_id;
    private $image;
    private $status;
    private $doctor_code;
    private $date;


    public function __construct($message_id, $message, $patient_id, $image, $status, $doctor_code, $date) {
        $this->message_id = $message_id;
        $this->message = $message;
        $this->patient_id = $patient_id;
        $this->image = $image;
        $this->date = $date;
        $this->status = $status;
        $this->doctor_code = $doctor_code;
    }
    
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

        public function getMessage_id() {
        return $this->message_id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getPatient_id() {
        return $this->patient_id;
    }

    public function getImage() {
        return $this->image;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDoctor_code() {
        return $this->doctor_code;
    }

    public function setMessage_id($message_id) {
        $this->message_id = $message_id;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setPatient_id($patient_id) {
        $this->patient_id = $patient_id;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDoctor_code($doctor_code) {
        $this->doctor_code = $doctor_code;
    }



}
