<?php

namespace Model;

class Connection extends \PDO {
	
	public function __construct($dsn, $user = null , $password = null){
		
		try {
			parent::__construct($dsn, $user, $password);
		}
		catch(PDOException $e) {
			echo 'Connection failed' . $e->getMessage();
		}
	}
	
	/**
     * @param string $query
     * @param array  $parameters
     *
     * @return bool Returns `true` on success, `false` otherwise
     */
    public function executeQuery($query, array $parameters = [])
    {		
        $stmt = $this->prepare($query);

        foreach ($parameters as $name => $value) {
            $stmt->bindValue(':' . $name, $value);
        }
        
        return $stmt->execute();
    }
    
    /**
     * @param string $query
     * @param array  $parameters
     *
     * @return Statement
     */
    public function execute($query, array $parameters = [])
    {
        $stmt = $this->prepare($query);

        foreach ($parameters as $name => $value) {
            $stmt->bindValue(':' . $name, $value);
        }
        
        $stmt->execute();
        
        return $stmt;
    }
}
