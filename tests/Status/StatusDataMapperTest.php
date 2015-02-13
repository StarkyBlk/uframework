<?php

class StatusDataMapperTest extends TestCase
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
        $this->mapper = new \Model\StatusMapper($this->con);
    }

	public function testPersist(){
        $status = new Model\Status('dsfsdfs', new DateTime(date("Y-m-d H:i:s")), 'sdfsdf', null, null, '1');
        $this->assertTrue($this->mapper->persist($status));
	}
	
	public function testRemove(){
        $status = new Model\Status('dsfsdfs', new DateTime(date("Y-m-d H:i:s")), 'sdfsdf', null, null, '1');
		$this->mapper->persist($status);
		$this->assertTrue($this->mapper->remove($status));
		
	}
}
