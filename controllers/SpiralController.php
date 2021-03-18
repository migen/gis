<?php
/**
 * 2010-2018@copyright MakolEngr. Go
*/

Class SpiralController extends Controller{	
public $layout='full';

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$acl = array(array(9,0),array(5,0),array(6,0),array(7,0),array(4,0));
	$this->permit($acl,$strict=false);			
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
}

public function crid($params){
$dbo=PDBO;
	reqFxn('classlists');
	require_once(SITE.'functions/spiralFxn.php');
	$data['crid']=$crid=$params[0];
	$data['sy']=$_SESSION['sy'];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$srid=$_SESSION['srid'];
	$ucid=$_SESSION['ucid'];
	$data['classroom']=$row=$this->model->getClassroom($dbg,$crid);
	if($srid==RTEAC){ if($row['acid']!=$ucid){ flashRedirect(UNAUTH,'Only class adviser allowed.');  }	 }
	$order=(isset($_GET['order']))? $_GET['order']:$_SESSION['settings']['classlist_order'];
	$rows=getClasslist($db,$dbg,$crid,$order,NULL,$is_active=1);
	$data['rows']=&$rows;
	$data['count']=count($rows);
	$components=getComponentCourses($db,$dbg,$crid);
	$num_components=count($components);
	$groups=array();
	$i=0;$x=0;
	foreach($components AS $component){	
		$groups[$x][]=$component;
		$j=$i+1;
		if($components[$i]['supsubject_id']!=@$components[$j]['supsubject_id']){  $x++; } 
		$i++;
	}
	$num_groups=count($groups);
	$data['num_groups']=&$num_groups;
	$numsub=array();
	for($i=0;$i<$num_groups;$i++){
		$count=count($groups[$i]);
		$numsub[$i]=$count;
		$supcrs=$groups[$i][0]['supcrs'];
		$groups[$i][$count]=getAggregateCourse($db,$dbg,$supcrs);		
	}
	$data['numsub']=&$numsub;
	$data['groups']=&$groups;
	$grades=array();
	for($i=0;$i<$num_groups;$i++){
		for($j=0;$j<=$numsub[$i];$j++){
			$crs=$groups[$i][$j]['crs'];
			$grades[$i][$j]=getCourseGrades($db,$dbg,$crid,$crs,$qtr,$order);
		}	
	}
	$data['grades']=&$grades;
	$this->view->render($data,'spiral/cridSpiral',$this->layout);
}	/* fxn */


}	/* SpiralController */
