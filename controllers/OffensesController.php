<?php

Class OffensesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}

public function index(){	
	
	echo "Offenses";
		
	$this->view->render(NULL,'abc/index');
	


}	/* fxn */


public function records($params){
$dbo=PDBO;
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$dbg=PDBG;$dbo=PDBO;$data['db']=$db=&$this->model->db;
$sch=VCFOLDER;
if(isset($_POST['submit'])){
	$posts=$_POST['posts'];	
	foreach($posts AS $post){
		$scid=$post['scid'];
		unset($post['scid']);
		$db->update("{$dbg}.`50_offenses_{$sch}`",$post,"`scid`='$scid'");
	}
	$url="offenses/records/$crid";
	flashRedirect($url,"Saved.");
	exit;
}	/* post */

if($qtr==1){
	require_once(SITE.'functions/classlist.php');
	require_once(SITE.'functions/offensesFxn.php');
	$classlist_order=$_SESSION['settings']['classlist_order'];
	$a=getClasslistSimple($db,$dbg,$crid,$classlist_order);
	$ar=buildArray($a,'scid');
	$b=getOffensesClasslist($db,$dbg,$crid,$classlist_order);
	$br=buildArray($b,'scid');
	$ix=array_diff($ar,$br);
	if(!empty($ix)){ 
		syncOffensesByClassroom($db,$dbg,$crid);	
		echo "<h3 class='red' ><a href='".URL."offenses/records/".$crid."' >Refresh</a></h3>"; 
	}	/* sync */
}	/* qtr==1 */

$vfile="offenses/recordsOffenses";vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */


public function editStudentOffense($params){
$data['scid']=$scid=$params[0];
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$dbg=PDBG;$dbo=PDBO;$data['db']=$db=&$this->model->db;$sch=VCFOLDER;

if(isset($_POST['submit'])){
	$post=$_POST;
	unset($post['submit']);
	$db->update("{$dbg}.50_offenses_{$sch}",$post,"`scid`='$scid'");
	flashRedirect("offenses/editStudentOffense/$scid","Saved.");
}	/* post */

$q="SELECT summ.scid,c.name,o.*
	FROM {$dbg}.`50_offenses_{$sch}` AS o
	LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=o.scid
	LEFT JOIN {$dbg}.`05_summaries` AS summ ON c.id=summ.scid
	WHERE summ.scid='$scid' ; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
	
$this->view->render($data,'offenses/editStudentOffense');	
	

}	/* fxn */



public function sync($params){
$dbo=PDBO;
	require_once(SITE.'functions/classlist.php');
	require_once(SITE.'functions/offensesFxn.php');
	$db=&$this->baseModel->db;$dbg=PDBG;	
	$crid=$params[0];
	syncOffensesByClassroom($db,$dbg,$crid);	
}	/* fxn */




}	/* BlankController */
