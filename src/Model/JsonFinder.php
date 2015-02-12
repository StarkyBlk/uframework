<?php

namespace Model;

class JsonFinder implements FinderInterface{

	private $jsonFic;
	private $statuses;
	private $id;
	
	function __construct(){
		$this->jsonFic = __DIR__ . '/../../data/statuses.json';
		$this->statuses = [];
		$this->id=0;
		
		if(is_file($this->jsonFic)){
			$jsonStatuses = file_get_contents($this->jsonFic);
			$statuses = json_decode($jsonStatuses,true);
			$this->statuses = $statuses;
		}
		
		if(!empty($this->statuses)){
			foreach($this->statuses as $status){
				if($status['id']>$this->id){
					$this->id=$status['id'];
				}
			}
		}
	}
	
	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll(){
		return $this->statuses;
	}

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id){	
		foreach($this->statuses as $status){
			if($status['id'] == $id){
				return $status;
			}
		}
		return null;
	}
	
	public function insert($username, $message){	
		$this->id++;
		
		$status['id']=$this->id;
		$status['username'] = $username;
		$status['message'] = $message;
		
		array_push($this->statuses, $status);
		
		$jsonStatuses = json_encode($this->statuses);
		file_put_contents($this->jsonFic, $jsonStatuses);
	}
	
	public function delete($id){
		foreach($this->statuses as $key => $status){
			if($status['id'] == $id){
				unset($this->statuses[$key]);
			}
		}
		$jsonStatuses = json_encode($this->statuses);
		file_put_contents($this->jsonFic, $jsonStatuses);
	}
    
}
