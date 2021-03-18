<?php

Class ClasslistsController extends Controller{	

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
	$this->view->render($data,'tests/index');

}	/* fxn */



public function classroom($params){
	$dbo=PDBO;
	require_once(SITE.'functions/details.php');
	require_once(SITE.'functions/classlists.php');
	require_once(SITE.'functions/classrooms.php');
	$this->view->css=array('bootstrap.min.css');	
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	$cr = $data['cr'] = getClassroomDetails($db,$crid,$dbg,$ctp=true);				
	$acid=$cr['acid'];
	if(!canViewClasslist($db,$acid,$crid)){ flashRedirect(UNAUTH); }
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts']; $q="";
		foreach($posts AS $post){
			$q.="UPDATE {$dbo}.`00_contacts` SET `is_male`='".$post['is_male']."', 
				`code`='".$post['code']."',`lrn`='".$post['lrn']."', 
				`position`='".$post['position']."',`name`='".$post['name']."' 
				WHERE `id`='".$post['scid']."' LIMIT 1;";
		}
		$db->query($q);
		$url="classlists/classroom/$crid/$sy";		
		flashRedirect($url,"Classlist students edited.");
		exit;		
	}	/* post */
	
	$order=$_SESSION['settings']['classlist_order'];
	$order=isset($_GET['order'])? $_GET['order']:$order;
	debug($order,"Order: ");
	$rows=getClasslist($db,$dbg,$crid,$order,$fields="c.is_active,");
	$data['count']=count($rows);
	$data['rows']=&$rows;
	
	// $vfile="classlists/cridClasslists";
	$vfile="classlists/classroomClasslists";
	vfile($vfile);
	$this->view->render($data,$vfile);	

}	/* fxn */



public function custom($params){
	$data['dbo']=$dbo=PDBO;
	require_once(SITE.'functions/details.php');
	require_once(SITE.'functions/classlists.php');
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
	
	$data['db']=$db=$this->model->db;
	$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;
	$cr = $data['cr'] = getClassroomDetails($db,$crid,$dbg,$ctp=true);				
	
	$acid=$cr['acid'];
	if(!canViewClasslist($db,$acid,$crid)){ flashRedirect(UNAUTH); }

	$sch=VCFOLDER;$one="customClasslists_{$sch}";$two="classlists/customClasslists";
	$vfile=cview($one,$two,$sch=VCFOLDER);vfile($vfile);
	$this->view->render($data,$vfile);	

}	/* fxn */




public function master($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'functions/classlists.php');
	$data['crid']=$crid=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	$order=$_SESSION['settings']['classlist_order'];
	$order=isset($_GET['order'])? $_GET['order']:$order;
	
	$q="SELECT cr.acid,cr.name AS classroom,c.name AS adviser FROM {$dbg}.05_classrooms AS cr
	LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=cr.acid WHERE cr.id='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['cr']=$sth->fetch();
	
	$rows=getClasslist($db,$dbg,$crid,$order,$fields="c.is_active,");	
	$data['rows']=&$rows;
	$data['count']=count($rows);
	
	$sch=VCFOLDER;
	$one="classlists/{$sch}MasterClasslist";$two="classlists/masterClasslist";
	$vfile=cview($one,$two);
	vfile($vfile);
	$this->view->render($data,$vfile);
		
}	/* fxn */



public function profiles($params){
	$dbo=PDBO;
	require_once(SITE.'functions/details.php');
	require_once(SITE.'functions/classlists.php');
	require_once(SITE.'functions/classrooms.php');
	$this->view->css=array('bootstrap.min.css');	
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	$cr = $data['cr'] = getClassroomDetails($db,$crid,$dbg,$ctp=true);				
	$acid=$cr['acid'];
	if(!canViewClasslist($db,$acid,$crid)){ flashRedirect(UNAUTH); }


	$order=$_SESSION['settings']['classlist_order'];$order=isset($_GET['order'])? $_GET['order']:$order;	
	$rows=getClasslistByProfile($db,$dbg,$crid,$order,$fields="c.is_active,p.birthdate,");
	$data['count']=count($rows);
	$data['rows']=&$rows;
	$vfile="classlists/profilesClasslists";
	vfile($vfile);
	$this->view->render($data,$vfile);	

}	/* fxn */






}	/* ClasslistsController */
