<?php

Class ScriptsController extends Controller{	

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
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'scripts/index');

}	/* fxn */



public function porx(){

$poid='306';
$db=&$this->model->db;$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;
$rxdate=$_SESSION['today'];


$q="SELECT * FROM {$dbo}.30_podetails; ";
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();

$q="INSERT INTO {$dbo}.30_po_rx(`po_id`,`product_id`,`rxdate`,`rxqty`)VALUES  ";
foreach($rows AS $row){
	$rxqty=$row['rxqty'];
	if($rxqty>0){
		$po_id=$row['po_id'];$product_id=$row['product_id'];
		$q.="('$po_id','$product_id','$rxdate','$rxqty'),";	
	}
}	/* foreach */
$q=rtrim($q,",");$q.=";";

pr($q);


}	/* fxn */
	

public function proma($params=NULL){	/* promoteAll */
$sy=isset($params[0])?$params[0]:DBYR;
$nsy=$sy+1;
$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
$ndbg=VCPREFIX.$nsy.US.DBG;
$cdbg=VCPREFIX.$sy.US.DBG;

/* 
1 - copy dbg.05_summaries to ndbg.05_summaries
2 - update ndbg.05_summaries set crid = ntmp where sy!=$nsy and c.crid.sxn!=tmp
3 - sxnr - insert into summ if !exists
4 - 
*/

$tmpsxn=1;$outsxn=2;
$q = "
UPDATE {$ndbg}.05_summaries AS x 
INNER JOIN (
	SELECT a.scid,a.crid,b.ncrid
	FROM (select 
			nsum.scid,cr.id AS crid,cr.level_id AS lvl,cr.level_id+1 AS nxtlvl
		from {$cdbg}.05_summaries AS nsum
			left join {$cdbg}.05_classrooms AS cr ON nsum.crid = cr.id
			left join {$dbo}.`00_contacts` AS c ON nsum.scid = c.id
		where c.`role_id`='".RSTUD."' AND cr.section_id<>'$tmpsxn'  AND cr.section_id<>'$outsxn') AS a	
	LEFT JOIN	
		(SELECT *,id AS ncrid FROM {$ndbg}.05_classrooms WHERE section_id = '$tmpsxn' ) AS b
	ON b.level_id = a.nxtlvl
) AS y ON x.scid = y.scid
SET x.crid = y.ncrid;";

pr($q);

echo "<hr />If DBYR already transitioned, then update dbo.`00_contacts` too. <hr />";

$q="UPDATE {$dbo}.`00_contacts` AS c
	INNER JOIN {$ndbg}.05_summaries AS summ ON c.id=summ.scid
	SET c.crid=summ.crid WHERE c.role_id='".RSTUD."';	";
pr($q);

$q="UPDATE {$ndbg}.05_attendance SET 
	jun_days_present=0,jul_days_present=0,aug_days_present=0,sep_days_present=0,
	oct_days_present=0,nov_days_present=0,dec_days_present=0,jan_days_present=0,feb_days_present=0,mar_days_present=0,apr_days_present=0,
	jun_days_tardy=0,jul_days_tardy=0,aug_days_tardy=0,sep_days_tardy=0,oct_days_tardy=0,	
	nov_days_tardy=0,dec_days_tardy=0,jan_days_tardy=0,feb_days_tardy=0,mar_days_tardy=0,apr_days_tardy=0,		
	q1_days_present=0,q2_days_present=0,q3_days_present=0,q4_days_present=0,q5_days_present=0,		
	q1_days_tardy=0,q2_days_tardy=0,q3_days_tardy=0,q4_days_tardy=0,q5_days_tardy=0;
";
echo "INIT attendance<br />";
pr($q);

}	/* fxn */



public function avetraits($params=NULL){
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
echo "UPDATE grades per trait <br />";

$q="
	UPDATE {$dbg}.50_grades AS a
		INNER JOIN {$dbg}.05_courses AS b ON a.course_id=b.id
		SET a.q5=((a.q1+a.q2+a.q3+a.q4)/4)
	WHERE b.crstype_id='".CTYPETRAITS."';	
";
// pr($q);
$db->query($q);



}	/* fxn */


public function totalAttdM($params=NULL){
$dbo=PDBO;
$sy=isset($params[0])? $params[0]:DBYR;
$db=&$this->model->db;
$dbg=VCPREFIX.$sy.US.DBG;
$q="
	UPDATE {$dbg}.05_attendance SET
	total_days_present=(jun_days_present+jul_days_present+aug_days_present+sep_days_present+oct_days_present+
		nov_days_present+dec_days_present+jan_days_present+feb_days_present+mar_days_present+apr_days_present
		+may_days_present),total_days_tardy=(jun_days_tardy+jul_days_tardy+aug_days_tardy+sep_days_tardy+oct_days_tardy+
		nov_days_tardy+dec_days_tardy+jan_days_tardy+feb_days_tardy+mar_days_tardy+apr_days_tardy+may_days_tardy);	
";
pr($q);
$sth=$db->query($q);
echo ($sth)? "Query Success":"Query Failed.";
echo "<hr />";
$q="UPDATE {$dbg}.05_attendance SET `q5_days_present`=`total_days_present`,`q5_days_tardy`=`total_days_tardy`;";
pr($q);
$sth=$db->query($q);
echo ($sth)? "Query Success":"Query Failed.";
	
}	/* fxn */


public function totalAttdQ($params=NULL){
$dbo=PDBO;
$sy=isset($params[0])? $params[0]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;
$q=" UPDATE {$dbg}.05_attendance SET total_days_present=(q1_days_present+q2_days_present+q3_days_present+q4_days_present),
		total_days_tardy=(q1_days_tardy+q2_days_tardy+q3_days_tardy+q4_days_tardy);";
pr($q);
$sth=$db->query($q);
echo ($sth)? "Query Success":"Query Failed.";

	
}	/* fxn */


public function attdqtr5(){
$db=&$this->model->db;
$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
$q="";
$q.="UPDATE {$dbg}.05_attendance_months SET q5_days_total=year_days_total; ";
$q.="UPDATE {$dbg}.05_attendance SET q5_days_present=total_days_present,q5_days_tardy=total_days_tardy;";
pr($q);
$db->query($q);
echo "Query done.";

}	/* fxn */


public function grsum(){
$db=&$this->model->db;
$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
$q="";
$q.="UPDATE {$dbg}.50_grades SET sumtotal=(q1+q2+q3+q4);";
$db->query($q);
pr($q);
echo "Qry done.";
$q="UPDATE {$dbg}.50_grades SET q5=75,q4=(q4+2),bonus_q4=(bonus_q4+2) WHERE sumtotal=296; ";
$q.="UPDATE {$dbg}.50_grades SET q5=75,q4=(q4+1),bonus_q4=(bonus_q4+1) WHERE sumtotal=297; ";
$db->query($q);
pr($q);
echo "Qry done.";


}	/* fxn */




}	/* ScriptsController */
