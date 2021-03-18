<?php

Class RanksController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	echo "Ranks";
	// $data=NULL;$this->view->render($data,'abc/indexAbc');
}	/* fxn */



public function level($params=false){
$dbo=PDBO;
require_once(SITE.'functions/feesFxn.php');
require_once(SITE.'functions/ranksFxn.php');
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;

$data['free']=$free=isset($_GET['free'])? $_GET['free']:0;		
$data['level']=fetchRow($db,"{$dbo}.`05_levels`",$lvl);
$data['rows']=getLevelRanks($db,$dbg,$lvl,$qtr);
$data['count']=count($data['rows']);

$one="levelRanks";$two="ranks/levelRanks";
$vfile=cview($one,$two);	
$this->view->render($data,$vfile);

}	/* fxn */


public function update($params=false){
$dbo=PDBO;
require_once(SITE.'functions/ranksFxn.php');
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

  
	/* 1 - ok */
	$q1 = "UPDATE {$dbg}.05_summext AS x
		INNER JOIN (
			SELECT t.*,
			@prev:=@curr,
			@curr:=t.genave,
			@rank:=IF(@prev=@curr,@rank,@rank+1) AS `rank`
			FROM 
				(SELECT a.scid,a.ave_q{$qtr} AS genave,c.name AS classroom,b.name AS student,b.code AS studcode 
					FROM {$dbg}.05_summaries AS a 
					INNER JOIN {$dbo}.`00_contacts` AS b ON a.scid=b.id
					INNER JOIN {$dbg}.05_classrooms AS c ON a.crid=c.id
					WHERE c.level_id='$lvl'
				) t,
				(SELECT @prev:=null,@curr:=null,@rank:=0) x
			ORDER BY t.genave DESC
		) AS y ON x.scid=y.scid		
		SET x.rank_level_ave_q{$qtr}= y.`rank`;";		

	/* 2 - ok */
	$q2 = "SET @r=0;UPDATE {$dbg}.05_summext AS x
		INNER JOIN (
			SELECT a.scid FROM {$dbg}.05_summaries AS a
			INNER JOIN {$dbg}.05_summext AS b ON a.scid=b.scid 
			INNER JOIN {$dbg}.05_classrooms AS c ON a.crid=c.id 
			WHERE c.level_id='$lvl' ORDER BY a.ave_q{$qtr} DESC 		
		) AS y ON x.scid=y.scid		
		SET x.rank_level_ave_q{$qtr}= @r:= (@r+1);";
			
	$num=isset($_GET['num'])? $_GET['num']:1;
	$data['q']=$q=${'q'.$num};
	debug($q);
	
	if(isset($_GET['exe'])){ $sth=$db->querysoc($q); echo "Rank updated."; flashRedirect("ranks/level/$lvl/$sy/$qtr","Ties processed."); }


}	/* fxn */


public function ties($params=false){
$dbo=PDBO;
require_once(SITE.'functions/feesFxn.php');
require_once(SITE.'functions/ranksFxn.php');
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

$data['level']=fetchRow($db,"{$dbo}.`05_levels`",$lvl);

$q1="
SELECT t.*,
@prev:=@curr,
@curr:=t.genave,
@rank:=IF(@prev=@curr,@rank,@rank+1) AS `rank`
FROM 
	(SELECT a.scid,a.ave_q{$qtr} AS genave,c.name AS classroom,b.name AS student,b.code AS studcode 
		FROM {$dbg}.05_summaries AS a 
		INNER JOIN {$dbo}.`00_contacts` AS b ON a.scid=b.id
		INNER JOIN {$dbg}.05_classrooms AS c ON a.crid=c.id
		WHERE c.level_id='$lvl'
	) t,
	(SELECT @prev:=null,@curr:=null,@rank:=0) x
ORDER BY t.genave DESC;
";


$num=isset($_GET['num'])? $_GET['num']:1;
$data['q']=$q=${'q'.$num};
debug($q);

$sth=$db->querysoc($q);
if(!$sth){ pr($q); echo "query failed."; }
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$this->view->render($data,"ranks/tiesRanks");

}	/* fxn */

public function test(){
$dbo=PDBO;
$db=&$this->baseModel->db;
$data['db']=&$db;
$dbo=PDBO;$dbg=PDBG;

$field=isset($_GET['field'])? $_GET['field']:"ave_q1";
$limitcond=isset($_GET['limit'])? "LIMIT ".$_GET['limit']:NULL;

// $q="SELECT * FROM {$dbo}.rankstest ORDER BY genave DESC; ";
$q="SELECT summ.{$field} AS genave,c.id AS scid,c.name AS name,1 AS should
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
WHERE cr.level_id<6 AND summ.{$field}>0 ORDER BY summ.{$field} DESC $limitcond; ";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
debug($q);
$this->view->render($data,'ranks/testRanks');

}

public function abc(){



$data=NULL;
$this->view->render($data,'ranks/abcRanks');
}	/* fxn */


public function sir($params=NULL){
$dbo=PDBO;
// require_once(SITE.'functions/ranksFxn.php');
$db=&$this->baseModel->db;
$data['db']=&$db;$dbo=PDBO;

$lvl=isset($params[0])? $params[0]:4;
$sy=isset($params[1])? $params[1]:DBYR;
$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$qtr=1;
$dbg=VCPREFIX.$sy.US.DBG;

$field=isset($_GET['field'])? $_GET['field']:"ave_q{$qtr}";
$limitcond=isset($_GET['limit'])? "LIMIT ".$_GET['limit']:NULL;

$q="SELECT summ.{$field} AS genave,c.id AS scid,c.name AS name,1 AS should
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
WHERE cr.level_id='$lvl' AND summ.{$field}>0 ORDER BY summ.{$field} DESC $limitcond; ";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

debug($q);
$this->view->render($data,'sir/levelRanks');

}	/* fxn */



public function process($params=NULL){
// require_once(SITE.'functions/ranksFxn.php');
$dbo=PDBO;
$db=&$this->baseModel->db;
$data['db']=&$db;$dbo=PDBO;

$lvl=isset($params[0])? $params[0]:4;
$sy=isset($params[1])? $params[1]:DBYR;
$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$dbg=VCPREFIX.$sy.US.DBG;

if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$q.="UPDATE {$dbg}.05_summext SET rank_level_ave_q{$qtr}='".$post['rank']."' WHERE scid='".$post['scid']."' LIMIT 1; ";		
	}
	$db->query($q);
	$url="ranks/level/$lvl/$sy/$qtr";
	flashRedirect($url,'Split Ranks processed.');
	exit;

}	/* post */


$field=isset($_GET['field'])? $_GET['field']:"ave_q{$qtr}";
$limitcond=isset($_GET['limit'])? "LIMIT ".$_GET['limit']:NULL;

$q="SELECT summ.{$field} AS genave,c.id AS scid,c.name AS name,1 AS should
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
WHERE cr.level_id='$lvl' AND summ.{$field}>0 ORDER BY summ.{$field} DESC $limitcond; ";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

debug($q);
$this->view->render($data,'ranks/processSirRanks');

}	/* fxn */





}	/* BlankController */
