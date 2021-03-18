<?php

Class TranscriptsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();	
}	/* fxn */

public function beforeFilter(){
	$this->view->css = array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
}	/* fxn */


public function index(){
	
	echo "<a href='".URL."transcripts/scid'>Transcript</a><br />";
	echo "<a href='".URL."transcripts/loyalty'>Loyalty</a><br />";
	echo "<a href='".URL."transcripts/crids'>Crids</a><br />";
	echo "<a href='".URL."transcripts/testData'>Test Data</a><br />";
	
	
	
	
}	/* fxn */

public function loyalty(){
	
	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT en.*, count(en.scid) AS num,c.code AS studcode,c.name AS studname
		FROM {$dbo}.05_enrollments AS en
		INNER JOIN {$dbo}.00_contacts AS c ON c.id = en.scid		
		GROUP BY en.scid ORDER BY num DESC LIMIT 30;";
	
	pr($q);
	
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	
	$this->view->render($data,'transcripts/loyaltyTranscripts');
	
	
}	/* fxn */


public function crids($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	if(!$scid){ pr('Student ID parameter required.'); }

	$db=&$this->baseModel->db;$dbo=PDBO;	
	$q="SELECT en.*,cr.name AS classroom,c.code AS studcode,c.name AS studname
		FROM {$dbo}.05_enrollments AS en
		INNER JOIN {$dbo}.00_contacts AS c ON en.scid=c.id
		INNER JOIN {$dbo}.05_base_classrooms AS cr ON en.crid=cr.id
		WHERE en.scid=$scid
		ORDER BY en.sy;		
	";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	
	$this->view->render($data,'transcripts/cridsTranscripts');
	
	
}	/* fxn */

public function testData(){	
	$db=&$this->baseModel->db;$dbo=PDBO;
	
	$q="
		SELECT en.id AS enid,en.scid,c.code AS studcode,c.name AS studname,cr.name AS classroom,en.sy
		FROM {$dbo}.05_enrollments AS en
		INNER JOIN {$dbo}.05_base_classrooms AS cr ON en.crid=cr.id
		INNER JOIN {$dbo}.00_contacts AS c ON en.scid=c.id
		WHERE cr.level_id>3 AND cr.level_id<1 AND 			
		ORDER BY cr.level_id,c.name LIMIT 20;	
	";
	


	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,'transcripts/indexTranscripts');
	
	
	
}	/* fxn */


public function scidData($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	if(!$scid){ pr('Student ID parameter required.'); }
	reqFxn('transcriptFxn');
	// reqFxn('databaseFxn');
	$db=&$this->baseModel->db;$dbo=PDBO;
if($scid):	
	// $data['profile']=fetchRecord($db,"{$dbo}.`00_profiles`","contact_id=$scid");
	// $data1=getStudentInfo($db,$scid);
	// $data['data1']=$data1=getStudentInfo($db,$scid);
	$data['data1']=$data1=getProfileForTranscript($db,$scid);
	$data=array_merge($data,$data1);
	$data['student']=array_merge($data['student'],$data['profile']);
	$d=getEnrollmentsByScid($db,$scid,"DESC");
	$data['years']=$years=$d['rows'];
	$data['iyears']=$iyears=$d['count'];		
	$classrooms=array();$attdmonths=array();$attendances=array();$grades=array();$counts=array();
	$data['month_names']=$month_names=fetchRows($db,"{$dbo}.05_months_quarters",'*','`index`',' WHERE quarter<>0');	
	$data['num_months']=count($month_names);

		
	for($i=0;$i<$iyears;$i++){
		$sy=$years[$i]['sy'];$crid=$years[$i]['crid'];
		$dbg=VCPREFIX.$sy.US.DBG;
		$classrooms[$i]=getClassroomInfo($db,$dbg,$crid);
		$grades[$i]=getGradesByEnrollment($db,$dbg,$scid);
		$lvl=$classrooms[$i]['level_id'];
		$attdmonths[$i]=AttendanceMonths($db,$lvl,$sy,$dbg);			
		$attendances[$i]=getAttendanceByEnrollment($db,$dbg,$scid);		
		$counts[$i]=count($grades[$i]);

	}	/* fxn */
	
	// $data['']
	$data['attdmonths']=&$attdmonths;$data['attendances']=&$attendances;$data['grades']=&$grades;$data['counts']=&$counts;$data['classrooms']=&$classrooms;
endif;


	$static=isset($_GET['static'])? "Static":NULL;
	$vfile="transcripts/scidTranscript{$static}";vfile($vfile);	
	$this->view->render($data,$vfile,'empty');
	
}	/* fxn */



