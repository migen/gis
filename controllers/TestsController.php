<?php

Class TestsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	
	$this->view->render($data,'tests/indexTests');

}	/* fxn */


public function tc($params=NULL){
	$ucid = isset($params[0])? $params[0]:$_SESSION['ucid'];
	$data['user'] = $this->model->fetchRow(PDBO.'.`00_contacts`',$ucid); 
	pr($data);
}	/* fxn */


public function xls(){
	$this->view->render($data=NULL,'teachers/xls');
}





public function user(){
	$data=NULL;
	$this->view->render($data,'tests/user');
}	/* fxn */


public function trp(){
	// $data=NULL;
	$data['titles']=$_SESSION['titles'];
	$this->view->render($data,'tests/trp');
}	/* fxn */



public function contact(){
	$data=NULL;
	$this->view->render($data,'tests/contact');
}	/* fxn */



public function cxn(){
	echo "See tests/union or cxn or connection of db tables.";
	echo "<br /><a href='".URL."tests/union' >Union</a>";
	
}	/* fxn */

public function union(){
	echo "Union Connection of databases.";			
	// $q="SELECT '111aaa' AS nfield,a.* FROM 2011_aaa.logs AS a;";	// ok	
	// $q="SELECT '2011_aaa' AS dbname, a.* FROM 2011_aaa.logs AS a;";	// ok	
	// $q="SELECT id+1 AS newid, a.* FROM 2011_aaa.logs AS a;";		// ok	
	// $q="SELECT (id+3) AS id, logs FROM 2011_aaa.logs;";		// ok	
	// $q="SELECT '111' AS xname,logs FROM 2011_aaa.logs;";		// ok	
	// $q="SELECT '2011_aaa' AS dbname,logs FROM 2011_aaa.logs;";		// ok	
	// $q="SELECT '2011_aaa' AS dbname,a.id,a.logs FROM 2011_aaa.logs AS a;";		// ok	
	// $q="SELECT '2011_aaa' AS dbname,a.* FROM 2011_aaa.logs AS a;";		// ok	
	// $q="SELECT * FROM 2011_aaa.logs UNION (SELECT * FROM 2012_aaa.logs);";		// ok
	// $q="SELECT a.* FROM 2011_aaa.logs AS a UNION (SELECT (b.id+3) AS id,b.logs FROM 2012_aaa.logs AS b);";	// ok	
	// $q="SELECT a.* FROM 2011_aaa.logs AS a UNION (SELECT (b.id+3) AS id,b.logs FROM 2012_aaa.logs AS b);";	// ok		
		
	$q="SELECT '2011_aaa' AS dbname,a.* FROM 2011_aaa.logs AS a 
		UNION (SELECT '2012_aaa' AS dbname,b.* FROM 2012_aaa.logs AS b);";	

	pr($q);
	$db=&$this->model->db;
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=count($rows);
	// pr($rows);
	$this->view->render($data,'tests/union');
	
}	/* fxn */


public function editUnion($params){
$id=$params[0];
$dbname=$_GET['dbname'];
$db=&$this->model->db;

$q="SELECT * FROM {$dbname}.logs WHERE id='$id' LIMIT 1;";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();

if(isset($_POST['submit'])){
	$q="UPDATE {$dbname}.logs SET `log`='".$_POST['log']."' WHERE id='$id' LIMIT 1;";
	$db->query($q);
	$url='tests/union';
	redirect($url);
	exit;	
}

$this->view->render($data,'tests/editUnion');


}	/* fxn */


public function tabEnter(){

	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.`05_crstypes`; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'tests/ctypesTests');


} 	/* fxn */


public function enum(){	
	// dbo.00_works = id,work,status_id
	// dbo.00_status = id,name,type
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT w.*,s.name AS status,s.type
		FROM {$dbo}.`00_works` AS w  
		INNER JOIN {$dbo}.`00_statuses` AS s ON s.id=w.status_id
		WHERE s.type='work'; ";
	pr($q);
	$sth=$db->querysoc($q);
	$data['work_rows']=$sth->fetchAll();
	$data['work_count']=$sth->rowCount();

	/* 2 */
	$q="SELECT w.*,s.name AS status,s.type
		FROM {$dbo}.`00_works` AS w  
		INNER JOIN {$dbo}.`00_statuses` AS s ON s.id=w.status_id
		WHERE s.type='student'; ";
	pr($q);
	$sth=$db->querysoc($q);
	$data['student_rows']=$sth->fetchAll();
	$data['student_count']=$sth->rowCount();

	
	$this->view->render($data,"mis/worksMis");
}	/* fxn */






