<?php

class Request{
	private $controller;private $model;private $action;private $params;
	public function __construct(){
		$parts=isset($_GET['url'])? rtrim($_GET['url'],'/') : 'index'; 
		$parts=explode('/',$parts);		
		$c=($c=array_shift($parts))? $c:'index'; 			
		$ucc=ucfirst($c);										 
		$this->controller=$ucc;			
		$this->action=($a=array_shift($parts))? $a : 'index';						
		$this->params=$parts;		
	}
	
	/* getController,getAction,getParams are fxns in Router class */
	function getController(){ return $this->controller; }
	function getAction(){ return $this->action; }	
	function getParams(){ return $this->params; }
	
} 	/* Request */

// ----- router below --------------

class Router{ /* dispatcher */

	public static function route(Request $request){
		$controller=$request->getController();				
		$curl=strtolower($controller);
		$model=rtrim($controller,'s');			
		$mfile=SITE.'models'.DS.$model.'.php';			
		$first=$controller;								
		$controller=$controller.'Controller';
		$action=$request->getAction();						
		$params=$request->getParams();								
		$cfile = SITE.'controllers'.DS.$controller.'.php'; 
		if(is_readable($cfile)){
			require_once($cfile);			
			$controller=new $controller;			
			$controller->$model=$controller->loadModel($mfile,$model);
			$controller->model=&$controller->$model;
			$action=(is_callable(array($controller,$action)))? $action : null;						
			if(is_null($action)){ header("Location: ".URL.$curl.""); }			
			if(!empty($params)){ call_user_func(array($controller,$action),$params);				
			} else { call_user_func(array($controller,$action)); }  
		} else {	
			$message="Rerouter - NOT readable cfile: ".$cfile;
			flashRedirect("lounge",$message);
		
			
?>
		<h3><a href="<?php echo URL; ?>">Home</a></h3>
<?php
			return false;
		}				
	} /* routeFxn */
	

} /* Router */
