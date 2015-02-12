<?php

namespace Model;

class Connection extends \PDO {
	
	public function __construct(){
		
		$dbname = 'uframework';
		$host = 'localhost';
		$user = 'uframework';
		$password = 'passw0rd';
		$dsn = 'mysql:dbname=' . $dbname . ';host=' . $host;
		
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
        
        if($stmt->execute() < 1){
			return null;
		}
        
        return $stmt;
    }
}
