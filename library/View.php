<?php

class View{
public $js;
public $css;

public function __construct(){}

public function render($data = null,$template='pages/index',$layout_default=NULL){	
	$layout=isset($this->layout)? $this->layout:LAYOUT;
	$layout=isset($layout_default)? $layout_default:$layout;	
	if(is_array($data)){ extract($data); }			
	if (is_null($layout)) {
		include_once(SITE.'views/'.$template.'.php');
	} else {		
		include_once(SITE.'views'.DS.'layouts'.DS.$layout.'.php');		
	}
	exit;
}

public function shovel($file=null,$data=null){
	include(SITE.'views/elements/'.$file.'.php');
}


} 	/* View */