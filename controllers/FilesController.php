<?php

Class FilesController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	// $this->view->css = array('style_long.css','etc.css');	
	// $this->view->css = array('style_long.css','etc.css');	
	
}

public function beforeFilter(){
	parent::loginRedirect();


	
}	/* fxn */


public function notes(){
	$this->view->render(null,'files/notes');				
} 



public function fw(){
$dbo=PDBO;	

$file = SITE."config/testpaths.php";
// $file = "C:\system files\bin/settings.ini";

pr($file);

if (file_exists($file)) {
    $data['content'] = $content = file_get_contents($file);
	

/* $pattern = 'terminal';	
if(preg_match_all("/$pattern/",$content,$matches)){  pr($matches); }
 */

 
 /* 
$x = stripos($content,'terminal'); 
pr($x);
  */
  
  
/* 
$fileContents = file($file);
$pattern = "/terminal/";
$linesFound = preg_grep($pattern,$fileContents);
pr($linesFound);  
 */ 

	
	
}

$data = isset($data)? $data : NULL;
$this->view->render($data,"accounts/fw");


}





public function read($params=NULL){
$dbo=PDBO;	
$filename = isset($params[0])?$params[0]:false;
if(!$filename){ redirect('index'); }
$file = SITE."views/files/{$filename}.php";

$sch=VCFOLDER;
$cfile=SITE."views/customs/{$sch}/files/{$filename}_{$sch}.php";

if(file_exists($cfile)){ $file=$cfile; }


if(file_exists($file)) {
    $data[$filename] = file_get_contents($file);
}

	$data = isset($data)? $data : NULL;
	$vfile="files/$filename";

	if(file_exists($cfile)){ 
		$vfile="customs/{$sch}/files/{$filename}_{$sch}";
	} 

	vfile($vfile);
	$this->view->render($data,$vfile);


}	/* fxn */



public function write(){

if(isset($_POST['submit'])){
    /* $contents = nl2br(htmlspecialchars($_POST['version'])); */	
	$name = $_POST['name'];
	$body = $_POST['body'];
	$file = SITE."views/files/$name.php";	
		
	if (file_exists($file)) { redirect('files/read/'.$name); }
		
    $handle = fopen($file,"w");
    fwrite($handle,$body);
    fclose($handle);	
	$url = "files/edit/$name";
	redirect($url);
}

$data = isset($data)? $data:NULL;
// $this->view->render($data,"files/write",'editor');
$this->view->render($data,"files/write");


}	/* fxn */


public function edit($params=NULL){
$dbo=PDBO;	
$filename	= $params[0];
$file 		= "{$filename}.php";
$file = SITE."views/files/$file";

if(isset($_POST['submit'])){
    /* $contents = nl2br(htmlspecialchars($_POST['version'])); */
    $body 	= $_POST['body'];
    $handle = fopen($file,"w");
    fwrite($handle,$body);
    fclose($handle);	
	$url = "files/read/$filename";
	redirect($url);
}

if (file_exists($file)) {
    $data['file'] = file_get_contents($file);
}

$vfile="files/edit";$layout="editor";
vfile($vfile);vfile($layout);
// echo "vfile: $vfile <br />";echo "layout: $layout <br />";
$this->view->render($data,$vfile,$layout);




}	/* fxn */



public function index($params=NULL){
	$dbo=PDBO;	
	$dir = SITE."views".DS."files";	
	$page = isset($_GET['page'])? $_GET['page'] : 1;
	if(isset($_GET['page'])) { unset($_GET['page']); }
	$_SESSION['files_page'] = $page;
	$r 			= scandir($dir,1);				
	$x 			= array('.','..','index.php','edit.php','write.php','delete.php');				
	$data['files'] 			= array_diff($r,$x);
	$data['num_files'] 		= count($data['files']);	
	$this->view->render($data,'files/index');

}	/* fxn */



public function delete($params=NULL){
	$dbo=PDBO;	
	$filename	= $params[0];
	$file 		= "{$filename}.php";
	$xfile = SITE."views/files/$file";
	unlink($xfile);
	Session::set('message',"$file deleted");
	redirect('files/index');

}	/* fxn */



public function textarea($params=NULL){
	// $data="files textarea";

$filename	= $params[0];
$file 		= "{$filename}.php";
$file = SITE."views/files/$file";

if(isset($_POST['submit'])){
    /* $contents = nl2br(htmlspecialchars($_POST['version'])); */
    $body 	= $_POST['body'];
    $handle = fopen($file,"w");
    fwrite($handle,$body);
    fclose($handle);	
	$url = "files/read/$filename";
	redirect($url);
}

if (file_exists($file)) {
    $data['file'] = file_get_contents($file);
}

	// pr($file);
	// pr($data);
	// exit;
	$this->view->render($data,'files/textarea','editor');
	
	
	
}	/* fxn */


}	/* FilesController */