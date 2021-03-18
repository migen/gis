<?php

Class LoungeController extends Controller{	

public function __construct(){
	parent::__construct();		

	
}

public function beforeFilter(){

}

public function index(){	

	$vfile="abc/defaultAbc";
	$data="Lounge";$this->view->render($data,$vfile);
	
}	/* fxn */



public function student(){	
	$sch=(isset($_GET['sch']))? $_GET['sch']:VCFOLDER;
	$one="loungeStudent_{$sch}";$two="lounge/studentLounge";
	$vfile=cview($one,$two,$sch);vfile($vfile);		
	$data=isset($data)? $data:NULL;
	$this->view->render($data,$vfile);
}




}	/* BlankController */
