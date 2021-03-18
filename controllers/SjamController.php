<?php

Class SjamController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$data=NULL;$this->view->render($data,'customs/sjam/indexSjam');
}	/* fxn */


public function primaryCoursesForHonors(){
$dbo=PDBO;

$dbg=PDBG;
$q=" UPDATE {$dbg}.05_courses AS crs
	SET crs.is_primary=1 WHERE crs.supsubject_id<1 AND crs.subject_id<>80;";
pr($q);


}	/* fxn */


public function levelRanks($params){
$dbo=PDBO;
	require_once(SITE.'functions/ranksFxn.php');
	require_once(SITE.'functions/sjam/sjamRanksFxn.php');
	$ssy=$_SESSION['sy'];
	$sqtr=$_SESSION['qtr'];
	$data['lvl']=$lvl=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$sqtr;
	$dbg=VCPREFIX.$sy.US.DBG;
	$db=&$this->baseModel->db;
	$d=getSjamLevelRanks($db,$dbg,$dbo,$lvl,$qtr);
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$sir=$post['rank'];
			$scid=$post['scid'];
			$q.="UPDATE {$dbg}.05_summext SET rank_level_ave_q{$qtr}='$sir' WHERE `scid`='$scid' LIMIT 1; ";			
		}
		$db->query($q);
		$url="sjam/levelRanks/$lvl/$sy/$qtr";
		flashRedirect($url,'Updated.');				
	}	/* posts */
	
	$one="ranks/sjamLevelRanks";$two="ranks/levelRanks";
	$vfile=cview($one,$two,$sch=VCFOLDER);		
	if(isset($_GET['vfile'])){ pr($vfile); }
	$this->view->render($data,$vfile);		
	
}	/* fxn */


	
public function gradHonors($params=array(9)){
$dbo=PDBO;
	require_once(SITE.'functions/details.php');
	require_once(SITE.'functions/ranksFxn.php');
	require_once(SITE.'functions/sjam/sjamGradFxn.php');
	$data['lvl']=$lvl=isset($params[0])? $params[0]:9;	
	$data['currlvl']=$lvl;
	$data['prevlvl']=$lvl-1;

	$ssy=$_SESSION['sy'];
	$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$db=&$this->baseModel->db;	
	
	$final=isset($_GET['final'])? 'final':NULL;
	
	/* 1 */
	$data['lrow']=getLevelDetails($db,$lvl,$dbg);	
	
	/* 2a */
	$d=getSjamGradHonors($db,$dbg,$dbo,$lvl,$fqtr=5,$final);
	$rows=$d['rows'];
	$data['rows']=&$rows;
	$data['count']=$d['count'];
		
	/* 2b */
	// if(!isset($_GET['final'])){ syncSjamGradHonors($db,$dbg,$dbo,$lvl,$rows); }
	
	if(isset($_POST['submit'])){
		syncSjamGradHonors($db,$dbg,$dbo,$lvl,$rows); 
		
		$posts=$_POST['posts'];
		if(isset($_GET['final'])){
			$q="";
			foreach($posts AS $post){			
				$scid=$post['scid'];
				$overall_place=$post['overall_place'];
				$q.="UPDATE {$dbg}.50_gradhonors_sjam SET `overall_place`='$overall_place' 
					WHERE scid='$scid' LIMIT 1;";				
			}
			$db->query($q);					
		} else {
			$q="";
			foreach($posts AS $post){			
				$scid=$post['scid'];
				$prev_acad=$post['prev_acad'];
				$prev_cond=$post['prev_cond'];
				$q.="UPDATE {$dbg}.50_gradhonors_sjam SET `prev_acad`='$prev_acad',`prev_cond`='$prev_cond' 
					WHERE scid='$scid' LIMIT 1;";
				
			}
			$db->query($q);		
			
			/* 2b */			
			$q="UPDATE {$dbg}.`50_gradhonors_sjam` SET total_acad=(`prev_acad`*0.3)+(`curr_acad`*0.7),
				`total_cond`=(`prev_cond`*0.3)+(`curr_cond`*0.7) WHERE `lvl`='$lvl';  ";
			$db->query($q);
			
			/* 2c */
			sortGradWeights($db,$dbg,$lvl);			
		}	/* not final */

		
		/*  */
		
		$url="sjam/gradHonors/$lvl?$final";
		flashRedirect($url,"Updated.");
		exit;
		
	}	/* post */
	



	$one="grad/sjamGradHonors";$two="grad/gradHonors";
	if(isset($_GET['print'])){ $one="grad/sjamGradHonorsPrint";$two="grad/gradHonorsPrint"; }
	$vfile=cview($one,$two,$sch=VCFOLDER);		
	if(isset($_GET['vfile'])){ pr($vfile); }
	
	$this->view->render($data,$vfile);		

}	/* fxn */




