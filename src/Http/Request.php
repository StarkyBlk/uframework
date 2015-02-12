<?php

namespace Http;

class Request
{
	const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';
    
	private $parameters;
    
    function __construct(array $query = array(), array $request = array()){
		$this->parameters = array_merge($query,$request);
	}
    
    public function getParameter($name, $default = null){
		if(isset($this->parameters[$name])){
			return $this->parameters[$name];
		}
		return $default;
	}
	
    public function getMethod(){
		$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : self::GET;
		
		if (self::POST === $method) {
			return $this->getParameter('_method', $method);
		}
		return $method;
	}
	
	public function getUri(){
		$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
		
		if ($pos = strpos($uri, '?')) {
			$uri = substr($uri, 0, $pos);
		}
		
		return $uri;
	}
	
	public static function createFromGlobals(){
		if(isset($_SERVER['HTTP_CONTENT_TYPE'])){
			$content_type_args = explode(';', $_SERVER['HTTP_CONTENT_TYPE']);
			if($content_type_args[0] == "application/json"){
				$data    = file_get_contents('php://input');
				$request = @json_decode($data, true);
				return new self($_GET,$request);
			}
		}
		if(isset($_SERVER['CONTENT_TYPE'])){
			$content_type_args = explode(';', $_SERVER['CONTENT_TYPE']);
			if($content_type_args[0] == "application/json"){
				$data    = file_get_contents('php://input');
				$request = @json_decode($data, true);
				return new self($_GET,$request);
			}	
		}
		return new self($_GET,$_POST);
	}
	
	public function guessBestFormat(){
		$negotiator   = new \Negotiation\FormatNegotiator();
		$acceptHeader = $_SERVER['HTTP_ACCEPT'];

		return $negotiator->getBestFormat($acceptHeader);
	}
}
