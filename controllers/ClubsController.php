<?php

Class ClubsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}

public function index(){
	$dbo=PDBO;
	$db=&$this->model->db;
	$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['tcid']=$tcid=$_SESSION['user']['ucid'];
	$data['clubs']=$_SESSION['teacher']['clubs'];
	$this->view->render($data,'clubs/indexClubs');	
	
}	/* fxn */



public function all(){ 
	$dbo=PDBO;
	require_once(SITE.'functions/clubsFxn.php');
	$acl = array(array(5,0),array(4,0),array(6,0),array(9,0));
	$this->permit($acl);				
	$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;		
	$order=isset($_GET['order'])? $_GET['order']:"cl.name";
	$data['rows']=getClubs($db,$dbg,$order);
	$data['count']=count($data['rows']);
	$vfile="clubs/allClubs";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function members($params){
	require_once(SITE.'functions/clubsFxn.php');
	$data['club_id']=$club_id=$params[0];	
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	
	$db=&$this->model->db;	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	$data['club']=getClubDetails($db,$dbg,$club_id);		
	$allowed_roles=array(RMIS,RREG,RACAD);
	$is_allowed=canAccessClub($db,$data['club'],$allowed_roles);
	if($is_allowed){
		$data['rows']=getClubMembers($db,$dbg,$club_id);
		$data['count']=count($data['rows']);	
	} else { flashRedirect(UNAUTH); }

	$this->view->render($data,'clubs/membersClubs');	

}	/* fxn */


public function membersCrs($params){
	require_once(SITE.'functions/clubsFxn.php');
	$data['club_id']=$club_id=$params[0];	
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	
	$db=&$this->model->db;	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	$data['club']=getClubDetails($db,$dbg,$club_id);		
	$allowed_roles=array(RMIS,RREG,RACAD);
	$is_allowed=canAccessClub($db,$data['club'],$allowed_roles);
	if($is_allowed){
		$data['rows']=getClubMembersCrs($db,$dbg,$club_id);
		$data['count']=count($data['rows']);	
	} else { flashRedirect(UNAUTH); }
	
	
	$this->view->render($data,'clubs/membersCrsClubs');	

}	/* fxn */

public function moderator($params){
	require_once(SITE.'functions/clubsFxn.php');
	$data['club_id']=$club_id=$params[0];
	$dbo=PDBO;$dbg=PDBG;
	$db=&$this->model->db;		
	if(isset($_POST['submit'])){
		$tcid=$_POST['post']['tcid'];
		$name=$_POST['post']['name'];
		$q="UPDATE {$dbg}.05_clubs SET `tcid`=:tcid,`name`=:name WHERE `id`='$club_id' LIMIT 1; ";
		$sth = $db->prepare($q);		
		$sth->bindValue(":tcid",$tcid);
		$sth->bindValue(":name",$name);
		$sth->execute();
		flashRedirect("clubs/moderator/$club_id","Edited.");				
	}
	
	$data['row']=getClubDetails($db,$dbg,$club_id);
	$this->view->render($data,'clubs/moderatorClubs');	

}	/* fxn */

public function batch($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'functions/clubsFxn.php');	
	$data['club_id']=$club_id=isset($params[0])? $params[0]:false;	
	$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
		
if(isset($_POST['add'])){
	$posts = $_POST['posts'];		
	$q = "";
	foreach($posts AS $code){
		$empty = (empty($code))? true:false;
		if(!$empty){
			$code = preg_replace("([^A-Za-z0-9-/])", "", $code);	
			$qry = "SELECT id AS scid FROM {$dbo}.`00_contacts` WHERE `code` = '$code' LIMIT 1;";
			$sth = $db->querysoc($qry);
			$row = $sth->fetch();			
			if($row){
				$scid=$row['scid'];
				$q.= studentToClub($db,$dbg,$scid,$club_id);
			}	
		}		
	}	
	$db->query($q);	
	
	/* 2 sync clubcourse_id */
	syncClubcourse($db,$dbg,$club_id);
	
	$url = "clubs/batch/$club_id/$sy";
	flashRedirect($url,'Batch Club Registration processed.');	
	exit;

}	/* post */
	
	
	$data['club']=getClubDetails($db,$dbg,$club_id);		
	$data['rows']=getClubMembers($db,$dbg,$club_id);		
	$data['count']=count($data['rows']);
	$this->view->render($data,'clubs/batchClubs');


}	/* fxn */

