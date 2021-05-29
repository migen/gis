<?php

Class OrnosController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index(){
	$dbo=PDBO;
	$db=&$this->model->db;
	$dbg=PDBG;
	$dbg=PDBG;
	$cond = "";
	unset($_GET['url']);	
	$data['get'] = $get = $_GET;
	
	if (!empty($get['start'])){ $cond .= " AND o.date >= '".$get['start']."'"; } 		
	if (!empty($get['end'])){ $cond .= " AND o.date <= '".$get['end']."'"; }		
	if(!empty($get['date'])){ $cond.=" AND o.date = '".$get['date']."' "; }
	if(!empty($get['orno'])){ $cond.=" AND o.orno LIKE '%".$get['orno']."%' "; }
	
	if(!empty($get)){
		$q=" SELECT o.* FROM {$dbg}.ornos AS o WHERE 1=1 $cond ; ";
		$sth=$db->querysoc($q);
		$rows = $sth->fetchAll();
		$count = count($rows);	
	} else {
		$rows=array();
		$count=0;
	}
	
	$data['rows'] = $rows;
	$data['count'] = $count;
	
	$this->view->render($data,'ornos/index');

}	/* fxn */



public function edit($params){
$dbo=PDBO;
$data['id'] = $id = $params[0];
$db=&$this->model->db;
$dbg=PDBG;

if(isset($_POST['submit'])){
$post = $_POST;
unset($post['submit']);
$db->update("{$dbg}.ornos",$post,"`id`='".$id."'");
$url="ornos/view/$id";
flashRedirect($url,'Orno edited.');

}	/* post */

$q="SELECT o.* FROM {$dbg}.ornos AS o WHERE `id` = '$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row'] = $sth->fetch();
$this->view->render($data,'ornos/edit');

}	/* fxn */


public function viewOld($params){
$dbo=PDBO;
$data['id'] = $id = $params[0];
$db=&$this->model->db;
$dbg=PDBG;

$q="SELECT o.* FROM {$dbg}.ornos AS o WHERE `id` = '$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row'] = $sth->fetch();
$this->view->render($data,'ornos/view');

}	/* fxn */


public function delete($params){
$dbo=PDBO;
$id=$params[0];
$db=&$this->model->db;
$dbg=PDBG;
$q="DELETE FROM {$dbg}.ornos WHERE `id`='$id' LIMIT 1; ";
$db->query($q);
$url="ornos";
flashRedirect($url,'Delete Orno #{$id}.');

}	/* fxn */


public function booklet(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	
	$q="SELECT b.*,c.name AS employee,b.id AS pkid
		FROM {$dbo}.03_orbooklets AS b 
		INNER JOIN {$dbo}.00_contacts AS c ON b.ecid=c.id
		WHERE c.role_id=2 ORDER BY c.name;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"ornos/bookletOrnos");
	
}	/* fxn */



public function editBooklet($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
	if(!isset($params)){ pr("OR Booklet pkid parameter required."); exit; }
	$pkid=$params[0];
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbo}.03_orbooklets",$post,"id=$pkid");
		flashRedirect("ornos/editBooklet/$pkid","Saved.");		
	}	/* post */

	/* process */
	$q="SELECT b.*,c.name AS employee,b.id AS pkid
		FROM {$dbo}.03_orbooklets AS b 
		INNER JOIN {$dbo}.00_contacts AS c ON b.ecid=c.id
		WHERE b.id=$pkid LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	
	$this->view->render($data,"ornos/editBookletOrnos");
	
}	/* fxn */



public function view($params=NULL){
	if(empty($params)){ pr("OR No. parameter required."); exit; }
	require_once(SITE."functions/numberFxn.php");
	// $data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$db=&$this->model->db;$dbo=PDBO;	
	$data['orno']=$orno=ltrim($params[0],"0");
	
	// $q="SELECT * FROM {$dbo}.30_payments WHERE orno=$orno LIMIT 1;";
	// $sth=$db->querysoc($q);
	// $
	
	$dbg=PDBG;

	$q="SELECT 
		summ.crid,
		s.role_id AS payer_role_id,
		p.*,p.sy AS paysy,p.id AS pkid,s.code AS studcode,s.name AS studname,e.name AS emplname,pr.address, 
		sum(p.amount) AS total,sum(p.received) AS total_received,sum(p.change) AS total_change
	FROM {$dbo}.30_payments AS p  
	LEFT JOIN {$dbo}.00_contacts AS s ON p.scid=s.id
	LEFT JOIN {$dbo}.00_contacts AS e ON p.ecid=e.id
	LEFT JOIN {$dbo}.00_profiles AS pr ON p.scid=pr.contact_id
	LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.scid
	WHERE p.orno = '$orno' LIMIT 1; ";
	debug($q);
	$sth=$db->querysoc($q);
	$or=$sth->fetch();
	
	$data['payer_is_student']=$payer_is_student=($or['payer_role_id']==1)? true:false;
	
	$or=($or['orno']!='')? $or:false;
	if(!$or){ prx("<h1>OR not found.</h1>"); }
	
	$sy=$or? $or['paysy']:$_SESSION['settings']['sy_enrollment'];
	$data['sy']=$sy;	
	$data['scid']=$scid=$or['scid'];
		
	$dbg=VCPREFIX.$sy.US.DBG;
	
	if($or){
		if($payer_is_student){
			$q="SELECT cr.name AS classroom
				FROM {$dbg}.05_summaries AS summ
				LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
				WHERE summ.scid=$scid LIMIT 1;";
			debug($q);
			$sth=$db->querysoc($q);
			$data['or2']=$or2=$sth->fetch();
			$data['crname']=$crname=($or2)?$or2['classroom']:false;			
			$or=(is_array($or2))?array_merge($or,$or2):$or;			
		}
		$data['or']=$or;		
	}	/* found OR */

	// rows
	$q="SELECT p.*,p.id AS pkid,f.name AS feetype
	FROM {$dbo}.30_payments AS p 
	LEFT JOIN {$dbo}.03_feetypes AS f ON p.feetype_id=f.id
	WHERE p.orno = '$orno'; ";

	debug($q);
	$sth=$db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = $sth->rowCount();
	$layout="empty";
	// $vfile="ornos/viewOrno";
	$sch=VCFOLDER;
	if(isset($_GET['table'])){ $vfile="ornos/viewOrno";$layout='full'; }

	$one="orno_{$sch}";$two="ornos/viewOrno";	
	if(isset($_GET['print'])){ $one="ornoprint_{$sch}"; }
	// $one="ornoprint_{$sch}";$two="ornos/viewOrno";
	
	
	$vfile=cview($one,$two,$sch=VCFOLDER);vfile($vfile);
		
	$this->view->render($data,$vfile,$layout);

}	/* fxn */





}	/* OrnosController */
