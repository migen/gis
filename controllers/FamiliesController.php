<?php

Class FamiliesController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
}	/* fxn */

public function index(){	
	$data['srid']=$srid=$_SESSION['srid'];
	if($srid==RSTUD){
		$db=&$this->baseModel->db;$dbo=PDBO;
		$scid=$_SESSION['ucid'];
		$q="SELECT last_name,first_name,middle_name FROM {$dbo}.00_profiles WHERE 
			contact_id=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$profile=$sth->fetch();
		extract($profile);
		$q="SELECT *,id AS pkid FROM {$dbo}.00_families WHERE name LIKE '%".$last_name."%' OR name LIKE '%".$middle_name."%'; ";
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();		
	}	/* fxn */
	
	$this->view->render($data,"families/indexFamilies");	
}	/* fxn */


public function table(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['srid']=$_SESSION['srid'];
	$q="SELECT *,id AS pkid FROM {$dbo}.00_families ORDER BY name; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	
	$this->view->render($data,"families/tableFamilies");
	
}	/* fxn */


public function members($params=NULL){
	$data['family_id']=$data['id']=$id=isset($params[0])? $params[0]:false;
	$data['srid']=$_SESSION['srid'];
	
	if($id){
		$data['sy']=$sy=DBYR;
		$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
		
		/* process */
		$data['family']=fetchRow($db,"{$dbo}.00_families",$id);
		
		/* process */
		$q="SELECT m.*,m.id AS pkid,c.name AS member,p.birthdate,c.code AS studcode
			FROM {$dbo}.00_family_members AS m
			INNER JOIN {$dbo}.00_contacts AS c ON m.scid=c.id
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbo}.00_profiles AS p ON m.scid=p.contact_id
			WHERE m.family_id=$id
			ORDER BY c.name; ";
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();			
		
		
		
	}	/* id */
	
	$this->view->render($data,"families/membersFamily");
	
}	/* fxn */


public function edit($params=NULL){
	if(empty($params)){ pr("Param family_id required."); exit; }

	$data['family_id']=$data['id']=$id=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbo}.00_families",$post,"id=$id"); 
		$url="families/members/$id";
		flashRedirect($url,"Saved.");		
	}	/* post */
	
	/* process */
	$data['row']=fetchRow($db,"{$dbo}.00_families",$id);
	
	
	$this->view->render($data,"families/editFamily");
	
	
}	/* fxn */


public function deleteMember($params=NULL){
	$acl=array(array(5,0),array(2,0),array(4,0),array(9,0));
	$this->permit($acl);				
	$db=&$this->baseModel->db;$dbo=PDBO;
	if(empty($params[0])){ pr("Parameter scid required."); exit; }
	$data['pkid']=$pkid=$params[0];
	$q="DELETE FROM {$dbo}.00_family_members WHERE id=$pkid LIMIT 1 ";
	$sth=$db->querysoc($q);
	echo ($sth)? "Success":"Fail";
	$url=$_SERVER['HTTP_REFERER'];
	echo "<br />";
	echo "<a href='".$url."' >Back</a>";
	
}	/* fxn */



}	/* BlankController */