public function levelCrid($params){
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['prevsy']=$prevsy=($sy-1);
	$data['nextsy']=$nextsy=($sy+1);
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$pdbg=VCPREFIX.$prevsy.US.DBG;
	$ndbg=VCPREFIX.$nextsy.US.DBG;
			
	$q="SELECT id,name FROM {$dbo}.05_levels WHERE id=$lvl LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['level']=$sth->fetch();
	
	if(isset($_GET['toPrevcrid'])){
		$q="UPDATE {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			SET summ.prevcrid=summ.crid,summ.crid=0 WHERE cr.level_id=$lvl;			
		";
		pr($q);
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";		
	}	/* toPrevcrid */

	if(isset($_GET['backToCrid'])){
		$q="UPDATE {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.prevcrid=cr.id
			SET summ.crid=summ.prevcrid,summ.prevcrid=0 WHERE cr.level_id=$lvl;			
		";
		pr($q);
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";		
	}	/* toPrevcrid */

	
	$q="SELECT
			p.birthdate,ctp.ctp,
			c.id AS scid,c.code AS studcode,c.name AS studname,
			summ.crid AS summcrid,cr.level_id AS summlvl,
			summ.promlvl,summ.promcrid,
			summ.prevcrid,summ.id AS summid,en.crid AS encrid,
			psum.crid AS psumcrid,pcr.level_id AS psumlvl";
	if(isset($_GET['nextsy'])){
			$q.=",nsum.crid AS nsumcrid,ncr.level_id AS nsumlvl";		
	}		
	$q.=" FROM {$dbo}.00_contacts AS c 
		LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		LEFT JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id
		LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=c.id)

		LEFT JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id
		LEFT JOIN {$pdbg}.05_classrooms AS pcr ON psum.crid=pcr.id
		
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id";
		
	if(isset($_GET['nextsy'])){
		$q.=" LEFT JOIN {$ndbg}.05_summaries AS nsum ON nsum.scid=c.id
		LEFT JOIN {$ndbg}.05_classrooms AS ncr ON nsum.crid=ncr.id";
	}		
		$q.=" WHERE cr.level_id=$lvl OR pcr.level_id=$lvl ORDER BY cr.section_id;
	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	// levels links
	$data['levels']=$_SESSION['levels'];
	
	
	$this->view->render($data,"tests/levelCridTests");
	
	
}	/* fxn */




public function ledger($params=NULL){	// tuition assessment and other fees
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['ucid']=$_SESSION['ucid'];
	$sy=isset($params[1])? $params[1]:$_SESSION['year'];
	$sy=isset($_GET['sy'])? $_GET['sy']:$sy;	
	$data['sy']=$sy;$sch=VCFOLDER;
	$data['today']=$_SESSION['today'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
		
	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0));
	$this->permit($acl);				
	include_once(SITE.'views/elements/dbsch.php');

	
	if($scid){
		include_once(SITE.'functions/syncFxn.php');		
		include_once(SITE.'functions/enrollmentFxn.php');
		
		$data['student']=scidAssessment($db,$sy,$scid,$fields=NULL);		
		$data['payables']=scidPayables($db,$sy,$scid,$fields=NULL);
		$data['payments']=scidPayments($db,$sy,$scid,$fields=NULL);
		$data['student']['total_discount']=scidTotalDiscount($db,$sy,$scid);
		
		
	}	/* scid */
	
	if(!isset($_SESSION['paytypes'])){ $_SESSION['paytypes']=fetchRows($db,"{$dbo}.03_paytypes","id,code,name",$order="id"); }
	$data['paytypes']=$_SESSION['paytypes'];

	$data['lvl']=($scid)? $data['student']['level_id']:4;
	// $vfile="enrollment/ledgerEnrollment";
	$sch=VCFOLDER;$one="xxxledgerEnrollment_{$sch}";$two="tests/ledgerTests";
	$vfile=cview($one,$two,$sch);vfile($vfile);	
	$this->view->render($data,$vfile);	
	
	
}	/* fxn */


public function links($params=NULL){
	$data['scid']=isset($params[0])? $params[0]:false;
	$data['sy']=DBYR;
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"tests/linksTests");
}	/* fxn */


public function encrid($params=NULL){
	$data['scid']=isset($params[0])? $params[0]:false;
	$data['sy']=DBYR;
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"tests/encridTests");
}	/* fxn */



public function migrate(){	
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$pdbg=VCPREFIX.'2019_'.DBG;
	$q="
		INSERT INTO {$dbo}.30_payables(sy,scid,feetype_id,amount)
			SELECT 2020 AS sy,ar.scid,3,ar.balance 
			FROM {$pdbg}.sjam_ar_2019 AS ar
		ORDER BY ar.scid
		;		
	";
	pr($q);
	
	if(isset($_GET['exe'])){
		$sth=$db->querysoc($q);
		echo ($sth)? "success":"fail";					
	}	/* exe */
	
	
}	/* fxn */







}	/* TestsController */
