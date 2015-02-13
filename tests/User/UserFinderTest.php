<?php

class UserFinderTest extends TestCase
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
SQL
        );
        $this->finder = new \Model\UserFinder($this->con);
    }
    
	public function testFindAllCount(){
        $users = $this->finder->findAll();
        $this->assertEquals(1,count($users));
	}
	
	public function testFindAll(){
		$expected = array( new Model\User('toto','tata',new \DateTime('2015-01-01 10:10:10'), '1'));
        $users = $this->finder->findAll();
        $this->assertEquals($expected,$users);
	}
	
	public function testFindOneByIdCount(){
		$user = $this->finder->findOneById(1);
        $this->assertEquals(1,count($user));
	}
	
	public function testFindOneById(){
		$expected = new Model\User('toto','tata',new \DateTime('2015-01-01 10:10:10'), '1');
		$user = $this->finder->findOneById(1);
        $this->assertEquals($expected, $user);
	}
	
	public function testFindOneByUserNameCount(){
        $user = $this->finder->findOneByUserName('toto');
        $this->assertEquals(1,count($user));
	}
	
	public function testFindOneByUserName(){
		$expected = new Model\User('toto','tata',new \DateTime('2015-01-01 10:10:10'), '1');
        $user = $this->finder->findOneByUserName('toto');
        $this->assertEquals($expected,$user);
	}
}


