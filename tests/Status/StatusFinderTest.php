<?php

class StatusFinderTest extends TestCase
{
    private $con;
    private $finder;

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
INSERT INTO Users
VALUES(1,'toto','tata','2015-01-01 10:10:10');
INSERT INTO Statuses
VALUES(1,1,'cc','2015-01-01 10:10:10','Mozilla');
SQL
        );
        $this->finder = new \Model\StatusFinder($this->con);
    }
    
	public function testFindAllCount(){
        $statuses = $this->finder->findAll();
        $this->assertEquals(1,count($statuses));
	}
	
	public function testFindAll(){
		$expected = array(new \Model\Status('cc', new \DateTime('2015-01-01 10:10:10'), 'Mozilla', 'toto', '1', '1'));
        $statuses = $this->finder->findAll();
        $this->assertEquals($expected,$statuses);
	}
	
	public function testFindOneByIdCount(){
		$status = $this->finder->findOneById(1);
        $this->assertEquals(1,count($status));
	}
	
	public function testFindOneById(){
		$expected = new \Model\Status('cc', new \DateTime('2015-01-01 10:10:10'), 'Mozilla', 'toto', '1', '1');
		$status = $this->finder->findOneById(1);
        $this->assertEquals($expected, $status);
	}
	
	public function testFindAllByUserIdCount(){
        $statuses = $this->finder->findAllByUserId(1);
        $this->assertEquals(1,count($statuses));
	}
	
	public function testFindAllByUserId(){
		$expected = array(new \Model\Status('cc', new \DateTime('2015-01-01 10:10:10'), 'Mozilla', 'toto', '1', '1'));
        $statuses = $this->finder->findAllByUserId(1);
        $this->assertEquals($expected,$statuses);
	}
}

