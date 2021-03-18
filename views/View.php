<?php

class View{
public $message;
public function __construct(){
	echo "this is the View<br />";
}

public function render($viewfile){
	require(VIEWS.$viewfile);
}

public function message($message=NULL){
	return $this->message = "<p>$message</p>";
}

}

?>