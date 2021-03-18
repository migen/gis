<?php

Class CopierController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$data=NULL;
	$this->view->render($data,'copier/indexCopier');

}	/* fxn */

public function crs($params=NULL){
$data['crs']=$crs=$params[0];
$db=&$this->baseModel->db;
$dbg=PDBG;$dbo=PDBO;

$q="SELECT crs.crid FROM {$dbg}.05_courses AS crs WHERE crs.id='$crs' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['cr']=$cr=$sth->fetch();
$data['crid']=$crid=$cr['crid'];

if(isset($_POST['submit'])){
	$src=$_POST['src'];
	$dest=$_POST['dest'];	
	/* 1 - grades */
	$q="UPDATE {$dbg}.50_grades SET `q{$dest}`=`q{$src}`,`dg{$dest}`=`dg{$src}` WHERE course_id='$crs'; " ;
	$db->query($q);
	flashRedirect("copier/crs/$crs","Copied.");
	exit;
	
	/* 2 - if conduct, update summaries too */
	
	
}	/* post */

$order=$_SESSION['settings']['classlist_order'];
$q="SELECT g.id AS gid,g.*,c.code AS studcode,c.name AS student
FROM {$dbg}.50_grades AS g 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=g.scid
INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
WHERE summ.crid='$crid' AND g.course_id='$crs' AND c.is_active=1
ORDER BY $order; ";
// pr($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$this->view->render($data,'copier/crsCopier');


}	/* fxn */




}	/* BlankController */
