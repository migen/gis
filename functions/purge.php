<?php


function purge($db,$dbg,$scid){
$dbo=PDBO;
require_once(SITE."functions/logs.php");
/* contacts,profiles,students,ctp,summaries,grades,scores,attendance */
$dbo=PDBO;$dbp=PDBP;
$q = " SELECT * FROM {$dbo}.`00_contacts` WHERE `id` = '$scid' LIMIT 1;  ";
$sth = $db->querysoc($q);
$user = $sth->fetch();
$is_student = ($user['role_id']==1)? true:false;
$has_axis=$_SESSION['settings']['has_axis'];

$q1="";
$q=" DELETE IGNORE FROM {$dbg}.50_trsgrades WHERE `scid` = '$scid' ; ";	
$db->query($q);
$q1.=$q;

/* 2 */
$q =" DELETE IGNORE FROM {$dbo}.`00_contacts` WHERE `id` = '$scid' LIMIT 1; ";
$q.=" DELETE IGNORE FROM {$dbo}.`00_profiles` WHERE `contact_id` = '$scid' LIMIT 1; ";
$q.=" DELETE IGNORE FROM {$dbp}.photos WHERE `contact_id` = '$scid' LIMIT 1; ";
$q.=" DELETE IGNORE FROM {$dbo}.`00_ctp` WHERE `contact_id` = '$scid' LIMIT 1; ";
$db->query($q);
$q1.=$q;

/* student */	
$q=" DELETE IGNORE FROM {$dbg}.05_attendance WHERE `scid` = '$scid' ; ";
$q.=" DELETE IGNORE FROM {$dbg}.50_grades WHERE `scid` = '$scid' ; ";
$q.=" DELETE IGNORE FROM {$dbg}.50_scores WHERE `scid` = '$scid' ; ";	
$q.=" DELETE IGNORE FROM {$dbg}.05_summaries WHERE `scid` = '$scid' ; ";
$q.=" DELETE IGNORE FROM {$dbg}.05_students WHERE `contact_id` = '$scid' ; ";
if($has_axis){
	$q.=" DELETE IGNORE FROM {$dbg}.`30_auxes` WHERE `scid` = '$scid' ; ";
	$q.=" DELETE IGNORE FROM {$dbo}.30_payments WHERE `scid` = '$scid' ; ";
	$q.=" DELETE IGNORE FROM {$dbg}.03_tsummaries WHERE `scid` = '$scid' ; ";	
	$q.=" DELETE a,b from {$dbo}.`30_pos` AS a 
		INNER JOIN {$dbo}.`30_positems` AS b on b.pos_id = a.id WHERE a.ccid = $scid; ";			
}
$q1.=$q;
$db->query($q);

/* employee */
$q=" DELETE IGNORE FROM {$dbg}.06_employees WHERE `contact_id` = '$scid' LIMIT 1; ";
$q.=" DELETE IGNORE FROM {$dbg}.06_attendance_employees WHERE `ecid` = '$scid' ; ";
$q1.=$q;
$db->query($q);

/* college */
$q=" DELETE IGNORE FROM {$dbg}.10_attendance WHERE `scid` = '$scid' ; ";
$q.=" DELETE IGNORE FROM {$dbg}.10_grades WHERE `scid` = '$scid' ; ";
$q.=" DELETE IGNORE FROM {$dbg}.10_scores WHERE `scid` = '$scid' ; ";	
$q.=" DELETE IGNORE FROM {$dbg}.01_summaries WHERE `scid` = '$scid' ; ";
$q1.=$q;
$db->query($q);

$_SESSION['qp']='purgeFxn: '.$q1;
debug($q1,"PurgeFxn: purge");
	
/* 3 */	
$axn = $_SESSION['axn']['purge_contact'];
$details = $user['code']." | ".$user['name']." Parent: ".$user['parent_id']." Role: ".$user['role_id']." purged.";
$ucid = $_SESSION['user']['ucid'];
$more['qtr'] = $_SESSION['qtr'];
$more['crid'] = $user['crid'];
$more['scid'] = $user['id'];
logThis($db,$ucid,$axn,$details,$more);	


	
}	/* fxn */



function purgeProduct($db,$prodid,$dbg=PDBG){
	require_once(SITE."functions/logs.php");
	$dbo=PDBO;
	/* 1 */
	$q="SELECT * FROM {$dbo}.`03_products` WHERE `id` = '$prodid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	
	/* 2 */
	$q="DELETE FROM {$dbo}.`03_products` WHERE `id` = '$prodid' LIMIT 1; ";
	$q.="DELETE FROM {$dbo}.`30_positems` WHERE `product_id` = '$prodid'; ";		
	$db->query($q);
	
	/* 3 */	
	$axn = $_SESSION['axn']['purge_product'];
	$details = $row['barcode']." | ".$row['name']." Price: ".$row['price']." Level: ".$row['level']." purged.";
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['amount'] = $row['price'];
	logThis($db,$ucid,$axn,$details,$more);	

}	/* fxn */


function purgeLevelCoursesQuery($lvl,$sub,$dbg=PDBG){
$dbo=PDBO;
$q="
	DELETE crs,sc,g,ax FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.50_scores AS sc ON sc.course_id = crs.id
		LEFT JOIN {$dbg}.50_activities AS ax ON ax.course_id = crs.id
		LEFT JOIN {$dbg}.50_grades AS g ON g.course_id = crs.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
	WHERE cr.level_id='$lvl' AND crs.subject_id='$sub'; ";
return $q;

}	/* fxn */




function purgeClassroomCoursesQuery($crid,$dbg=PDBG){
$dbo=PDBO;
$q = " DELETE a FROM {$dbg}.50_activities AS a LEFT JOIN {$dbg}.05_courses AS crs 
	ON a.course_id = crs.id WHERE crs.`crid` = '$crid'; ";
$q .= "
	DELETE a FROM {$dbg}.50_scores AS a LEFT JOIN {$dbg}.05_courses AS crs 
		ON a.course_id = crs.id WHERE crs.`crid` = '$crid'; ";
$q .= "
	DELETE a FROM {$dbg}.50_grades AS a LEFT JOIN {$dbg}.05_courses AS crs 
	ON a.course_id = crs.id WHERE crs.`crid` = '$crid'; ";
$q .= " DELETE FROM {$dbg}.05_courses WHERE `crid` = '$crid'; ";

return $q;

}	/* fxn */


function purgeCrSxnQuery($crid){
	$dbo=PDBO;$dbg=PDBG;
	$q=" DELETE a,b FROM {$dbg}.05_classrooms AS a LEFT JOIN {$dbo}.`05_sections` AS b 
		ON a.section_id = b.id WHERE a.id='$crid'; ";
	return $q;
}	/* fxn */


function delcrs($params){
$dbo=PDBO;
$dbg=PDBG;
$q = "";
foreach($params AS $crsid){
	$q .= " DELETE FROM {$dbg}.05_courses WHERE `id` = '$crsid' LIMIT 1; ";
	$q .= " DELETE FROM {$dbg}.05_courses_quarters WHERE `course_id` = '$crsid' LIMIT 1; ";
	$q .= " DELETE FROM {$dbg}.50_grades WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_activities WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_scores WHERE `course_id` = '$crsid'; ";
	
}
pr($q);

}	/* fxn */
