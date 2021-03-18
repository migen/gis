 <?php
/* register new student, enroll students to a classroom */
/* 1) gls, 2) sectioning, 3) sectioner, */



function checkContact($db,$contact_id){
	$dbo=PDBO;
	$q="SELECT id FROM  {$dbo}.`00_contacts` WHERE id=$contact_id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();		
	if(empty($row)){ echo "<h3 style='color:brown;'>Contact ID #$contact_id does NOT exist.</h3>"; return false; } 
	return true;

}	/* fxn */


function insertUpdateSummaries($db,$sy,$scid,$crid){
	// 2 - summaries
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$ecid=$_SESSION['ucid'];
	$q="SELECT id,crid FROM {$dbg}.`05_summaries` WHERE scid=$scid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	if(empty($row)){ 
		$q="INSERT INTO {$dbg}.`05_summaries`(`scid`,`crid`)VALUES($scid,$crid);";$db->query($q);
	} else {
		if($row['crid']!=$crid){
			$id=$row['id'];$q="UPDATE {$dbg}.`05_summaries` SET `crid`=$crid WHERE id=$id LIMIT 1; ";$db->query($q);
		}		
	}
		
}	/* fxn */


function insertUpdateEnrollment($db,$sy,$scid,$crid){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$ecid=$_SESSION['ucid'];$date=$_SESSION['today'];
	/* CES - contacts > enrolllments > summaries */ 
	// 1 - contacts
	if(DBYR==$sy){
		$q=" UPDATE {$dbo}.`00_contacts` SET `prevcrid`=crid,`crid`=$crid,`sy`=$sy,`is_active`=1,modified_date='$today' 
		WHERE `id`=$scid LIMIT 1; "; $db->query($q);		
	}
	// 2 - enrollments
	$q="SELECT id,crid FROM {$dbo}.`05_enrollments` WHERE sy=$sy AND scid=$scid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	if(empty($row)){ 
		$q="INSERT INTO {$dbo}.`05_enrollments`(`sy`,`scid`,`crid`,`ecid`,`modified_date`)VALUES($sy,$scid,$crid,$ecid,'$date');";$db->query($q);
	} else {
		if($row['crid']!=$crid){
			$id=$row['id'];$q="UPDATE {$dbo}.`05_enrollments` SET `crid`=$crid,`ecid`=$ecid,modified_date='$date' WHERE id=$id LIMIT 1;";$db->query($q);
		}		
	}	
	// 3 - summaries
	$q="SELECT id,crid FROM {$dbg}.`05_summaries` WHERE scid=$scid LIMIT 1; ";
	$_SESSION['q1'].=$q;	
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	if(empty($row)){ 
		$q="INSERT INTO {$dbg}.`05_summaries`(`scid`,`crid`)VALUES($scid,$crid);";$db->query($q);
	} else {
		if($row['crid']!=$crid){
			$id=$row['id'];$q="UPDATE {$dbg}.`05_summaries` SET `crid`=$crid WHERE scid=$scid LIMIT 1;";$db->query($q);
		}		
	}	
	
}	/* fxn */


function classroomsRange($db,$lvl,$dbg=PDBG){
$dbo=PDBO;	
$prevlvl=$lvl-1;
$nextlvl=$lvl+1;
$q=" SELECT id,name,num,level_id FROM {$dbg}.05_classrooms WHERE level_id>='$prevlvl' AND level_id<='$nextlvl' ORDER BY level_id; ";
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
// pr($q);pr("classroomsRange");
return $rows;

}	/* fxn */


function closeRangeFromLevelClassrooms($db,$level_id){
	$dbo=PDBO;
	$dbg=PDBG;$brid=$_SESSION['brid'];
	$q="SELECT id,level_id,name		
		FROM {$dbg}.05_classrooms ORDER BY level_id; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();		
	$lc=array();
	if(!isset($_SESSION['level_classrooms'])){
		foreach($rows AS $row){
			$lvl=$row['level_id'];
			if(!isset($lc[$lvl])){ $lc[$lvl]=array(); }
			array_push($lc[$lvl],$row);			
		}		
	} else {
		$lc=$_SESSION['level_classrooms'];
	}
	// pr("sessionize-classrooms");pr("level_id: $level_id");
	$a=($level_id>1)? $level_id-1:1;
	$b=$level_id;
	$c=$level_id+1;
	$ar=isset($lc[$a])? $lc[$a]:array();
	$br=isset($lc[$b])? $lc[$b]:array();
	$cr=isset($lc[$c])? $lc[$c]:array();
	
	$crr=($a>0)? array_merge($ar,$br,$cr):array_merge($br,$cr);
	return $crr;
	
	// $_SESSION['level_classrooms']=$lc;
}	/* fxn */


function sectioningStudentxxx($db,$sy,$scid,$fields=NULL){	
	$dbo=PDBO;
	$q="select id,name from {$dbo}.`00_contacts` where id=1 limit 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;
	// return array('id'=>23);
}

function sectioningStudent($db,$sy,$scid,$fields=NULL){	

$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$has_axis=&$_SESSION['settings']['has_axis'];

	$q = "SELECT $fields c.name AS studname,c.code AS studcode,c.role_id,
			en.scid AS enscid,en.id AS enid,en.crid AS encrid,			
			summ.scid AS summscid,summ.id AS summid,summ.crid AS summcrid,$sy AS sy,
			cr.name AS classroom,
			l.id AS currlvl,l.name AS currlevel,
			nl.id AS nextlvl,nl.name AS nextlevel
			
		";
if($has_axis){ $q.=",t.total "; }		
		$q.=" FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.05_enrollments AS en ON (en.scid=c.id && en.sy=$sy)
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid=c.id			
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id=l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id=sxn.id 
			LEFT JOIN {$dbo}.`05_levels` AS nl on (cr.level_id+1)=nl.id
			
		";
			
if($has_axis){ $q.="
	LEFT JOIN {$dbo}.`03_tuitions` AS t ON (cr.level_id = t.level_id AND cr.num =t.num)		
	"; 
}			
			$q.=" WHERE c.id=$scid LIMIT 1; ";
			
	debug($q,'sectionerFxn');
	$sth=$db->querysoc($q);
	// $row=$sth->fetch();pr($q);pr($row);return $row();
	pr($q);
	return $sth->fetch();
 


}	/* fxn */