public function sirGrad($params=NULL){
	require_once(SITE.'functions/sirFxn.php');
	require_once(SITE.'functions/sjam/sjamGradFxn.php');
	$data['lvl']=$lvl=isset($params[0])? $params[0]:9;	
	$data['currlvl']=$lvl;
	$data['prevlvl']=$lvl-1;

	$ssy=$_SESSION['sy'];
	$sqtr=$_SESSION['qtr'];
	$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;	
	$db=&$this->baseModel->db;	
	/* types: acad,cond */	
	$data['type']=$type=isset($_GET['type'])? $_GET['type']:'acad';	
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		pr($posts);
		$q="";
		foreach($posts AS $post){
			$scid=$post['scid'];$rank=$post['rank'];
			$q.="UPDATE {$dbg}.50_gradhonors_sjam SET `rank_{$type}`='$rank' WHERE `scid`='$scid' LIMIT 1; ";			
		}
		$db->query($q);
		$url="sjam/sirGrad/$lvl?type={$type}";
		flashRedirect($url,'Ranks updated.');
		
	}	/* post */
	
	$d=getSjamRanks($db,$dbg,$dbo,$lvl,$type);	
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];
	$data['rows']=getSir($data['rows']);	
	

	$vfile="customs/sjam/grad/sjamSirGrad";	
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function sirGradTotal($params=NULL){
	require_once(SITE.'functions/sirAscFxn.php');
	// require_once(SITE.'functions/sirFxn.php');
	require_once(SITE.'functions/sjam/sjamGradFxn.php');
	$data['lvl']=$lvl=isset($params[0])? $params[0]:9;	
	$data['currlvl']=$lvl;
	$data['prevlvl']=$lvl-1;

	$ssy=$_SESSION['sy'];
	$sqtr=$_SESSION['qtr'];
	$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;	
	$db=&$this->baseModel->db;	
	/* types: acad,cond */	
	$data['type']=$type=isset($_GET['type'])? $_GET['type']:'acad';	
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		pr($posts);
		$q="";
		foreach($posts AS $post){
			$scid=$post['scid'];$rank=$post['rank'];
			$q.="UPDATE {$dbg}.50_gradhonors_sjam SET `overall_rank`='$rank' WHERE `scid`='$scid' LIMIT 1; ";			
		}
		$db->query($q);
		$url="sjam/gradhonors/$lvl?final";
		flashRedirect($url,'Grad Honors completed.');
		
	}	/* post */
	
	// $d=getSjamRanksTotal($db,$dbg,$dbo,$lvl);	
	$d=getSjamRanksTotalASC($db,$dbg,$dbo,$lvl);	
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];
	// $data['rows']=getSir($data['rows']);	
	
	$vfile="customs/sjam/grad/sjamSirGradTotalAsc";	vfile($vfile);
	// $vfile="customs/sjam/grad/sjamSirGradTotal";	
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function gradWTD($params=null){
	require_once(SITE.'functions/ranksFxn.php');
	require_once(SITE.'functions/sjam/sjamGradFxn.php');
	$data['lvl']=$lvl=isset($params[0])? $params[0]:9;	
	$data['currlvl']=$lvl;
	$data['prevlvl']=$lvl-1;

	$ssy=$_SESSION['sy'];
	$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;	
	$db=&$this->baseModel->db;	
	
	/* 1 */
	sortGradWeights($db,$dbg,$lvl);
	
	/* 2 */
	$url="sjam/gradhonors/$lvl";
	flashRedirect($url,'Ranks updated.');

	
	
}	/* fxn */


public function syncSjamGradHonors($params=array(9)){
	require_once(SITE.'functions/details.php');
	require_once(SITE.'functions/ranksFxn.php');
	require_once(SITE.'functions/sjam/sjamGradFxn.php');
	$data['lvl']=$lvl=isset($params[0])? $params[0]:9;	
	$data['currlvl']=$lvl;
	$data['prevlvl']=$lvl-1;

	$ssy=$_SESSION['sy'];
	$sqtr=$_SESSION['qtr'];
	$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;	
	$db=&$this->baseModel->db;	

	$final=isset($_GET['final'])? 'final':NULL;

	/* 1 */
	$d=getSjamGradHonors($db,$dbg,$dbo,$lvl,$fqtr=5,$final);
	$rows=$d['rows'];
	$data['rows']=&$rows;
	$data['count']=$d['count'];

	/* 2 */
	syncSjamGradHonors($db,$dbg,$dbo,$lvl,$rows); 
	$url="sjam/gradhonors/$lvl";
	flashRedirect($url,"Synced.");
	


}	/* fxn */


	
	
