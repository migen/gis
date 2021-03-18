<?php

Class TurnoverController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 	
	$data=NULL;
	$this->view->render($data,'turnover/index');

}	/* fxn */


public function attd(){
$dbo=PDBO;
$vfile=($_SESSION['settings']['attd_qtr']==1)? 'turnover/attd':'turnover/attdQtr';
$vfile=isset($_GET['qtr'])? 'turnover/attdQtr':'turnover/attd';
$limits=isset($_GET['limit'])? 'LIMIT '.$_GET['limit']:NULL;
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$data['prevsy']=$prevsy=($sy-1);


$db=&$this->model->db;
$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

$q="
	SELECT c.id AS scid,c.name AS student,c.code AS studcode,a.*,cr.name AS classroom
	FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_attendance AS a ON summ.scid=a.scid
	WHERE cr.section_id>2
	ORDER BY cr.level_id,cr.section_id,c.name $limits;		
";
pr($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$this->view->render($data,$vfile);


}	/* fxn */




}	/* BlankController */
