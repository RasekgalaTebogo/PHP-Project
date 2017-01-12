<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Person
 *
 * @author Rasekgala
 */
class Person {
    //put your code here
    private $person_id;
    private $name;
    private $surname;
    private $email;
    private $idNumber;
    private $phone;
    private $gender;
                
    function __construct($person_id, $name, $surname, $email, $idNumber, $phone, $gender)
    {
        $this->person_id = $person_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->idNumber = $idNumber;
        $this->gender = $gender;
        $this->email = $email; 
    }
                
    function __destruct()
    {
                    
    }
    
     public function setPerson_id($person_id)
    {
      $this->person_id = $person_id; 
    }
                
    public function getPerson_id() {
        return $this->person_id;
    }
    
    public function setName($name)
    {
      $this->name = $name; 
    }
                
    public function getName() {
        return $this->name;
    }
                
    public function setSurname($surname)
    {
        $this->surname = $surname; 
    }
                
    public function getSurname() {
         return $this->surname;
    }
                
     public function setPhone($phone)
     {
        $this->phone = $phone; 
     }
                
     public function getPhone() {
        return $this->phone;
     }
                
      public function setIdNumber($IdNumber)
      {
        $this->idNumber = $IdNumber; 
       }
                
       public function getIdNumber() {
            return $this->idNumber;
        }
                
      public function setGender($gender)
      {
        $this->gender = $gender; 
      }
                
       public function getGender() {
           return $this->gender;
        }
                
       public function setEmail($email)
       {
          $this->email = $email; 
       }
                
        public function getEmail() {
           return $this->email;
        }
    
}
