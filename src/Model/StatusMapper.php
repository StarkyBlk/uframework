<?php

namespace Model;

class StatusMapper{
	
	private $connection;
	
	public function __construct(Connection $connection){
        $this->connection = $connection;
    }

    public function persist(Status $status){
		$parameters = array('user_id' => $status->getUserId(),
							'message' => $status->getMessage(),
							'date_post' => $status->getDatePost(),
							'client' => $status->getClient(),
							);
							
		$query = "INSERT INTO Statuses(user_id,message,date_post,client) values(:user_id,:message,:date_post,:client)";
		return $this->connection->executeQuery($query, $parameters);
    }

    public function remove(Status $status){
        $query = "DELETE FROM Statuses where id=:id";
        return $this->connection->executeQuery($query, array("id" => $status->getId()));
    }
}
