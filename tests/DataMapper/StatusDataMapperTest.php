<?php

class StatusDataMapperTest extends TestCase
{
    private $con;

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
    }

	public function testPersist(){
        $mapper = new \Model\StatusMapper($this->con);
        $status = new Model\Status('dsfsdfs', new DateTime(date("Y-m-d H:i:s")), 'sdfsdf', null, null, '1');
        $this->assertTrue($mapper->persist($status));
	}
	
	public function testSelectAllEmpty(){
        $finder = new \Model\StatusFinder($this->con);
        $statuses = $finder->findAll();
        $this->assertEquals(0,count($statuses));
	}
	
	public function testSelectAllOneStatus(){
        $finder = new \Model\StatusFinder($this->con);
        $mapper = new \Model\StatusMapper($this->con);
        $status = new Model\Status('dsfsdfs', new DateTime(date("Y-m-d H:i:s")), 'sdfsdf', null, null, '1');
        $mapper->persist($status);
        $statuses = $finder->findAll();
        $this->assertEquals(1,count($statuses));
	}
}
