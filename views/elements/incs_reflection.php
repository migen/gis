<?php

$controller=$data['controller'];
require_once(SITE."functions/reflections.php");	
$dr=reflectMethods($controller);
$data['methods']=$dr['methods'];
$data['num_methods']=$dr['count'];
$data['class']=$dr['class'];
