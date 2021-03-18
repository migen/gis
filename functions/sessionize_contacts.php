<?php



/* attendance-logs, edit-student-scores, edit-student-grades, attendance */
function sessionizeCridStudents($db,$dbg,$crid){	
$dbo=PDBO;
$_SESSION['crid'] = $crid;
$q = "
	SELECT c.id,c.id AS ucid,c.id AS scid,c.code,c.name,c.name AS student
	FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
	WHERE 	summ.crid=$crid  ORDER BY c.name;";
$sth=$db->querysoc($q);
$students=$sth->fetchAll();

$q = "SELECT c.id,c.id AS ucid,c.id AS scid,c.code,c.name,c.name AS student
	FROM {$dbg}.05_summaries AS sum
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id=c.id
	WHERE summ.crid=$crid AND c.is_male = 1 ORDER BY c.name;
";
$sth=$db->querysoc($q);
$boys=$sth->fetchAll();

$q = "SELECT c.id,c.id AS ucid,c.id AS scid,c.code,c.name,c.name AS student
	FROM {$dbg}.05_summaries AS sum
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id=c.id
	WHERE summ.crid = '$crid' AND c.is_male=0 ORDER BY c.name; ";
$sth=$db->querysoc($q);
$girls=$sth->fetchAll();

$_SESSION['students']=$students;
$_SESSION['boys']=$boys;
$_SESSION['girls']=$girls;


}	/* fxn */


function sessionizeLevelClassrooms($db){
	$dbo=PDBO;
	$dbg=PDBG;$brid=$_SESSION['brid'];
	if(!isset($_SESSION['classrooms'])){
		$fields="id,code,name,acid,label,level_id,section_id,branch_id";$where="WHERE branch_id=$brid";
		$_SESSION['classrooms']=fetchRows($db,"{$dbg}.05_classrooms",$fields,$order="level_id,name",$where);
	}
	if(!isset($_SESSION['level_classrooms'])){
		$lc=array();$rows=$_SESSION['classrooms'];			
		foreach($rows AS $row){
			$lvl=$row['level_id'];
			if(!isset($lc[$lvl])){ $lc[$lvl]=array(); }
			array_push($lc[$lvl],$row);			
		}		
		$_SESSION['level_classrooms']=$lc;
	}	
}	/* fxn */


