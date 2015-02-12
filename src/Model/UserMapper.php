<?php

namespace Model;

class UserMapper{
	private $connection;
	
	public function __construct(Connection $connection){
        $this->connection = $connection;
    }

    public function persist(User $user){
		$parameters = array('username' => $user->getUserName(),
							'password' => $user->getPassword(),
							'date_register' => $user->getDateRegister(),
							);
							
		$query = "INSERT INTO Users(username,password,date_register) values(:username,:password,:date_register)";
		return $this->connection->executeQuery($query, $parameters);

    }

    public function remove(User $user){
        $query = "DELETE FROM Users where id=:id";
        return $this->connection->executeQuery($query, array("id" => $user->getId()));
    }
}
