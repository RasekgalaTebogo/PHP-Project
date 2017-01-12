<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Rasekgala
 */
class Login {
    
    //put your code here
    private $login_id;
    private $password;
    private  $username;
    private $role;
    private $person_id;
	private $status;
    
    public function __construct($login_id, $password, $username, $role, $person_id, $status) {
        
        $this->login_id = $login_id;
        $this->password = $password;
        $this->username = $username;
        $this->role = $role;
        $this->person_id = $person_id;
		$this->status =  $status;
    }

    public function getLogin_id() {
        return $this->login_id;
    }
	public function getStatus() {
        return $this->status;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getRole() {
        return $this->role;
    }

    public function getPerson_id() {
        return $this->person_id;
    }

    public function setLogin_id($login_id) {
        $this->login_id = $login_id;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setPerson_id($person_id) {
        $this->person_id = $person_id;
    }
	public function setStatus($status) {
        $this->status = $status;
    }


    
}
