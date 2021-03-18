<?php

Class EscController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	
}


public function index(){	
	pr("abc index");

}

public function scid($params=NULL){
	if(!isset($params)){ pr("param[0]-scid is required"); exit; }
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['year'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$dbtable="{$dbg}.05_summaries";
	
	if(isset($_POST['submit'])){
		$post=$_POST['summ'];$id=$post['id'];
		$db->update("{$dbtable}",$post,"id=$id");
		flashRedirect("esc/scid/$scid/$sy","Saved.");
		exit;
	}
	/* getData */
	$q="SELECT summ.scid,c.code AS studcode,c.name AS studname,l.name AS level,
			esc.amount,summ.esc_id,esc.name AS escname,esc.code AS esccode,summ.id AS pkid
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		LEFT JOIN {$dbg}.05_esc AS esc ON summ.esc_id=esc.id
		WHERE summ.scid=$scid LIMIT 1;
	";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();

	if(!isset($_SESSION['esc'])){ $_SESSION['esc']=fetchRows($db,"{$dbg}.05_esc","*","id"); }
	$data['esc']=$_SESSION['esc'];
	// $vfile="students/paymodeStudent";vfile($vfile);
	$vfile="esc/scidEsc";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function table($params=NULL){	
	$sy=isset($params[0])? $params[0]:DBYR;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

	// $data['rows']=fetchRows($db,"{$dbg}.05_esc","*","id"); }
	$q="SELECT * FROM {$dbg}.05_esc ORDER BY id; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	$this->view->render($data,"");



}	/* fxn */



}	/* BlankController */
