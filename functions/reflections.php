<?php



function reflectMethods($class){
    $reflector 		= new ReflectionClass($class);
    $methods 		= array();
    $lc_class		= strtolower($class);
    foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if (strtolower($method->class) == $lc_class) {
            $methods[] = $method->name;
        }
    }
	$data['class']=$class;
	$data['methods']=$methods;
	$data['count']=count($methods);
	$data['controller']=$reflector;
	return $data;

}	/* fxn */

