<?php

Class PivotsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}


public function index(){
	$db=&$this->baseModel->db;$dbo=PDBO;
/* two tables
1) pivots-id,name
2) pivotdetails-id,prid,propid,prop,value
*/
	
	
	$q="SELECT  a.id,a.name,
        MAX(CASE WHEN b.propid = '11' THEN b.value ELSE NULL END) AS `price`,
        MAX(CASE WHEN b.prop = 'color' THEN b.value ELSE NULL END) AS `color`
	FROM  {$dbo}.pivots AS a
	LEFT JOIN {$dbo}.pivotdetails AS b ON a.id = b.prid
	GROUP BY a.id,a.name";
	pr($q);	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	

	$this->view->render($data,'pivots/indexPivots');
	
}	/* fxn */




} 	/* Controller */
