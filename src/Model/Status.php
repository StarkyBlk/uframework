<?php

namespace Model;

class Status {
	
	/**
     * @var int
     */
	private $id;
	
	/**
     * @var string
     */
	private $user_id;
	
	/**
     * @var string
     */
	private $username;
	
	/**
     * @var string
     */
	private $message;
	
	/**
     * @var Date
     */
	private $date_post;
	
	/**
     * @var string
     */
	private $client;
	
	/**
	 * 
	 */
	public function __construct($message, \DateTime $date_post, $client, $username = null, $user_id = null, $id = null){
        $this->id = $id;
        $this->username = $username;
        $this->user_id = $user_id;
        $this->message = $message;
        $this->date_post = $date_post->format("Y-m-d H:i:s");
        $this->client = $client;
    }
    
    public function getId(){
		return $this->id;
	}
	
	public function getUserId(){
		return $this->user_id;
	}
	
	public function getUserName(){
		return $this->username;
	}
	
	public function getMessage(){
		return $this->message;
	}
	
	public function getDatePost(){
		return $this->date_post;
	}
	
	public function getClient(){
		return $this->client;
	}
}
