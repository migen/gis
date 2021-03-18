<?php

class Router{ /* dispatcher */

	public static function route(Request $request){
		/* controller/method/params */
		$controller = $request->getController();				
		// pr($controller);
		$curl = strtolower($controller);
		/* model */
		$model = rtrim($controller,'s');			
		$mfile = SITE.'models'.DS.$model.'.php';			
		$first  = $controller;									/* in case url is a webpage not controller */		
		$controller = $controller.'Controller';					/* TxnsController */
		// pr($controller);

		$action = $request->getAction();						/* view */
		$params = $request->getParams();						/* 3 */
		
		$cfile = SITE.'controllers'.DS.$controller.'.php';				/* .../controllers/TxnsController.php */		
		if(is_readable($cfile)){
			require_once($cfile);			
			$controller = new $controller;			

			$controller->$model = $controller->loadModel($mfile,$model);
			$controller->model =& $controller->$model;
			/* $action = (is_callable(array($controller,$action)))? $action : 'index';	 */					
			$action = (is_callable(array($controller,$action)))? $action : null;						
			if(is_null($action)){ header("Location: ".URL.$curl.""); }			
			if(!empty($params)){
					call_user_func(array($controller,$action),$params);				
					/* call_user_func_array(array($controller,$action),$params);  */										
			} else {			
				call_user_func(array($controller,$action));
			}  
		} else {			
			$cfile = SITE.'controllers/WebpagesController.php';				
			require_once($cfile);			
			$mfile = SITE.'models/Webpage.php';					
			$controller = 'WebpagesController';
			$model 		= 'Webpage';
			$params 	= strtolower($first);			
			$controller = new $controller;						
			$class_methods = get_class_methods('controller');
			$action = 'read';			
			$controller->$model = $controller->loadModel($mfile,$model);
			call_user_func(array($controller,$action),$params);				
			
?>
		<h3><a href="<?php echo URL; ?>">Home</a></h3>
<?php
			return false;
		}				
	} /* routeFxn */
	


} /* Router */
