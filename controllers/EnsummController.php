<?php

Class EnsummController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/crypto.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0),array(2,0),array(4,0)); 
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				
}	/* fxn */


public function index($params=NULL){
	// pr("Enrollment Summary");
	$data="Ensumm Index";
	$vfile="ensumm/indexEnsumm";vfile($vfile);
	$this->view->render($data,$vfile);
	

}	/* fxn */


public function edit1($params=NULL){
	$data['enid']=$enid=isset($params[0])? $params[0]:false;
	if(!$enid){ pr("Parameter Enrollment ID required."); exit;  }
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;$sch=VCFOLDER;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$remarks=$post['remarks'];
		$balance=$post['balance'];
		$balance_from=$post['balance_from'];
		$balance=str_replace(",","",$balance);
		$sy=$post['sy'];
		$arid=$post['arid'];
		$scid=$post['scid'];
		$cdbg=VCPREFIX.$sy.US.DBG;
		// pr($post);exit;
		$q="UPDATE {$dbo}.05_enrollments SET balance='$balance',remarks='$remarks' WHERE id=$enid LIMIT 1; ";
		$q.="UPDATE {$cdbg}.{$sch}_ar_{$sy} SET balance='$balance' WHERE id=$arid LIMIT 1; ";
		// pr($q);exit;
		$sth=$db->query($q);
		$message=($sth)? "Success":"Fail";
		$url="students/ensumm/$scid";
		$url="students/ensumm/$scid";		
		/* log */
		$entity_ucid=$scid;$username=$_SESSION['user']['fullname'];$subject_name=$post['subject_name'];		
		$details="$subject_name $balance_from to $balance edit ensumm by $username.";							
		$ip=$_SERVER['REMOTE_ADDR'];$ucid=$_SESSION['ucid'];$ts=date("Y-m-d H:i:s");
		$q="INSERT INTO {$dbg}.50_logs(`ip`,`datetime`,`ucid`,`ecid`,`details`)VALUES('$ip','$ts',$ucid,$entity_ucid,'$details');";
		$sth=$db->prepare($q);$sth->execute(); 
		$message=($sth)? "Success":"Fail";		
		flashRedirect($url,$message);
		exit;		
	}	/* post */
	
	$q="SELECT c.code AS studcode,c.name AS student,en.*,en.id AS enid,cr.name AS classroom
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbo}.05_enrollments AS en ON en.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON en.crid=cr.id
		WHERE en.id=$enid LIMIT 1;";
		debug($q);
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
	$sy=$row['sy'];
	$scid=$row['scid'];
	$cdbg=VCPREFIX.$sy.US.DBG;	// conjunction
	$q="SELECT ar.id AS arid,ar.balance AS arbalance 
		FROM {$cdbg}.{$sch}_ar_{$sy} AS ar WHERE ar.scid=$scid;";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['ar_row']=$ar_row=$sth->fetch();
	if($ar_row){ $row=array_merge($row,$ar_row); }
	$data['row']=&$row;
	
	$vfile="ensumm/editEnsumm";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function delete($params=NULL){
	$data['enid']=$enid=isset($params[0])? $params[0]:false;
	if(!$enid){ pr("Parameter Enrollment ID required."); exit;  }
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$row=fetchRow($db,"{$dbo}.05_enrollments",$enid);
	$scid=$row['scid'];
	$url="students/ensumm/$scid";
	$q="DELETE FROM {$dbo}.05_enrollments WHERE id=$enid LIMIT 1;";
	$sth=$db->query($q);
	$message=($sth)? "Deleted":"Not deleted.";
	flashRedirect($url,$message);
	
}	/* fxn */



public function edit($params=NULL){
	$data['pkid']=$pkid=isset($params[0])? $params[0]:false;
	if(!$pkid){ pr("Parameter Payables Primary Key ID required."); exit;  }
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;$sch=VCFOLDER;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$remarks=$post['remarks'];
		$balance=$post['balance'];
		$balance_from=$post['balance_from'];
		$balance=str_replace(",","",$balance);
		$sy=$post['sy'];
		$pkid=$post['pkid'];
		$scid=$post['scid'];
		$cdbg=VCPREFIX.$sy.US.DBG;
		// pr($post);exit;
		$q="UPDATE {$dbo}.05_enrollments SET balance='$balance',remarks='$remarks' WHERE id=$enid LIMIT 1; ";
		// $q.="UPDATE {$cdbg}.{$sch}_ar_{$sy} SET balance='$balance' WHERE id=$arid LIMIT 1; ";
		$q.="UPDATE {$dbo}.30_payables SET amount='$balance' WHERE id=$pkid LIMIT 1; ";
		// pr($q);exit;
		$sth=$db->query($q);
		$message=($sth)? "Success":"Fail";
		$url="students/ensumm/$scid";
		$url="students/ensumm/$scid";		
		/* log */
		$entity_ucid=$scid;$username=$_SESSION['user']['fullname'];$subject_name=$post['subject_name'];		
		$details="$subject_name $balance_from to $balance edit ensumm by $username.";							
		$ip=$_SERVER['REMOTE_ADDR'];$ucid=$_SESSION['ucid'];$ts=date("Y-m-d H:i:s");
		$q="INSERT INTO {$dbg}.50_logs(`ip`,`datetime`,`ucid`,`ecid`,`details`)VALUES('$ip','$ts',$ucid,$entity_ucid,'$details');";
		$sth=$db->prepare($q);$sth->execute(); 
		$message=($sth)? "Success":"Fail";		
		flashRedirect($url,$message);
		exit;		
	}	/* post */
	
	$q="SELECT c.code AS studcode,c.name AS student,en.*,en.id AS enid,cr.name AS classroom
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbo}.05_enrollments AS en ON en.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON en.crid=cr.id
		WHERE en.id=$enid LIMIT 1;";
		debug($q);
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
	$sy=$row['sy'];
	$scid=$row['scid'];
	$cdbg=VCPREFIX.$sy.US.DBG;	// conjunction
	$q1="SELECT ar.id AS arid,ar.balance AS arbalance 
		FROM {$cdbg}.{$sch}_ar_{$sy} AS ar WHERE ar.scid=$scid;";
		
	$q="SELECT p.id AS pkid,p.amount AS arbalance 
		FROM {$dbo}.30_payables AS p WHERE p.scid=$scid;";
		
	// pr($q);
	$sth=$db->querysoc($q);
	$data['ar_row']=$ar_row=$sth->fetch();
	if($ar_row){ $row=array_merge($row,$ar_row); }
	$data['row']=&$row;
	
	$vfile="ensumm/editEnsumm";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */







 
} 	/* MisController */

