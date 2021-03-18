<?php

Class UnischedulesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Unischedules";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function crs($params=NULL){
$dbo=PDBO;
	// if(!isset($params[0])){ pr("Course ID Not set."); }
	$data['crs']=$crs=isset($params[0])? $params[0]:false;
	
if($crs):	
	$db=&$this->baseModel->db;$dbg=PDBG;
	require_once(SITE.'functions/unidetailsFxn.php');	
	// $data['course']=getUnicourseDetails($db,$crs,$dbg);
	$data['course']=fetchRow($db,"{$dbg}.01_courses",$crs,"id,name");
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->createIfNotExists("{$dbg}.01_schedules",$post);
		flashRedirect("unischedules/crs/$crs","Added.");exit;		
	}	/* post */
	
	$q="SELECT s.*,d.name AS day,t.id,t.name AS time,s.id AS sid,d.id
		FROM {$dbg}.01_schedules AS s
		INNER JOIN {$dbg}.01_days AS d ON s.day_id=d.id
		INNER JOIN {$dbg}.01_times AS t ON s.time_id=t.id
		WHERE course_id='$crs';";
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$data['is_empty']=$is_empty=(empty($rows))? true:false;
	$data['days']=fetchRows($db,"{$dbg}.01_days","*","id"); 
	$data['times']=fetchRows($db,"{$dbg}.01_times","*","name"); 
	// if(!isset($_SESSION['unidays'])){ $_SESSION['unidays']=fetchRows($db,"{$dbg}.01_days","*","id"); }
	// if(!isset($_SESSION['unitimes'])){ $_SESSION['unitimes']=fetchRows($db,"{$dbg}.01_times","*","name"); }
	// $data['days']=$_SESSION['unidays'];
	// $data['times']=$_SESSION['unitimes'];
endif;	/* params0 */	
	// $data=isset($data)? $data:NULL;
	$this->view->render($data,"unischedules/crsUnischedule");
	
}	/* fxn */


public function crid($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	require_once(SITE.'functions/unidetailsFxn.php');	
	$data['cr']=$cr=fetchRow($db,"{$dbg}.01_classrooms",$crid,"id,name");	
	$q="SELECT crs.id,crs.id AS crs,crs.crid,crs.name AS course,crs.schedule,crs.level_id,crs.semester,c.name AS teacher
		FROM {$dbg}.01_courses AS crs
		LEFT JOIN {$dbg}.01_schedules AS sk ON sk.course_id=crs.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
		WHERE crs.crid='$crid'		
		GROUP BY crs.id ORDER BY crs.level_id,crs,semester; ";
	debug($q);			
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$this->view->render($data,"unischedules/cridUnischedule");
	
}	/* fxn */



public function upsched(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="UPDATE {$dbg}.01_courses AS c1 
	INNER JOIN (
		SELECT crs.id,GROUP_CONCAT(d.code,' ',t.name ORDER BY d.id SEPARATOR ', ') AS schedules							
		FROM {$dbg}.01_courses AS crs
		LEFT JOIN {$dbg}.01_schedules AS sk ON sk.course_id=crs.id
		LEFT JOIN {$dbg}.01_days AS d ON sk.day_id=d.id
		LEFT JOIN {$dbg}.01_times AS t ON sk.time_id=t.id		
		GROUP BY crs.id 	
	) AS c2 ON c2.id=c1.id
	SET c1.schedule=c2.schedules; ";
	// pr($q);
	debug($q);
	$sth=$db->query($q);
	echo ($sth)? "Success":"Fail";
	
	
	
}	/* fxn */




public function conflict(){
$dbo=PDBO;
/* $a = 'How are you?';
if (strpos($a,"are")!==false) { echo 'IN it';
} else { echo "NOT inside"; }
 */
	
	echo "unischedule test conflict";
	
	// $this->view->render($data,'abc/defaultAbc');
	$data['scid']=$scid=111;
	$db=&$this->baseModel->db;$dbo=PDBO;
	
/* 	
	$a="0800";$b="0900";
	$c="0900";$d="1200"; 
*/
	
	$a="0800"; $b="1200";

	$c="0900"; $d="1000"; 
	
	// echo date('H:i:s',strtotime($a));
	pr($a);
	$t1=date('H:i:s',strtotime($a));	
	$t2=date('H:i:s',strtotime($b));	
	
	$t3=date('H:i:s',strtotime($c));	
	$t4=date('H:i:s',strtotime($d));	

	$conflict=false;
	if($t1>$t3){
		if($t1<=$t4){
			$conflict=true;			
		}		
	}	/* one */

	if($t2>$t3){
		if($t2<=$t4){
			$conflict=true;			
		}		
	}	/* one */
	

	echo ($conflict)? "HAS conflict":"NO conflict";	
	exit;
	

	$q="SELECT * FROM {$dbo}.00_schedules ORDER BY time_beg; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	debug($data['rows'][0]);
	
	$this->view->render($data,'abc/scheduleAbc');
	
	
	
}	/* fxn */





}	/* BlankController */
