<?php

Class AuditController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	// $this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');	
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');	

	$acl = array(array(2,0),array(RMIS,0),array(RMIS,1));
	$this->permit($acl,$strict=true);			

	
}


public function beforeFilter(){}	/* fxn */


public function index(){ 
	echo "<h3>Audit</h3>";
	
}	/* fxn */


public function trails($params=NULL){
	reqFxn('paginationFxn');
	$data['ucid']=$ucid=isset($_GET['ucid'])? $_GET['scid']:false;
	$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;




	/* given */
	$data['currPage']=$currPage=isset($_GET['page'])? $_GET['page']:1;
	// $data['perPage']=$perPage=isset($_GET['perPage'])? $_GET['perPage']:5;
	$data['perPage']=$data['limit']=$perPage=$limit=isset($_GET['limit'])? $_GET['limit']:30;
	$perSet=10;	
	
	// $_GET['debug']=true;
	$params=isset($_GET)? $_GET:null;
	$data['search']=$search=!empty($params['search'])? $params['search']:false;
	$data['start']=$start=!empty($params['start'])? $params['start']:false;
	$data['end']=$end=!empty($params['end'])? $params['end']:false;
	
	$dbtable="{$dbo}.`logs`";
	$cond="1=1";	
	$srid=$_SESSION['srid'];
	if (!empty($params['search'])){ $cond .= " AND l.details LIKE '%".$search."%' "; }				
	if (!empty($params['start'])){ $cond .= " AND DATE(l.datetime) >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND DATE(l.datetime) <= '".$params['end']."'"; }				
	if($ucid){ $cond.=" AND l.ucid = ".$ucid." "; } 
	if(isset($_GET['sy'])){ $cond.=" AND l.sy = ".$_GET['sy']." "; } 
	if($srid==RAXIS){ $cond.=" AND l.module_id=2 "; }

	$data['cond']=$cond;
	$order="l.datetime DESC";
	/* derived */
	$offset=($currPage-1)*$perPage;
	$url="audit/trails";
	/* sql */
	$q="SELECT l.id AS pkid,l.*,c.name AS contact,m.name AS module
		FROM $dbtable AS l 
		LEFT JOIN {$dbo}.00_contacts AS c ON c.id=l.ucid
		LEFT JOIN {$dbo}.modules AS m ON m.id=l.module_id
		WHERE $cond ORDER BY $order ";		
	debug($q);
	$sth=$db->querysoc($q);
	$totalCount=$data['totalCount']=$sth->rowCount();
	// $data['totalCount']=$totalCount=120;	
	$data['totalCount']=$totalCount;	
	
	/* derived */
	$data['pagenav']=pagenav($url,$totalCount,$offset,$perPage,$currPage,$perSet);	

	$debug="";
	$debug.="<hr />";
	$debug.="q: ".$q."<br />";	
	$debug.="condition: ".$cond."<br />";	
	$debug.="totalCount: ".$totalCount."<br />";	
	$debug.="curr Page: $currPage <br />";
	debug($debug);

	$q.=" LIMIT $perPage OFFSET $offset";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		
	
	$this->view->render($data,"audit/trailsAudit");
	
	
	
}	/* fxn */







}	/* BlankController */
