<?php

Class TasksController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




public function view($params=NULL){

require_once(SITE."functions/tasks.php");
$db =& $this->model->db;
$dbo=PDBO;$dbg=PDBG;
$data['id']=$id=isset($params[0])? $params[0]:false;
if($id){
	$data['row']=readTask($db,$id,$dbg);
}	/* id */

$this->view->render($data,'tasks/view');


}	/* fxn */


public function add(){
$dbo=PDBO;
$data['ucid']=$ucid=$_SESSION['ucid'];
$data['today']=$_SESSION['today'];
$dbg=PDBG;$dbg=PDBG;
$db=&$this->model->db;

if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	foreach($posts AS $post){ 
		if(!empty($post['item'])){ $db->add("{$dbg}.tasks",$post); }
	}
	$id=lastId($db,"{$dbg}.tasks");	
	$url="tasks/view/$id";
	flashRedirect($url,'New task added.');
}	/* post */

$this->view->render($data,'tasks/add');

}	/* fxn */


public function modify($params=NULL){
require_once(SITE."functions/tasks.php");
$db =& $this->model->db;
$dbo=PDBO;$dbg=PDBG;
$data['id']=$id=isset($params[0])? $params[0]:false;
if($id){ $data['row']=readTask($db,$id,$dbg); }	/* id */

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbg}.tasks",$post,"`id`='$id'");
	$url="tasks/view/$id";
	flashRedirect($url,'Task updated.');
}	/* post */


$this->view->render($data,'tasks/modify');


}	/* fxn */


public function report(){
require_once(SITE."functions/tasks.php");
$db =& $this->model->db;

$sy=isset($_GET['sy'])? $_GET['sy']:$_SESSION['sy'];
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;


if(isset($_GET['filter'])){
	// $cond
	$q="
		SELECT 
		FROM {$dbg}.tasks AS t 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON t.ucid=c.id
		WHERE 1=1 $cond
		
	";

	pr($q);


}

}	/* fxn */




public function index(){
require_once(SITE."functions/tasks.php");
$db =& $this->model->db;
$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['num_tasks'] = $num_tasks = $_SESSION['settings']['num_tasks'];

if(isset($_GET['submit'])){
	$params = $_GET;	
	$sort = $params['sort'];
	$order = $params['order'];
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 		
	$cond = NULL;
	$cond .= "";
	if (!empty($params['ucid'])){ $cond .= " AND t.ucid = '".$params['ucid']."'"; }				
	if (!empty($params['start'])){ $cond .= " AND t.date >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND t.date <= '".$params['end']."'"; }				
	if (!empty($params['item'])){ $cond .= " AND (t.item LIKE '%".$params['item']."%'
		OR t.remarks LIKE '%".$params['item']."%')"; }				
	if ((isset($params['is_done'])) && ($params['is_done']<2)){ $cond .= " AND t.is_done = '".$params['is_done']."'"; }				

	$q=" SELECT t.*,t.id AS tid,c.name AS user FROM {$dbg}.tasks AS t 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON t.ucid = c.id
		WHERE 1=1 $cond ORDER BY $sort $order $condlimits; ";
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();	
	$data['rows'] = $rows; 		
	$data['count'] = count($rows);


} 	/* filter */


/* for batch edits */
if(isset($_POST['batch'])){
	$ids = stringify($_POST['rows']);
	$axn=strtolower($_POST['batch']);
	$url = "tasks/$axn/$ids";
	// pr($url);
	// pr($_POST['rows']);exit;
	
	redirect($url);		
}



$data['sort'] = $sort = isset($sort)? $sort : 't.date';
$data['order'] = $order = isset($order)? $order : 'DESC';
$data['page'] = $page = isset($page)? $page : '1';
$data['limits'] = $limits = isset($limits)? $limits : $num_tasks;

$this->view->render($data,"tasks/index");


}	/* fxn */




public function edit($params){		
$dbo=PDBO;
	require_once(SITE."functions/tasks.php");
	$db =& $this->model->db;
	$data['home'] = $_SESSION['home'];
	$ssy = $_SESSION['sy'];$dbg = PDBG;$dbg	= PDBG;
	
	if(isset($_POST['submit'])){
		$posts = $_POST['posts'];
		$q = "";
		foreach($posts as $post){	
			$q .= "UPDATE {$dbg}.tasks SET `item` = '".$post['item']."',
				`remarks` = '".$post['remarks']."',`is_done` = '".$post['is_done']."' 				
				WHERE `id` = '".$post['id']."' LIMIT 1; "; 
		} 		
		$db->query($q);		
		$url = "tasks";
		flashRedirect($url,'Tasks updated.');
		exit;		
	} /* submitted */
		
	
	$count = count($params);
	for($i=0;$i<$count;$i++){ $data['rows'][$i] = readTask($db,$params[$i]); }			

	$data = isset($data)? $data : null;		
	$this->view->render($data,'tasks/edit');		
	
}		/* fxn */


public function delete($ids=NULL){
$dbo=PDBO;
$dbg=PDBG;
if(!empty($ids)){
	$q="";
	foreach($ids AS $id){
		$q.="DELETE FROM {$dbg}.tasks WHERE `id`='$id' LIMIT 1; ";
	}
	pr($q);
} else {
	echo "ID Params empty.";
}



}	/* fxn */



}	/* TasksController */
