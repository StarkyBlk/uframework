<?php

namespace Model;

class StatusFinder implements FinderInterface{
	
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
		$statuses = [];
		$query = "SELECT s.id, s.user_id, u.username, s.message, s.date_post, s.client FROM Statuses AS s LEFT JOIN Users AS u on s.user_id = u.id ORDER BY s.date_post DESC LIMIT ". $offset . ", " . $limit;
		$results = $this->connection->execute($query);
		$results = $results->fetchAll(\PDO::FETCH_ASSOC);
		
		if(!empty($results)){
			foreach($results as $status){
				array_push($statuses, new Status($status['message'], new \DateTime($status['date_post']), $status['client'], $status['username'] === null ? 'Anonymous' : $status['username'], $status['user_id'], $status['id']));
			}
		}	
		return $statuses;
	}

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id){
		$status=null;
		$query = "SELECT s.id, s.user_id, u.username, s.message, s.date_post, s.client FROM Statuses AS s LEFT JOIN Users AS u on s.user_id = u.id WHERE s.id=:id";
		$results = $this->connection->execute($query, array("id" => $id));
		$results = $results->fetchAll(\PDO::FETCH_ASSOC);
		
		if(!empty($results)){
			$status = new Status($results[0]['message'], new \DateTime($results[0]['date_post']), $results[0]['client'], $results[0]['username'] === null ? 'Anonymous' : $results[0]['username'], $results[0]['user_id'], $results[0]['id']);
		}
		return $status;
	}
	
	/**
     * Returns all elements from an user.
     *
     * @return array
     */
    public function findAllByUserId($id ,$limit = FinderInterface::LIMIT, $offset = FinderInterface::OFFSET){
		$statuses = [];
		$query = "SELECT s.id, s.user_id, u.username, s.message, s.date_post, s.client FROM Statuses AS s LEFT JOIN Users AS u on s.user_id = u.id WHERE s.user_id=:id ORDER BY s.date_post DESC LIMIT ". $offset . ", " . $limit;
		$results = $this->connection->execute($query, array("id" => $id));
		$results = $results->fetchAll(\PDO::FETCH_ASSOC);
		
		if(!empty($results)){
			foreach($results as $status){
				array_push($statuses, new Status($status['message'], new \DateTime($status['date_post']), $status['client'], $status['username'] === null ? 'Anonymous' : $status['username'], $status['user_id'], $status['id']));
			}
		}	
		return $statuses;
	}
}