public function scid1($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	if(!$scid){ pr('Student ID parameter required.'); }
	reqFxn('transcriptFxn');
	$db=&$this->baseModel->db;$dbo=PDBO;
if($scid):	
	$data['data1']=$data1=getProfileForTranscript($db,$scid);
	$data=array_merge($data,$data1);
	// $data['student']=array_merge($data['student'],$data['profile']);
	$d=getEnrollmentsByScid($db,$scid,"DESC");
	$data['years']=$years=$d['rows'];
	$data['iyears']=$iyears=$d['count'];		
	$classrooms=array();$attdmonths=array();$attendances=array();$grades=array();$counts=array();
	$data['month_names']=$month_names=fetchRows($db,"{$dbo}.05_months_quarters",'*','`index`',' WHERE quarter<>0');	
	$data['num_months']=count($month_names);

		
	for($i=0;$i<$iyears;$i++){
		$sy=$years[$i]['sy'];$crid=$years[$i]['crid'];
		$dbg=VCPREFIX.$sy.US.DBG;
		$classrooms[$i]=getClassroomInfo($db,$dbg,$crid);
		// $grades[$i]=getGradesByEnrollment($db,$dbg,$scid);
		// $lvl=$classrooms[$i]['level_id'];
		// $attdmonths[$i]=AttendanceMonths($db,$lvl,$sy,$dbg);			
		// $attendances[$i]=getAttendanceByEnrollment($db,$dbg,$scid);		
		// $counts[$i]=count($grades[$i]);

	}	/* fxn */
	
	$data['classrooms']=&$classrooms;
	// $data['attdmonths']=&$attdmonths;$data['attendances']=&$attendances;$data['grades']=&$grades;$data['counts']=&$counts;$data['classrooms']=&$classrooms;
endif;


	$static=isset($_GET['static'])? "Static":NULL;
	$vfile="transcripts/scidTranscript{$static}";vfile($vfile);	
	$this->view->render($data,$vfile,'empty');
	
}	/* fxn */



public function scid($params=NULL){
	$this->view->css = array('style_long.css','tailwind.css');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['decicard']=(isset($_GET['deci']))? $_GET['deci']:$_SESSION['settings']['decicard'];
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	require_once(SITE."functions/transcriptFxn.php");
	require_once(SITE."views/customs/{$sch}/funcs/transcriptCustomFxn_{$sch}.php");
	$db=&$this->baseModel->db;$dbo=PDBO;
if($scid):	
	$data1['profile']=getProfileForTranscript($db,$scid);
	$data=array_merge($data,$data1);
		
	$data2=getEnrollmentSummaryByStudent($db,$scid,$sy_order="ASC");
	$data=array_merge($data,$data2);
	
	$data3=groupEnrollmentLevels($data['ensumm']);
	$data=array_merge($data,$data3);
	
	$ensumm=$data['ensumm'];
	$ensumm_count=$data['ensumm_count'];
	
	$grades=array();
	for($i=0;$i<$ensumm_count;$i++){
		// 1 - grades
		if($ensumm[$i]['lvl']>13){
			$grades[$i]['sem1']=getStudentGrades_shs($db,$ensumm[$i]['sy'],$ensumm[$i]['crid'],$scid,$sem=1);
			$grades[$i]['sem2']=getStudentGrades_shs($db,$ensumm[$i]['sy'],$ensumm[$i]['crid'],$scid,$sem=2);
		} else if($ensumm[$i]['lvl']>9){
			$grades[$i]=getStudentGrades_jhs($db,$ensumm[$i]['sy'],$scid);
		} else if($ensumm[$i]['lvl']>6){
			$grades[$i]=getStudentGrades($db,$ensumm[$i]['sy'],$scid);			
		}	
		// 2 - attendance
		$data['attdmonths'][$i]=getAttendanceMonths($db,$ensumm[$i]['lvl'],$ensumm[$i]['sy']);			
		$data['attendance'][$i]=getAttendanceByStudent($db,$ensumm[$i]['sy'],$scid);		
		
	}	/* for */

	$data4['grades']=$grades;
	$data=array_merge($data,$data4);
	
	// prx($data);	
	// $data['attdmonths']=&$attdmonths;
	// $data['attendances']=&$attendances;
	// $data['classrooms']=&$classrooms;
	
endif;	/* scid */


	$static=isset($_GET['static'])? "Static":NULL;
	$vfile="transcripts/scidTranscript{$static}";vfile($vfile);	
	$this->view->render($data,$vfile);
	
}	/* fxn */







}	/* BlankController */