public function syncClubcourse($params){
	$dbo=PDBO;
	require_once(SITE.'functions/clubsFxn.php');	
	$data['club_id']=$club_id=isset($params[0])? $params[0]:false;	
	$db=&$this->model->db;$dbg=PDBG;	
	/* sync clubcourse_id */
	syncClubcourse($db,$dbg,$club_id);
	flashRedirect("index/blank","Sync Club Course Grades.");
	
}	/* fxn */

public function scores($params){
	$dbo=PDBO;
	$club_id=$params[0];
	$data['club_id']=$club_id;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->model->db;	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;	
	if($sy==DBYR){
		$data['clubcriteria']=isset($_SESSION['clubcriteria'])? 
			$_SESSION['clubcriteria']:$_SESSION['clubcriteria']=fetchRows($db,"{$dbg}.05_clubcriteria","*","id");	
	} else {
		$data['clubcriteria']=fetchRows($db,"{$dbg}.05_clubcriteria","*","id");				
	}
	
	require_once(SITE.'functions/clubsFxn.php');	
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$data['club']=getClubDetails($db,$dbg,$club_id);
	$allowed_roles=array(RMIS,RREG,RACAD);
	$is_allowed=canAccessClub($db,$data['club'],$allowed_roles);

	if(isset($_POST['finalize'])){		
		/* 1 - tally total grades */		
		updateClubGrades($db,$dbg,$sch,$club_id,$qtr);
		
		// 2
		$q="UPDATE {$dbg}.05_clubs SET is_finalized_q{$qtr}=1 WHERE id='$club_id' LIMIT 1; ";				
		// pr($q);exit;
		$db->query($q);
		$url="clubs/scores/$club_id/$sy/$qtr";
		flashRedirect($url,"Club Finalized.");		
	}	/* lock */

	
	if($is_allowed){
		$data['rows']=clubScores($db,$dbg,$club_id,$qtr,$sch);
		$data['count']=count($data['rows']);
	} else { flashRedirect(UNAUTH); }
	$is_complete=isCompleteClubscores($db,$dbg,$club_id,$qtr,$sch);
	if(!$is_complete){ echo "<h3 class='brown' >Synced. Refresh page.</h3>"; syncClubscores($db,$dbg,$club_id,$qtr,$sch); }
	
	$one="clubs/scoresClubs";
	$two="clubs/scoresClubs";
	$vfile=cview($one,$two); vfile($vfile);	
		
	$this->view->render($data,$vfile);
}	/* fxn */


public function syncScores($params){
	$dbo=PDBO;
	$club_id=$params[0];
	$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;	
	require_once(SITE.'functions/clubsFxn.php');
	syncClubscores($db,$dbg,$club_id,$qtr,$sch);
}	/* fxn */

public function editColumn($params){
	$dbo=PDBO;
	$data['club_id']=$club_id=$params[0];
	$data['cri']=$cri=$params[1];
	$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;
	require_once(SITE.'functions/clubsFxn.php');
	
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;		
	$data['rows']=clubScores($db,$dbg,$club_id,$qtr,$sch);		
	$data['count']=count($data['rows']);
	
	$data['clubcriteria']=isset($_SESSION['clubcriteria'])? 
		$_SESSION['clubcriteria']:$_SESSION['clubcriteria']=fetchRows($db,"{$dbg}.05_clubcriteria","*","id");	
	
	if(isset($_POST['submit'])){
		/* 1 update column clubscores */
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.50_clubscores_{$sch} SET `cri{$cri}`='".$post['score']."',
				`total`=(`cri1`+`cri2`+`cri3`) WHERE `id`='".$post['score_id']."' LIMIT 1; ";
		}
		// pr($q);exit;
		$db->query($q);
		
		/* 2 tally total grades */		
		updateClubGrades($db,$dbg,$sch,$club_id,$qtr);
		
		/* 3 redirect */
		flashRedirect("clubs/scores/$club_id?qtr=$qtr","Club scores saved.");
		
		exit;
	}

	$data['crirow']=$data['clubcriteria'][$cri-1];		
	$this->view->render($data,'clubs/editColumnClubs');

}	/* fxn */

