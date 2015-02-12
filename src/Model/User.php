<?php

namespace Model;

class User{
	private $id;
	
	private $userName;
	
	private $password;
	
	private $dateRegister;
	
	public function __construct($userName, $password, \DateTime $dateRegister, $id=null){
		$this->userName = $userName;
		$this->password = $password;
		$this->dateRegister = $dateRegister->format('Y-d-m H:i:s');
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getUserName(){
		return $this->userName;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function getDateRegister(){
		return $this->dateRegister;
	}
}
