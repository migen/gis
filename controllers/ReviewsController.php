<?php

Class ReviewsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

/* 	
	$q="SELECT  a.id,a.name,
        MAX(CASE WHEN b.prop = 'price' THEN b.value ELSE NULL END) price,
        MAX(CASE WHEN b.prop = 'color' THEN b.value ELSE NULL END) color
	FROM    {$dbo}.products AS a
			LEFT JOIN {$dbo}.prodprop AS b
				ON a.id = b.prid
	GROUP BY a.id,a.name";
 */

public function index(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.reviews ORDER BY item;";
	$q="
		SELECT 
			id,
        MAX(CASE WHEN type_id='1' THEN item ELSE NULL END) AS dbu,
        MAX(CASE WHEN type_id='2' THEN item ELSE NULL END) AS task,			
		FROM {$dbo}.reviews;
		
	";
	
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	

	pr($data);
	
	// $this->view->render($data,'reviews/indexReviews');
}	/* fxn */




}	/* BlankController */
