<?php

Class PatronsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "Library Patrons";

}	/* fxn */



public function visit(){
	require_once(SITE."functions/patrons.php");
	$interval=$_SESSION['library_interval'];
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;$dbp=DBP;
	$url="patrons/visit";
	$today=$_SESSION['today'];
	$data['dif']=$dif=$_SESSION['subdepartment_id'];		
	$data['dcf']=$dcf=$_SESSION['subdept'];		

	if(!isset($_SESSION['libstats'])){	
		require_once(SITE."functions/librarians.php");
		sessionizeLibstats($db); 
	}
	
	if(isset($_POST['set'])){
		$q="SELECT code FROM {$dbo}.88_ip_subdepts WHERE subdepartment_id='".$_POST['dif']."' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$_SESSION['subdept']=$row['code'];
		$_SESSION['subdepartment_id']=$_POST['dif'];
		redirect("patrons/visit");exit;
	}	/* post */
	
	if(isset($_POST['submit'])){
		/* 1 */
		// pr($_POST);exit;
		$time = $_POST['time'];				
		$code=trim($_POST['studcode']);
		$code=str_replace("-","",$code);						
		$person=getPatronDetails($db,$code,$dif);
		$_SESSION['person']=$person;
		$ucid=$person['ucid'];
		$name=$person['name'];
		$dcp=$person['dcp'];
		
		if($ucid){
			$q="SELECT p.*,p.id AS pid FROM {$dbg}.70_patrons AS p
				WHERE p.`ucid`='$ucid' AND p.`date`='$today' AND p.subdepartment_id='$dif' LIMIT 1; ";
			$sth=$db->querysoc($q);
			$row=$sth->fetch();
			// pr($q);
			// pr($row);exit;
			// pr();
			if($row){
				$pid=$row['pid'];
				$long_enough=longEnough($row['timeout'],$time,$interval);				
				if($long_enough){
					$timeadd = ",$time";
					$q="UPDATE {$dbg}.70_patrons SET `timeout` = '$time',`logtimes`=CONCAT(`logtimes`,'$timeadd'),
						`numlogs`=`numlogs`+1 WHERE `id`='$pid' LIMIT 1; ";
					$db->query($q);	
					$_SESSION['patron']['message']="Added timein, updated timeout.";					
				} else {
					$_SESSION['patron']['message']="NOT Long Enough.";				
				}				
			} else {
				$q="INSERT INTO {$dbg}.70_patrons (`date`,`ucid`,`timein`,`timeout`,`logtimes`,`numlogs`,`subdepartment_id`) 
					VALUES ('$today','$ucid','$time','$time','$time','1','$dif'); ";
				$db->query($q);	
				$_SESSION['patron']['message']="$name Just logged in now.";				
				$_SESSION['libstats'][$dif]['total']++;
				
				$dcp=empty($dcp)? 'empl':$dcp;				
				/* 2 */
				// incrementNumvisitorsByDept($db,$today,$deptcode);
			}			
			$_SESSION['patron']['photo']=$person['photo'];
			redirect($url);			
		} else {
			$_SESSION['message']="No Student found. ID Number - $code ";			
			redirect($url);		
		}
		exit;
	}	/* submit */
		
	
	$vpath = SITE.'views/customs/'.VCFOLDER.'/patron_visitxxx.php';		
	if(is_readable($vpath)){ $vfile="/customs/".VCFOLDER."/patron_visit";	
	} else { $vfile="patrons/patron_visit"; }
	
	// unset($_SESSION['user']);
	// unset($_SESSION['settings']);
	// unset($_SESSION['actions']);
	// unset($_SESSION['axn']);
	// unset($_SESSION['classrooms']);
	// unset($_SESSION['levels']);
	// pr($_SESSION);
	// pr($_SESSION['libstats']);
	
	$data['subdepts']=$_SESSION['subdepts'];	
	// pr($dif);
	$this->view->render($data,$vfile,'library');
	
}	/* fxn */	

























}	/* PatronController */
