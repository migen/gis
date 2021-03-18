<?php

Class NamesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}


public function cleaner(){
	$name="REAÃ‘O";pr($name);echo "<hr />";
	echo utf8_decode($name);
}	/* fxn */

public function index(){
$dbo=PDBO;
	echo "Names";
	$db=&$this->baseModel->db;
	$q="select id,code,name from {$dbo}.`00_contacts` where id=1; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	pr($rows);
	
	// $data=NULL;$this->view->render($data,'abc/indexAbc');
}	/* fxn */


public function level($params=NULL){
$dbo=PDBO;
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$db=$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;$nsy=DBYR+1;

if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	foreach($posts AS $post){
		$scid=$post['scid'];unset($post['scid']);
		$post['name']=utf8_decode($post['name']);
		$db->update("{$dbo}.`00_contacts`",$post,"id='$scid'");
	}
	$url="names/level/$lvl";
	flashRedirect($url,"Names cleaned.");
}	/* posts */


$q="SELECT c.is_active,c.id AS scid,c.code,c.name,c.name AS student,c.crid AS concrid
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
	WHERE cr.level_id = '$lvl' AND c.is_active=1  AND cr.section_id<>2  AND c.`sy`<>'".$nsy."'   
ORDER BY c.name;";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
$this->view->render($data,'names/levelNames');


}	/* fxn */





}	/* BlankController */