public function edit($params){
	$dbo=PDBO;
	$acl = array(array(5,0),array(4,0),array(6,0));
	$this->permit($acl);				
	
	$db=&$this->model->db;$dbg=PDBG;	
	$club_id=$params[0];
	if(isset($_POST['submit'])){
		$post=$_POST;unset($post['submit']);
		$db->update("{$dbg}.05_clubs",$post," `id` = '$club_id'  ");
		$url="clubs/edit/$club_id";
		flashRedirect($url,'Club edited.');		
	}	/* post */
	
	$q="SELECT cl.*,c.name AS teacher FROM {$dbg}.05_clubs AS cl 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=cl.tcid WHERE cl.id='$club_id' LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	$this->view->render($data,'clubs/editClub');
}	/* fxn */

public function tagging($params){
	$data['club_id']=$club_id=$params[0];
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	require_once(SITE.'functions/clubsFxn.php');		
	$data['club']=getClubDetails($db,$dbg,$club_id);		
	
	$is_allowed=canAccessClub($db,$data['club']);
	if($is_allowed){
		$data['rows']=getClubMembers($db,$dbg,$club_id);		
		$data['count']=count($data['rows']);		
	} else { flashRedirect(UNAUTH); }
	$this->view->render($data,'clubs/taggingClubs');

}	/* fxn */

public function deleteClubMembersScores($params){
	$data['club_id']=$club_id=$params[0];
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;$sch=VCFOLDER;
	require_once(SITE.'functions/clubsFxn.php');		
	$data['rows']=getClubMembers($db,$dbg,$club_id);		
	$scids=buildArray($data['rows'],'scid');$q="";
	foreach($scids AS $scid){
		$q.="DELETE FROM {$dbg}.50_clubscores_{$sch} WHERE scid='$scid'; ";
		$q.="UPDATE {$dbg}.05_summaries SET club_id=0 WHERE `scid`='$scid' LIMIT 1; ";
	}
	pr($q);
	$url="clubs/deleteClubMembersScores/{$club_id}?exe";
	if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
	} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}		
	

}	/* fxn */

public function grades($params){

	require_once(SITE.'functions/clubsFxn.php');
	$data['club_id']=$club_id=$params[0];

	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->model->db;	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	
		
	$data['is_dg']=$is_dg=isset($_GET['dg'])? true:false;
	$data['dgparams']=$dgparams=isset($_GET['dg'])? '&dg':NULL;
	$data['colvar']=$colvar=($is_dg)? 'dg':'q';
			
	if(isset($_POST['finalize'])){
		// 1
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.50_grades SET {$colvar}{$qtr} = '".$post['grade']."' WHERE id='".$post['gid']."' LIMIT 1; ";
		}
		$db->query($q);		
		// 2
		$q="UPDATE {$dbg}.05_clubs SET is_finalized_q{$qtr}=1 WHERE id='$club_id' LIMIT 1; ";				
		$db->query($q);
		$url="clubs/grades/$club_id/$sy/$qtr{$dgparams}";
		flashRedirect($url,"Club Finalized.");		
	}	/* lock */
		
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.50_grades SET {$colvar}{$qtr} = '".$post['grade']."' WHERE id='".$post['gid']."' LIMIT 1; ";
		}
		$db->query($q);
		$url="clubs/grades/$club_id/$sy/$qtr{$dgparams}";
		flashRedirect($url,"Grades saved.");
		
	}	/* post */
		
	$data['club']=getClubDetails($db,$dbg,$club_id);	
	$allowed_roles=array(RMIS,RREG,RACAD);
	$is_allowed=canAccessClub($db,$data['club'],$allowed_roles);
	
	if($is_allowed){
		$data['rows']=clubGrades($db,$dbg,$club_id,$qtr,$is_dg);
		
		// prx($data['rows']);
		
		$data['count']=count($data['rows']);	
	} else { flashRedirect(UNAUTH); }


	$is_complete=isCompleteClubgrades($db,$dbg,$club_id);	
	if(!$is_complete){ echo "<h3 class='brown' >Incomplete, sync or has duplicate students.</h3>"; 
		echo "<p style='padding-left:24px;' ><a href='".URL."clubs/membersCrs/".$club_id."' >Members Course</a></p>";
		$q="SELECT summ.scid FROM {$dbg}.05_summaries AS summ WHERE summ.club_id=$club_id; ";
		$sth=$db->querysoc($q);
		$members=$sth->fetchAll();		
		$ar=buildArray($members,'scid');
		$br=buildArray($data['rows'],'scid');	
		$ix=array_diff($ar,$br);
		pr($ix);
		echo "<hr />";
		$jx=array_diff($br,$ar);
		pr($jx);		
	} 	/* complete */
	$vfile="clubs/gradesClubs";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */

