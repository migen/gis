<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

Class ImgController extends Controller{

public function __construct(){
	parent::__construct();
	parent::beforeFilter();	/* login */	
	
}


public function beforeFilter(){}


public function index(){
	$data=NULL;
	$this->view->render($data,'img/indexImg');
}


public function dirpage($params=NULL){
	$dbo=PDBO;	
	$dir = SITE."tmp".DS."images";	
	$page = isset($_GET['page'])? $_GET['page'] : 1;
	if(isset($_GET['page'])) { unset($_GET['page']); }
	$_SESSION['page'] = $page;
	$r = scandir($dir,1);				
	$x = array('.','..');				
	$data['files'] 			= array_diff($r,$x);
	$data['num_files'] 		= count($data['files']);	
	$this->view->render($data,'img/dirpageImg');

}	/* fxn */


public function jpg($params=NULL){
$dbo=PDBO;	
echo "<h2><a href='".URL.$_SESSION['home']."' >Home</a>";
echo " | <a href='".URL."mis/setup' >Setup</a>";
if(empty($params)){  echo " | Specify ucid or range like img/jpg/1 or img/jpg/1/10</h2>"; exit; } 


$frucid = $params[0]-1;
$toucid = isset($params[1])? $params[1]+1:$params[0]+1;

$q = "
	SELECT 
		c.id,c.name,c.code,ph.photo
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN ".DBP.".photos AS ph ON ph.contact_id = c.id 
	WHERE c.id > '$frucid' AND c.id < '$toucid' LIMIT 100;
";
// pr($q);
$sth = $this->model->db->querysoc($q);
$rows = $sth->fetchAll();
// pr($rows);
$path = SITE."tmp/images/";

// echo "Disabled "; Exit;

foreach($rows AS $row){
	$image = $row["photo"];
	$name = $row["id"].'.jpg';
	file_put_contents($path."/".$name,$image);	
}	
   
     
echo "<br /> Jpeg File written and created";

// option 1
/* 	$file = fopen($path."/".$name,"w");
	fwrite($file, $image);
	fclose($file);
 */

/* option 2 (oneliner) */
// file_put_contents($path."/".$name, base64_decode($image));





}	/* fxn */




public function ejpg($params=NULL){
$dbo=PDBO;	

$q = "
	SELECT 
		c.id,c.name,c.code,ph.photo
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN ".DBP.".photos AS ph ON ph.contact_id = c.id 
	WHERE c.role_id <> '".RSTUD."' 
;";
// pr($q);
$sth = $this->model->db->querysoc($q);
$rows = $sth->fetchAll();
// pr($rows);
$path = SITE."tmp/images/";

// echo "Disabled "; Exit;

foreach($rows AS $row){
	$image = $row["photo"];
	$name = $row["id"].'.jpg';
	file_put_contents($path."/".$name,$image);	
}	
   
     
echo "<br /> Jpeg File written and created";

// option 1
/* 	$file = fopen($path."/".$name,"w");
	fwrite($file, $image);
	fclose($file);
 */

/* option 2 (oneliner) */
// file_put_contents($path."/".$name, base64_decode($image));





}	/* fxn */


public function getpic($params=NULL){
	$dbo=PDBO;	
	$pcid = $params[0];
	$q = "
		SELECT 
			c.id,c.name,c.code,ph.photo
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN ".DBP.".photos AS ph ON ph.contact_id = c.id 
		WHERE c.id = '$pcid' LIMIT 1;
	";
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();

	$path = CPHOTOS;
	$image = $row["photo"];
	$name = $row["id"].'.jpg';
	file_put_contents($path."/".$name,$image);	

	$url = isset($_SESSION['url'])? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "Downloaded systems photo of ".$row['name'].".";
	redirect($url);

}	/* fxn */




}	/* ImgController */