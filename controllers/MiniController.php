<?php

Class MiniController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	parent::beforeFilter();

	// $acl = array(array(4,0),array(5,0));
	// $this->permit($acl,false);		
	
}	/* fxn */


public function ob(){
	
	
	$this->view->render(null,'mini/ob');
}


public function multistepForm(){
	
	if(isset($_POST['submit'])){
		prx($_POST);
	}
	
	$data=NULL;
	$this->view->render($data,"mini/multistepForm");
	
}

public function index($params=NULL){	
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['sy']=DBYR;	
	$data['dbg']=$dbg=PDBG;


    
	require_once(SITE."functions/reflections.php");
    $data['class']=$class=get_called_class();	
	$data=reflectMethods($class);
    $data['rows']=&$data['methods'];		
	$vfile="controllers/methodsControllers";vfile($vfile);
	$class_name=$data['class'];$controller_name=str_replace("Controller","",$class_name);$controller_name=strtolower($controller_name);
	$data['controller_name']=$controller_name;
    

    // pr($data);
    // exit;
	
	$this->view->render($data,"mini/indexMini");

}	/* fxn */



public function modal(){	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;	
	// $data['rows']=fetchRows($db,"{$dbo}.`05_levels`","*","id");
	$q="SELECT * FROM {$dbo}.05_levels WHERE id >3 AND id < 8 ORDER BY id; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$data['count']=count($data['rows']);
	$vfile="mini/modalMini";vfile($vfile);
	
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	$this->view->css = array('custom.css');	
	$this->view->render($data,$vfile,'bootstrap');	


}	/* fxn */


public function filter($params=NULL){
	$data['scid']=isset($params[0])? $params[0]:false;
	$data['sy']=DBYR;
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"mini/filterMini");
}	/* fxn */



public function pagination($params=NULL){
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
	
	$dbtable="{$dbo}.`00_contacts`";
	$cond="1=1";	
	$srid=$_SESSION['srid'];
	if (!empty($params['search'])){ $cond .= " AND c.name LIKE '%".$search."%' "; }				
	if($ucid){ $cond.=" AND l.ucid = ".$ucid." "; } 
	if(isset($_GET['multi'])){ $cond.=" AND c.parent_id <> c.id "; } 

	$data['cond']=$cond;
	$order="c.role_id,c.name";
	/* derived */
	$offset=($currPage-1)*$perPage;
	$url="mini/pagination";
	/* sql */
	$q="SELECT c.id AS pkid,c.*,c.name AS contact
		FROM $dbtable AS c 
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
	
	$this->view->render($data,"mini/paginationMini");
	
	
	
}	/* fxn */



public function editor($params=NULL){
	$dbo=PDBO;	
	$filename	= 'version';
	$file 		= "version.php";
	$file = SITE."views/mini/$file";

	
	if(isset($_POST['submit'])){
		/* $contents = nl2br(htmlspecialchars($_POST['version'])); */
		$body 	= $_POST['body'];
		$handle = fopen($file,"w");
		fwrite($handle,$body);
		fclose($handle);	
		// $url = "files/read/$filename";
		$url = "mini/editor";
		flashRedirect($url,"Text saved.");
	}
	
	if (file_exists($file)) {
		$data['file'] = file_get_contents($file);
	}
	
	$vfile="mini/editorMini";
	$layout="editor";
	vfile($vfile);vfile($layout);
	$this->view->render($data,$vfile,$layout);
		
}	/* fxn */
	


public function lounge(){
	pr('unauth - lounge');

}




}	/* BlankController */
