<?php

/* promoteAll-summcrid */
Class PromaController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	$acl = array(array(4,0),array(5,0));
	$this->permit($acl,false);		
	
}	/* fxn */

public function index(){	
	pr("promote all");
}	/* fxn */


public function sy($params=NULL){	/* promoteAll */
$sy=isset($params[0])?$params[0]:DBYR;
$nsy=$sy+1;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$ndbg=VCPREFIX.$nsy.US.DBG;


$tmpsxn=1;$outsxn=2;
$q = "
UPDATE {$ndbg}.05_summaries AS x 
INNER JOIN (
	SELECT a.scid,a.crid,b.ncrid
	FROM (select 
			nsum.scid,cr.id AS crid,cr.level_id AS lvl,cr.level_id+1 AS nxtlvl
		from {$dbg}.05_summaries AS nsum
			left join {$dbg}.05_classrooms AS cr ON nsum.crid = cr.id
			left join {$dbo}.`00_contacts` AS c ON nsum.scid = c.id
		where c.`role_id`='".RSTUD."' AND cr.section_id<>'$tmpsxn'  AND cr.section_id<>'$outsxn') AS a	
	LEFT JOIN	
		(SELECT *,id AS ncrid FROM {$ndbg}.05_classrooms WHERE section_id = '$tmpsxn' ) AS b
	ON b.level_id = a.nxtlvl
) AS y ON x.scid = y.scid
SET x.crid = y.ncrid;";

pr($q);
echo "<hr />$sy summ.promlvl & promcrid below <hr />";
$q="
UPDATE {$dbg}.05_summaries AS summ
INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
LEFT JOIN {$dbg}.05_classrooms AS ncr ON  ncr.level_id=(cr.level_id+1)
SET summ.promlvl = ncr.level_id,summ.promcrid = ncr.id
WHERE ncr.section_id='$tmpsxn'; ";
pr($q);
echo "<hr />";


pr("<a href='".URL."mis/query' >MIS Query</a>");

echo "<hr />If DBYR already transitioned, then update dbo.`00_contacts` too. <hr />";

$q="UPDATE {$dbo}.`00_contacts` AS c
	INNER JOIN {$ndbg}.05_summaries AS summ ON c.id=summ.scid
	SET c.crid=summ.crid WHERE c.role_id='".RSTUD."';	";
pr($q);


}	/* fxn */







}	/* BlankController */
