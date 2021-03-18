<?php




function setupCourse($db,$crid,$subject_id,$ctype,$position,$code,$label){
	$dbo=PDBO;
	$dbg = PDBG;	
	$q = " SELECT name FROM {$dbg}.05_classrooms WHERE id = '$crid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$classroom = $row['name'];
	$course_name = $classroom.'-'.$code;
	$label=addslashes($label);
	$q = " INSERT INTO {$dbg}.05_courses (`name`,`crid`,`subject_id`,`crstype_id`,`position`,`code`,`label`) 
		VALUES ('$course_name','$crid','$subject_id','$ctype','$position','$code','$label');";		
	$db->query($q);
	$course_id = $db->lastInsertId();			
	$q = " INSERT IGNORE INTO {$dbg}.05_courses_quarters (`course_id`) VALUES ('$course_id');";
	$db->query($q);	

}	/* fxn */


function delcrs($db,$crsid){
	$dbo=PDBO;$dbg=PDBG;
	$q="";
	$q.="DELETE FROM {$dbg}.05_courses WHERE `id` = '$crsid' LIMIT 1; ";
	$q.="DELETE FROM {$dbg}.05_courses_quarters WHERE `course_id` = '$crsid' LIMIT 1; ";
	$q.="DELETE FROM {$dbg}.50_grades WHERE `course_id` = '$crsid'; ";
	$q.="DELETE FROM {$dbg}.50_activities WHERE `course_id` = '$crsid'; ";
	$q.="DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$crsid'; ";
	$q.="DELETE FROM {$dbg}.50_scores WHERE `course_id` = '$crsid'; ";
	$db->query($q);	
}	/* fxn */

function getCurrentStudents($db,$get,$sort="c.name",$order="ASC",$dbg=PDBG){	/* batchFees */
	$lvlid=(isset($get['level']))? $get['level']:false;
	$crid=(isset($get['classroom']))? $get['classroom']:false;
	$dbo=PDBO;
	$cond="";
	$cond.= ($crid)? "summ.crid='$crid' ":"cr.level_id='$lvlid'";
		
	$q="SELECT c.id,c.id AS scid,c.code,c.name,c.name AS student,cr.name AS classroom
		FROM {$dbg}.05_summaries AS summ
			LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE $cond ORDER BY {$sort} {$order}; ";
	debug("SetupFxn: ".$q);
	$sth=$db->querysoc($q);
	$rows = $sth->fetchAll();
	return $rows;
}	/* fxn */


