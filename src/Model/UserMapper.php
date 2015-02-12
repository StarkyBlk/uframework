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
		if( $this->connection->executeQuery($query, $parameters) !== null  ){ 
			return new User($user->getUserName(), $user->getPassword(), new \DateTime($user->getDateRegister()), $this->connection->lastInsertId() );
		}
		return null;
    }

    public function remove(User $user){
        $query = "DELETE FROM Users where id=:id";
        return $this->connection->executeQuery($query, array("id" => $user->getId()));
    }
}
