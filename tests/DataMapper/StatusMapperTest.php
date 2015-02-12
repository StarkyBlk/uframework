<?php

namespace DataMapper;

use Model\StatusMapper;
use Model\Status;
use \DateTime;

class StatusMapperTest extends \TestCase{
	
	private $connection;
	private $mapper;
	
	public function setUp(){
		$this->connection = $this->getMock('DataMapper\MockConnection');
		$this->connection
			->expects($this->once())
			->method('executeQuery');
		
		$this->mapper = new StatusMapper($this->connection);
	}

	public function testPersist(){
		$status = new Status('test', new DateTime(date("Y-m-d H:i:s")), 'sdfsd' , null, null, null);
		$this->mapper->persist($status);
	}
	
	public function testRemove(){
		$status = new Status('test', new DateTime(date("Y-m-d H:i:s")), 'sdfsd' , null, null, null);
		$this->mapper->remove($status);
	}
}
