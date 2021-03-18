<?php

class Request{
	private $controller;private $model;private $action;private $params;
	public function __construct(){
		$parts = isset($_GET['url'])? rtrim($_GET['url'],'/') : 'index'; 
		$parts = explode('/',$parts);		
		$c = ($c = array_shift($parts))? $c : 'index'; 			
		$ucc = ucfirst($c);										 
		$this->controller = $ucc;			
		$this->action = ($a = array_shift($parts))? $a : 'index';						
		$this->params = $parts;		
	}
	
	/* getController,getAction,getParams are fxns in Router class */
	function getController(){ return $this->controller; }
	function getAction(){ return $this->action; }	
	function getParams(){ return $this->params; }
	
} 	/* Request */

