<?php


/* for before filter ACL this->only  */
public function url(){
	$params=$this->params();
	return isset($params['url'])?$params['url']:false;	
}	/* fxn */
