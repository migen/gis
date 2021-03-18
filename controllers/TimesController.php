<?php

Class TimesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	

	$a=8;
	echo "a: $a <br />";
	echo (is_integer($a))? "is integer":"NOT integer";echo "<br />";
	$format="%02d:%02d:%02d";
	echo sprintf($format,$a,0,0);
	
	$data="ABC";$this->view->render($data,'abc/defaultAbc');
	
	
}	/* fxn */


public function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

echo convertToHoursMins(250, '%02d hours %02d minutes'); 










}	/* BlankController */
