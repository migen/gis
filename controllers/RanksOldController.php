<?php

Class RanksOldController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	echo "Ranks Old";
	// $data=NULL;$this->view->render($data,'abc/indexAbc');
}	/* fxn */



public function level($params=false){
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
require_once(SITE.'functions/ranksFxn.php');
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

// $q="SET @r=0;UPDATE {$dbo}.stats_games SET rank= @r:= (@r+1) WHERE `grp`='$grp' AND game_id='$game_id' ORDER BY `pct` DESC,`margin` DESC;";		
  
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
	pr($q);
	debug($q);
	
	if(isset($_GET['exe'])){ $sth=$db->querysoc($q); echo "Rank updated."; }


}	/* fxn */



public function ties($params=false){
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

$qx1="
SELECT 
	05_summaries.scid,05_summaries.ave_q{$qtr} AS genave,@rank:=(@rank+1) AS rank
FROM {$dbg}.05_summaries,(SELECT @rank:=0) tmp_tbl
ORDER BY 05_summaries.ave_q{$qtr} DESC ;

";

/* 2-ok */
$qx2="
SELECT 
	b.scid,b.student,b.genave,@rank:=(@rank+1) AS rank
FROM {$dbg}.05_summaries AS summ
INNER JOIN (
	SELECT summ.scid,summ.ave_q{$qtr} AS genave,c.name AS student 
	FROM {$dbg}.05_summaries AS summ
	INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	WHERE cr.level_id='$lvl' ORDER BY genave DESC	
) AS b ON summ.scid=b.scid
INNER JOIN (SELECT @rank:=0) t 
ORDER BY rank ASC LIMIT 10;
";


/* 3 */
$qx4="
SELECT 
	b.scid,b.student,b.genave,
	@prev:=@curr,
	@curr.=b.genave,
	@rank:=IF(@prev=@curr,@rank,@rank+@i) AS rank,
	IF(@prev<b.genave>,@i:=1,@i:=@i+1) AS counter
FROM {$dbg}.05_summaries AS summ
INNER JOIN (
	SELECT summ.scid,summ.ave_q{$qtr} AS genave,c.name AS student 
	FROM {$dbg}.05_summaries AS summ
	INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	WHERE cr.level_id='$lvl' ORDER BY genave DESC	
) AS b ON summ.scid=b.scid
INNER JOIN (SELECT @prev:=null,@curr:=null,@rank:=0,@i:=0) t 
ORDER BY rank ASC LIMIT 10;
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




}	/* BlankController */