public function syncClubGrades($params){
	$dbo=PDBO;
	require_once(SITE.'functions/clubsFxn.php');
	$data['club_id']=$club_id=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->model->db;$dbg=PDBG;
	$data['is_dg']=$is_dg=isset($_GET['dg'])? true:false;
	$data['dgparams']=$dgparams=isset($_GET['dg'])? '&dg':NULL;
	$data['colvar']=$colvar=($is_dg)? 'dg':'q';
	$is_complete=isCompleteClubgrades($db,$dbg,$club_id);
	if(!$is_complete){ 
		// echo "Not complete club grades, need to sync.";
		echo "<h3 class='brown' >Synced. Refresh page.</h3>"; syncClubgrades($db,$dbg,$club_id); 
	}
	syncClubcourse($db,$dbg,$club_id);
	syncGradesCrs($db,$dbg,$club_id);	

	$this->view->render($data,'clubs/syncClub');
	
}	/* fxn */

public function purgeClubGrades($params){
	$dbo=PDBO;
	require_once(SITE.'functions/clubsFxn.php');
	$db=&$this->model->db;$dbg=PDBG;$club_id=$params[0];
	purgeClubGrades($db,$dbg,$club_id);	

}	/* fxn */

public function updateClubGrades($params){
	$dbo=PDBO;
	require_once(SITE.'functions/clubsFxn.php');
	$db=&$this->model->db;$dbg=PDBG;$club_id=$params[0];
	$sch=VCFOLDER;$qtr=$_SESSION['qtr'];
	updateClubGrades($db,$dbg,$sch,$club_id,$qtr);

}	/* fxn */


public function student($params=NULL){
	require_once(SITE.'functions/clubsFxn.php');
	$db=&$this->model->db;$sch=VCFOLDER;	
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	

if(isset($_POST['submit'])){
	$score=$_POST['score'];
	$grade=$_POST['grade'];
	$grade['q'.$qtr]=$score['total'];
	$total=$score['total'];
	$crs=$grade['crs'];
	$club_id=$_POST['club_id'];
	$score_id=$_POST['score_id'];

	/* 1 */
	$db->update("{$dbg}.50_clubscores_{$sch}",$score,"id='$score_id'");
	/* 2 */
	$q="UPDATE {$dbg}.50_grades SET q{$qtr}='$total' WHERE scid='$scid' AND course_id='$crs' LIMIT 1;";
	$db->query($q);
	/* 3 */
	$url="clubs/student/$scid/$sy/$qtr";
	flashRedirect($url,"Club scores updated.");	
	exit;	
}	/* post */

	/* process2 */
	if($scid){
		$q="SELECT summ.clubcourse_id,summ.club_id,sc.*,c.name AS student,c.`code` AS `studcode`,sc.id AS `score_id`,
			crs.id AS crs,crs.name AS course,g.q{$qtr},cl.id AS club_id,cl.name AS club  
			FROM {$dbg}.`50_clubscores_sjam` AS sc 
			INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=sc.scid 
			INNER JOIN {$dbg}.`05_summaries` AS summ ON c.id=summ.scid 
			INNER JOIN {$dbg}.`50_grades` AS g ON summ.scid=g.scid 
			INNER JOIN {$dbg}.`05_courses` AS crs ON g.course_id=crs.id 
			INNER JOIN {$dbg}.`05_clubs` AS cl ON summ.club_id=cl.id 		
			WHERE crs.crstype_id=3 AND sc.`qtr`='$qtr' AND summ.`scid`='$scid'; ";		
		$sth=$db->querysoc($q);
		$data['grade']=$sth->fetch();
	
	}	/* scid */

$vfile="customs/{$sch}/clubs/studentClubs";
$data['row']=getStudentClubscores($db,$dbg,$sch,$scid,$qtr);
	
// pr($data);	
$this->view->render($data,$vfile);

}	/* fxn */


