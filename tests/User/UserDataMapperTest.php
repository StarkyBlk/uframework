<?php

class UserDataMapperTest extends TestCase
{
    private $con;
    private $mapper;

    public function setUp(){
        $this->con = new \Model\Connection('sqlite::memory:');
        $this->con->exec(<<<SQL
CREATE TABLE IF NOT EXISTS Users(
	id INT PRIMARY KEY,
	username VARCHAR(30) UNIQUE NOT NULL,
	password VARCHAR(100) NOT NULL,
	date_register DATETIME NOT NULL
);
CREATE TABLE IF NOT EXISTS Statuses(
	id INT,
	user_id INT,
	message VARCHAR(140),
	date_post DATETIME NOT NULL,
	client VARCHAR(100) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES Users(id)
);
SQL
        );
        $this->mapper = new \Model\UserMapper($this->con);
    }

	public function testPersist(){
        $user = new Model\User('toto','tata',new \DateTime('2015-01-01 10:10:10'));
        $this->assertTrue($this->mapper->persist($user));
	}
	
	public function testRemove(){
        $user = new Model\User('toto','tata',new \DateTime('2015-01-01 10:10:10'));
		$this->mapper->persist($user);
		$this->assertTrue($this->mapper->remove($user));
		
	}
}

