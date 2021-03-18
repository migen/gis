<?php

Class PhotosController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'photos/index');

}	/* fxn */




public function	one($params=NULL){
	$data['ucid']	= $ucid   = isset($params[0])? $params[0]:$_SESSION['user']['pcid'];
	$uc		= $this->model->fetchRow(PDBO.'.`00_contacts`',$ucid);
	$pcid	= $uc['parent_id'];

	if($ucid!=$pcid){ $ucid = $pcid; }

	$data['ssy'] 	= $ssy	= $_SESSION['sy'];
	$data['sy'] 	= $sy	= isset($params[1])? $params[1] : $ssy;

	$data['home']	= $home			= $_SESSION['home'];
	$_SESSION['url']	= "photos/one/$ucid";	

	$dbg = VCPREFIX.$sy.US.DBG;$dbo=PDBO; 

	$q = " SELECT 
			c.*,p.*,c.id AS ucid,p.contact_id AS photoucid
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN ".PDBP.".photos AS p ON p.contact_id = c.id
		WHERE c.id = '$ucid' LIMIT 1;		
	";
	

	$sth = $this->model->db->querysoc($q);
	$contact = $data['contact'] = $sth->fetch();
	
	/* ----------------------- upload ------------------------------------------------------------------------------------ */
	if(isset($_POST['submit'])) {
		$tmp_file = $_FILES['file_upload']['tmp_name'];		
		$upload_dir = (LOCAL==1)? SITE.'public/photos/' : '/tmp/';				
		$name 		= $_FILES["file_upload"]["name"];
		$filename	= 'tmp.jpg';
		$target_file = (isNullOrEmpty($filename))?  $tmp_file : $filename;				
		$upfile = $upload_dir.$target_file;		
		// pr($upfile); exit;
		if(move_uploaded_file($tmp_file,$upfile)) {
					
			/* 1 - resize $tmp_file */	
			$imageClass = SITE.'library/Image.php';			
			include($imageClass);
			
			$image 		= new Img();		
			$photo_url 	= (LOCAL==1)? SITE.'public/photos/' : '/tmp/';
			$photo 		=  $photo_url.$filename;
					
			$image->load($photo);
			$image->resize(IMGW,IMGH);
			$image->save($photo);
			$file_size = filesize($photo);

			$fp 		= fopen($photo,'rb'); 
			$content 	= fread($fp,$file_size) or die("Error: cannot read file");
			fclose($fp);		

			$today = $_SESSION['today'];
			if(empty($contact['photoucid'])){
				$q = " INSERT INTO ".DBP.".photos (`contact_id`) VALUES ('$pcid');";			
				$this->model->db->query($q);
			} 
			$q = " UPDATE ".PDBP.".photos SET `photo` = :content WHERE `contact_id` = :id LIMIT 1 ";			
			$sth = $this->model->db->prepare($q);
			// pr($q); pr($content); exit;
			$sth->execute(array(':content' => $content,':id' => $pcid));						
			Session::set('message','File uploaded successfully.');		
		} else {
			$error = $_FILES['file_upload']['error'];
			Session::set('message','Upload failed.');
		}		
		$url = isset($_SESSION['url'])? $_SESSION['url']:'contacts/ucis/'.$ucid;	
		redirect($url);
			
	}	/* post */

	$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$this->view->render($data,'photos/one');

}	/* fxn */




public function classroom($params){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/photos_classroom.php");
	$db 	=& $this->model->db;
	$ssy	= $_SESSION['sy'];
	$data['crid'] = $crid = $params[0];
	$dbg = PDBG;$dbo=PDBO;
		
	$data['students'] = getClassroomPhotos($db,$crid);
	$data['count']	  = count($data['students']);
	$_SESSION['url'] = "photos/classroom/$crid";
	$data['classroom'] = getClassroomDetails($db,$crid,$dbg);

	$this->view->render($data,'photos/classroom');

}	/* fxn */







}	/* PhotosController */
