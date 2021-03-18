<?php

Class YearendController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	echo "Yearend attenance tally total";
	// echo "<a href='' >Monthly</a>";
	// $data=NULL;$this->view->render($data,'abc/indexAbc');
}	/* fxn */


/* update summ.promlvl and summ.promcrid */
public function promotions(){
	$dbg=PDBG;$dbo=PDBO;$db=&$this->baseModel->db;		
	/* 1 */
	$q="UPDATE {$dbg}.05_summaries AS x 
		INNER JOIN (
			SELECT a.scid,a.crid,b.id AS ncrid,a.nxtlvl
			FROM (select 
					summ.scid,cr.id AS crid,cr.level_id AS lvl,cr.level_id+1 AS nxtlvl
				from {$dbg}.05_summaries AS summ
					left join {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
				where cr.`section_id` != '1') AS a	
			LEFT JOIN	
				(SELECT *,id AS ncrid,level_id AS nxtlvl FROM {$dbg}.05_classrooms WHERE section_id = '1' ) AS b
			ON b.level_id = a.nxtlvl
		) AS y ON x.scid = y.scid
		SET x.is_promoted=1,x.promcrid = y.ncrid,x.promlvl = y.nxtlvl;	
	";
	echo "?exe";
	pr($q);
	if(isset($_GET['exe'])){ $sth=$db->query($q);echo ($sth)? "Success":"Fail";	}
		
}	/* fxn */






}	/* BlankController */
