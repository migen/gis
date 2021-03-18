 <?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

 /* from MyController */
Class ToolsController extends Controller{
/*
1) ac (code=account)
2) cricode (code=name)

*/


public function __construct(){
	parent::__construct();
	parent::beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','accounts/js/parent.js');		
	$acl = array(array(5,0));
	$this->permit($acl);					
	

}	/* fxn */


public function index(){
$dbo=PDBO;
	require_once(SITE."functions/reflections.php");
	require_once(SITE."functions/arrays.php");
	$db  =& $this->model->db;
	$cls =& $this;


 	$data['class']	 = $class		 	 = get_class();	
	// $data['methods'] = $methods = reflectMethods($class);
	
	
	$data['mr']=$mr=reflectMethods($class);
	$data['methods']=$methods = $mr['methods'];
	$data['count']=$count= $mr['count'];
		
	$a=array('mis','records','students','tools','teachers','registrars','contacts','info','ledgers','pos','npos','querys');
	$b=array('records','pupils');
	$ctlrs = array_merge($a,$b);
	
	$data['classes'] = bcr($ctlrs);
	
	$data['is_index']		= true;
	$data['is_mis']		= ($_SESSION['user']['role_id']==RMIS)?true:false;
	$vfile='tools/indexTools';vfile($vfile);
	$this->view->render($data,$vfile);
		 
 
}	/* fxn */



public function ac(){ 	/* accountToCode */
	$q = " update {$dbo}.`00_contacts` SET `code` = `account` order by id ASC ";
	// pr($q);
	$this->Tool->db->query($q);
	Session::set('message',$q);
	redirect('tools');

}	/* fxn */



public function cricode(){
$dbo=PDBO;
$dbg = PDBG;
$q = " SELECT * FROM {$dbo}.`05_criteria` ; ";
$sth = $this->baseModel->db->querysoc($q);

$rows = $sth->fetchAll();

pr($rows);

$q = "";
foreach($rows AS $row){
	if(strlen($row['code'])<1){
		$q .= "UPDATE {$dbo}.`05_criteria` SET `code` = '".$row['name']."' WHERE `id` = '".$row['id']."' LIMIT 1;  ";
	}
}

pr($q);



}	/* fxn */


public function upname(){
$dbo=PDBO;
$dbc = DBO.'.`00_contacts`';

$q = "
UPDATE {$dbc} AS a
INNER JOIN (
	SELECT uc.id,pc.name 
		FROM {$dbc} AS uc
		LEFT JOIN {$dbc} AS pc ON uc.parent_id = pc.id
) AS b ON a.id = b.id
SET a.name = b.name;

";

// pr($q);
$this->baseModel->db->query($q);
SESSION::set('message','User-Parent Name Synced!');
redirect('mis');


}	/* fxn */





public function agenda(){
	$this->view->render($data=NULL,'tools/agenda');
}	



public function ajax(){
	$data = NULL;
	$this->view->render($data,'mis/ajax');
}	/* fxn */


public function diagnose($params=NULL){

include_once(SITE.'views/elements/params_sq.php');




}	/* fxn */




public function deleteDuplicates(){	/* delete duplicates */
$dbo=PDBO;

$dbg = PDBG;

$q = "
	SELECT id AS attid,date,contact_id AS ucid,count(*) AS cnt
	FROM {$dbg}.06_attendance_employees_logs
	GROUP BY contact_id,date
	HAVING COUNT(cnt) > 1	
";

// pr($q);
$sth = $this->model->db->query($q);
$data['duplicates'] = $sth->fetchAll();
$data['count'] = count($data['duplicates']);

$this->view->render($data,'mis/atte_duplicates');


}	/* fxn */




public function setter(){
	if(isset($_POST['submit'])){
		$key = $_POST['key'];
		$value = $_POST['value'];
		$_SESSION[$key] = $value;		
		$url = $_SESSION['home'];
		flashRedirect($url,"$key value set to $value.");
		exit;
		
	}	/* fxn */
	
	$this->view->render(NULL,'tools/setter');

}	/* fxn */


public function propagator(){


$data['tables'] = array('subjects','courses','criteria','components');
$data['count'] = count($data['tables']);

$this->view->render($data,'tools/propagator');


}	/* fxn */



public function enye(){
$dbo=PDBO;
$db=&$this->model->db;

if(isset($_POST['update'])){
	// pr($_POST);
	$posts = $_POST['posts'];
	
	$posts = $_POST['posts'];		
	$col = $_POST['x'];
	$q = "";
	foreach($posts AS $post){
		$code = $post['code'];
		$empty = (empty($code))? true:false;
		if(!$empty){
			$code = preg_replace("([^A-Za-z0-9-/])","",$code);																
			$qry = "SELECT id FROM {$dbo}.`00_contacts` WHERE `code` = '$code' LIMIT 1;";
			$sth = $db->querysoc($qry);
			$row = $sth->fetch();
			
			if($row){
				$id=$row['id'];
				$name=trim($post['x']);				
				$name = preg_replace("([^A-Za-z0-9- /])","",$name);				
				$q.="UPDATE {$dbo}.`00_contacts` SET `$col`='$name' WHERE `id`='$id' LIMIT 1;";				
			}	
			
			
		}		
	} /* foreach */
	// pr($q);
	// exit;
	$db->query($q);
	$home=$_SESSION['home'];
	flashRedirect($home,'Name changed from Enye Module.');		
	exit;

}	/* post */


$data=NULL;
$this->view->render($data,'tools/enye');

}	/* fxn */




} /* ToolsController */