public function gradHonorsOfShs($params=array(15)){
	require_once(SITE.'functions/details.php');
	require_once(SITE.'functions/ranksFxn.php');
	require_once(SITE.'functions/sjam/sjamGradFxn.php');
	// $data['lvl']=$lvl=isset($params[0])? $params[0]:15;	
	$data['lvl']=$lvl=$params[0];	
	$data['currlvl']=$lvl;
	$data['prevlvl']=$lvl-1;

	$ssy=$_SESSION['sy'];
	$sqtr=$_SESSION['qtr'];
	$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;	
	$db=&$this->baseModel->db;	
	
	$final=isset($_GET['final'])? 'final':NULL;
	
	/* 1 */
	$data['lrow']=getLevelDetails($db,$lvl,$dbg);		
	
	/* 2a */
	$d=getSjamGradHonorsOfShs($db,$dbg,$dbo,$lvl,$fqtr=5,$final);
	$rows=$d['rows'];
	$data['rows']=&$rows;
	$data['count']=$d['count'];
		
	/* 2b */
	// if(!isset($_GET['final'])){ syncSjamGradHonors($db,$dbg,$dbo,$lvl,$rows); }
	
	if(isset($_POST['submit'])){
		syncSjamGradHonors($db,$dbg,$dbo,$lvl,$rows); 
		
		$posts=$_POST['posts'];
		if(isset($_GET['final'])){
			$q="";
			foreach($posts AS $post){			
				$scid=$post['scid'];
				$overall_place=$post['overall_place'];
				$q.="UPDATE {$dbg}.50_gradhonors_sjam SET `overall_place`='$overall_place' 
					WHERE scid='$scid' LIMIT 1;";				
			}
			$db->query($q);					
		} else {
			$q="";
			foreach($posts AS $post){			
				$scid=$post['scid'];
				$prev_acad=$post['prev_acad'];
				$prev_cond=$post['prev_cond'];
				$q.="UPDATE {$dbg}.50_gradhonors_sjam SET `prev_acad`='$prev_acad',`prev_cond`='$prev_cond' 
					WHERE scid='$scid' LIMIT 1;";
				
			}
			$db->query($q);		
			
			/* 2b */			
			$q="UPDATE {$dbg}.`50_gradhonors_sjam` SET total_acad=(`prev_acad`*0.3)+(`curr_acad`*0.7),
				`total_cond`=(`prev_cond`*0.3)+(`curr_cond`*0.7) WHERE `lvl`='$lvl';  ";
			$db->query($q);
			
			/* 2c */
			sortGradWeights($db,$dbg,$lvl);			
		}	/* not final */

		
		/*  */
		
		$url="sjam/gradHonors/$lvl?$final";
		flashRedirect($url,"Updated.");
		exit;
		
	}	/* post */
	



	$one="grad/sjamGradHonorsOfShs";$two="grad/gradHonorsOfShs";
	if(isset($_GET['print'])){ $one="grad/sjamGradHonorsPrint";$two="grad/gradHonorsPrint"; }
	$vfile=cview($one,$two,$sch=VCFOLDER);		
	if(isset($_GET['vfile'])){ pr($vfile); }
	
	$this->view->render($data,$vfile);		

}	/* fxn */


public function syncHonordg($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$data['qtr']=$qtr=isset($params[1])? $params[1]:$_SESSION['qtr'];
	pr("params0: sy | params1: qtr");
	$dbo=PDBO;$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	$q="UPDATE {$dbg}.05_summext AS sumx
		INNER JOIN {$dbg}.05_summaries AS summ ON sumx.scid=summ.scid
		SET sumx.honor_dg4=CASE 
			WHEN summ.ave_q{$qtr}>=98 THEN 'WHH' 
			WHEN summ.ave_q{$qtr}>=95 THEN 'WH' 
			WHEN summ.ave_q{$qtr}>=90 THEN 'H' 		
		END
		WHERE sumx.is_qualified_q4=1;";
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "Success":"Fail";	
	
}	/* fxn */














}	/* SjamController */
