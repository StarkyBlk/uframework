<?php

class StatusDataMapperTest extends TestCase
{
    private $con;

    public function setUp(){
        $this->con = new \Model\Connection('sqlite::memory:');
        $this->con->exec(<<<SQL
CREATE TABLE IF NOT EXISTS Users(
	id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(30) UNIQUE NOT NULL,
	password VARCHAR(100) NOT NULL,
	date_register DATETIME NOT NULL
) ENGINE = MYISAM CHARACTER SET = utf8;
CREATE TABLE IF NOT EXISTS Statuses(
	id INT AUTO_INCREMENT,
	user_id VARCHAR(30),
	message VARCHAR(140),
	date_post DATETIME NOT NULL,
	client VARCHAR(100) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES Users(id)
) ENGINE = MYISAM CHARACTER SET = utf8;
SQL
        );
    }

    public function testPersist(){
        $mapper = new \Model\StatusMapper($this->con);
        $status = new Model\Status('dsfsdfs', new DateTime(date("Y-m-d H:i:s")), 'sdfsdf', null, null, null);
        $this->assertTrue($mapper->persist($status));
        //$this->assertTrue(true);
	}
}
