<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Address
 *
 * @author Rasekgala
 */
class Address {
    //put your code here
    private $address_id;
    private $street_name;
    private $city;
    private $postal_code;
    private $person_id;
    
    public function __construct($address_id, $street_name, $city, $postal_code, $person_id) {
        $this->address_id = $address_id;
        $this->street_name = $street_name;
        $this->city = $city;
        $this->postal_code = $postal_code;
        $this->person_id = $person_id;
    }

    public function getAddress_id() {
        return $this->address_id;
    }

    public function getStreet_name() {
        return $this->street_name;
    }

    public function getCity() {
        return $this->city;
    }

    public function getPostal_code() {
        return $this->postal_code;
    }

    public function getPerson_id() {
        return $this->person_id;
    }

    public function setAddress_id($address_id) {
        $this->address_id = $address_id;
    }

    public function setStreet_name($street_name) {
        $this->street_name = $street_name;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setPostal_code($postal_code) {
        $this->postal_code = $postal_code;
    }

    public function setPerson_id($person_id) {
        $this->person_id = $person_id;
    }


    
}