public function cridscores($params){
	require_once(SITE.'functions/clubsFxn.php');
	require_once(SITE.'functions/details.php');
	$db=&$this->model->db;$sch=VCFOLDER;	
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	
	/* 1 acl */	
	$data['srid']=$srid=$_SESSION['srid'];
	$allowed = array(RMIS,RREG,RACAD,RADMIN,RTEAC);
	if(!in_array($srid,$allowed)){ flashRedirect($home); }	
	$adroles=array(RMIS,RREG,RACAD,RADMIN);
	$data['is_admin']=$is_admin=(in_array($srid,$adroles))? true:false;
	
if($_SESSION['srid']==RTEAC){ 
	if($_SESSION['user']['privilege_id']>0 && !in_array($crid,$_SESSION['teacher']['advisory_ids'])){ flashRedirect(); } 
}
	
	if(isset($_POST['submit'])){
		$q="";$posts=$_POST['posts'];		
		foreach($posts AS $post){
			$gid=$post['gid'];$total=$post['total'];
			$q.="UPDATE {$dbg}.50_grades SET `q{$qtr}`='$total' WHERE id='$gid' LIMIT 1; ";		
		}
		$sth=$db->query($q);
		$msg=($sth)? "Updated":"Failed";
		flashRedirect("clubs/cridscores/$crid",$msg);		
		exit;
	}
	
	/* 2 */
	$q="SELECT g.id AS gid,summ.clubcourse_id,summ.club_id,sc.*,c.name AS student,c.`code` AS `studcode`,sc.id AS `score_id`,
		crs.id AS crs,g.q{$qtr},cl.id AS club_id,cl.name AS club 
		FROM {$dbg}.`50_clubscores_sjam` AS sc 
		INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=sc.scid 
		INNER JOIN {$dbg}.`05_summaries` AS summ ON c.id=summ.scid 
		INNER JOIN {$dbg}.`50_grades` AS g ON summ.scid=g.scid 
		INNER JOIN {$dbg}.`05_courses` AS crs ON g.course_id=crs.id 
		INNER JOIN {$dbg}.`05_clubs` AS cl ON summ.club_id=cl.id 
		WHERE crs.crstype_id=3 AND sc.`qtr`=$qtr AND summ.`crid`='$crid' ORDER BY c.is_male DESC,c.name; ";		
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$data['cr']=getClassroomDetails($db,$crid);
	
	
	$data['clubcriteria']=isset($_SESSION['clubcriteria'])? 
		$_SESSION['clubcriteria']:$_SESSION['clubcriteria']=fetchRows($db,"{$dbg}.05_clubcriteria","*","id");	
	$vfile="customs/{$sch}/clubs/cridscoresClubs";vfile($vfile);
	$this->view->render($data,$vfile);


}	/* fxn */


public function checker($params=NULL){
	$data['club_id']=$club_id=$params[0];
	$db=$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
	$data['club']=fetchRow($db,"{$dbg}.05_clubs",$club_id);
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
		
	if(isset($_POST['submit'])){
		
		if(!empty($_POST)){
			$q="";
			$posts=$_POST['posts'];
			foreach($posts AS $post){
				$scid=$post['scid'];
				$clubcrs=$post['clubcrs'];
				$q.="UPDATE {$dbg}.05_summaries SET clubcourse_id=$clubcrs WHERE scid=$scid LIMIT 1;";
			}
			$db->query($q);
			flashRedirect("clubs/checker/$club_id","Synced");
			
		}
		
		exit;
		
	}	/* post */
		
	$q="SELECT c.name,summ.id,summ.scid,summ.crid AS summcrid,summ.clubcourse_id AS summclubcrs,
			crs.id AS clubcrs,g.course_id AS grclubcrs			
		FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN ( SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id=3 ) AS crs ON summ.crid=crs.crid 		
		INNER JOIN ( 
			SELECT b.course_id FROM {$dbg}.05_summaries AS a
			LEFT JOIN {$dbg}.50_grades AS b ON a.scid=b.scid
			LEFT JOIN {$dbg}.05_courses AS c ON b.course_id=c.id 
			WHERE a.club_id=$club_id AND b.crstype_id=3 		
		) AS g ON g.course_id=crs.id 		
		
		WHERE summ.club_id='$club_id' AND c.is_active=1 
		ORDER BY c.is_male DESC,c.name;";


	$q="SELECT c.name,summ.id,summ.scid,summ.crid AS summcrid,summ.clubcourse_id AS summclubcrs,crs.id AS clubcrs,cr.name AS classroom 
		FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN 
		( SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id=3 
		) AS crs ON summ.crid=crs.crid 		
		WHERE summ.club_id='$club_id' AND c.is_active=1 
		ORDER BY c.is_male DESC,c.name;";



	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"clubs/checkerClub");

	
}	/* fxn */


