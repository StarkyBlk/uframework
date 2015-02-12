<?php

namespace Model;

class UserFinder implements FinderInterface{
	
	private $connection;
	
	public function __construct($connection){
		$this->connection = $connection;
	}
	
	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll($limit = FinderInterface::LIMIT, $offset = FinderInterface::OFFSET){
		$users = [];
		$query = "SELECT * FROM users order by date_register DESC LIMIT ". $offset . ", " . $limit;
		$results = $this->connection->execute($query);
		$results = $results->fetchAll(\PDO::FETCH_ASSOC);
		
		if(!empty($results)){
			foreach($results as $user){
				array_push($users, new User($user['username'], $user['password'], new \DateTime($user['date_register']), $user['id']));
			}
		}	
		return $users;
	}

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id){
		$user=null;
		$query = "SELECT * FROM Users where id=:id";
		$results = $this->connection->execute($query, array("id" => $id));
		$results = $results->fetchAll(\PDO::FETCH_ASSOC);
		
		if(!empty($results)){
			$user = new Status($results[0]['username'], $results[0]['password'], new \DateTime($results[0]['date_creation']), $results[0]['id']);
		}
		return $user;
	}
	
	/**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneByUserNamePassword($username, $password){
		$user=null;
		$query = "SELECT * FROM Users where username=:username";
		$results = $this->connection->execute($query, array("username" => $username));
		$results = $results->fetchAll(\PDO::FETCH_ASSOC);
		
		if(!empty($results)){
			if(password_verify($password, $results[0]['password'])){
				$user = new User($results[0]['username'], $results[0]['password'], new \DateTime($results[0]['date_creation']), $results[0]['id']);
			}
		}
		return $user;
	}
}