public function studentClubChecker($params){
	$data['scid']=$scid=$params[0];
	$data['crid']=$crid=$params[1];
	$data['club_id']=$club_id=$params[2];
	$data['clubcrs']=$clubcrs=$params[3];

	pr($data);
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;

	echo "<hr />";	
	/* 1 */
	$q="SELECT club_id,clubcourse_id FROM {$dbg}.05_summaries WHERE scid=$scid LIMIT 1;";
	pr($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	// $data['clubcrs']=$clubcrs=$row['id'];
	pr($row);
	$summclubcrs=$row['clubcourse_id'];
	$str_params="$scid/$crid/$club_id/$clubcrs";
	
	
	if(!$summclubcrs){ 
		$q="UPDATE {$dbg}.05_summaries SET clubcourse_id=$clubcrs WHERE scid=$scid LIMIT 1; ";
		pr($q);
		if(!isset($_GET['exe'])){ echo "<a href='".URL."clubs/studentClubChecker/".$str_params."?exe' >Exe - update summclubcrs</a>"; 
		} else {
			$sth=$db->query($q);
			echo ($sth)? "Success":"Fail";			
		}
	}

	
	/* 2 */
	$q="SELECT id FROM {$dbg}.05_courses WHERE crid=$crid AND crstype_id=".CTYPECLUB." LIMIT 1;";
	pr($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$data['clubcrs']=$clubcrs=$row['id'];
	$has_clubcrs=($clubcrs)? true:false;
	if(!$has_clubcrs){ echo "No clubcrs for crid#$crid"; exit; }
	// $q="UPDATE {$dbg} ";
		

	/* 3 */	
	echo "<hr />";
	pr("?exe_grade");
	$q="SELECT id,course_id FROM {$dbg}.50_grades WHERE scid=$scid AND crstype_id=3;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$grade_id=$row['id'];
	$gradeclubcrs=$row['course_id'];
	pr($row);
	$same_clubcrs=($gradeclubcrs==$clubcrs)? true:false;
	
	pr($gradeclubcrs);
	pr($clubcrs);
	
	if(!$same_clubcrs){
		$q="UPDATE {$dbg}.50_grades SET course_id=$clubcrs WHERE id=$grade_id LIMIT 1; ";
		pr($q);
		if(isset($_GET['exe_grade'])){ 
			$sth=$db->query($q);
			echo ($sth)? "Success":"Fail";
		}		
	}
	
	
	
	
	
}	/* fxn */



public function notes(){
	$vfile="clubs/notesClubs";vfile($vfile);
	$this->view->render(NULL,$vfile);
}



public function updateAllGradesFromClubscores(){
	$dbo=PDBO;
	require_once(SITE.'functions/clubsFxn.php');	
	$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;	
	$data['clubs']=getClubs($db,$dbg,"cl.name");
	$data['club_ids']=buildArray($data['clubs'],'id');
	
	$stmt = "Done updating grades for Club ";
	foreach($data['club_ids'] AS $k => $club_id){
		updateClubGrades($db,$dbg,$sch,$club_id,$qtr);		
		$stmt.=" #{$club_id}, "; 			
	}
	$stmt=rtrim($stmt,", ");
	pr($stmt);
		
	
	
}	/* fxn */


// public function abc(){}




}	/* ClubsController */
