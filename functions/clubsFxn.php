<?php


function canAccessClub($db,$club,$allowed_roles=array(RMIS,RREG)){
	$ucid=$_SESSION['ucid'];$srid=$_SESSION['srid'];
	$is_admin=in_array($srid,$allowed_roles)? true:false;
	$is_mine=($ucid==$club['tcid'])? true:false;
	return ($is_admin || $is_mine)? true:false;
} 	/* fxn */
 
function getStudentClubscores($db,$dbg,$sch,$scid,$qtr){
	$dbo=PDBO;
 	$q="SELECT c.code AS studcode,c.name AS student,sc.*,sc.id AS `score_id`,summ.club_id,cr.name AS classroom
	FROM {$dbo}.`00_contacts` AS c 
	INNER JOIN {$dbg}.50_clubscores_{$sch} AS sc ON sc.scid=c.id
	INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	WHERE sc.scid='$scid' AND sc.qtr='$qtr'; ";
	// prx($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;

}	/* fxn */

 
function clubGradesForSyncing($db,$dbg,$club_id){
	$dbo=PDBO;	
	$order=$_SESSION['settings']['clublist_order'];
	$q=" SELECT c.name,summ.id,summ.scid FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbg}.50_grades AS g ON summ.scid=g.scid
		LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id
		WHERE crs.crstype_id='".CTYPECLUB."' AND summ.club_id='$club_id' AND c.is_active=1 
		ORDER BY $order; ";
		debug($q);
		$sth=$db->querysoc($q);
		return $sth->fetchAll();

} 	/* fxn */

 
function getClubs($db,$dbg,$order="cl.id"){
	$dbo=PDBO;			
	$q="SELECT cl.*,cl.id AS club_id,c.name AS moderator,cl.name AS club FROM {$dbg}.`05_clubs` AS cl
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cl.tcid=c.id ORDER BY $order; ";				
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */

function getClubDetails($db,$dbg,$club_id){		
	$dbo=PDBO;	
	$q="SELECT cl.*,c.name AS moderator,cl.name AS club,cl.id AS club_id
		FROM {$dbg}.`05_clubs` AS cl 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=cl.tcid 
	WHERE cl.`id`='$club_id' LIMIT 1; ";			
	debug($q);	
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */


function getClubMembers($db,$dbg,$club_id){
	$dbo=PDBO;
	$order=$_SESSION['settings']['clublist_order'];
	$q=" SELECT c.is_male,c.id AS scid,c.name AS student,c.code AS student_code,cr.name AS classroom,summ.crid
		FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid
		LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
		WHERE summ.`club_id`='$club_id' AND c.`is_active`='1'
		ORDER BY $order; ";
	debug($q,'getClubMembers');
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
		
}	/* fxn */


function getClubMembersCrs($db,$dbg,$club_id){
	$dbo=PDBO;
	$order=$_SESSION['settings']['clublist_order'];	
	$q=" SELECT c.id AS scid,c.name AS student,c.code AS student_code,cr.name AS classroom,summ.crid,
			crs.id AS crs,crs.name AS course
		FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid
		LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
		LEFT JOIN 
			( SELECT id,name,crid FROM {$dbg}.05_courses WHERE crstype_id=".CTYPECLUB."
			) AS crs ON crs.crid=cr.id			
		WHERE summ.`club_id`='$club_id' AND c.`is_active`='1'
		ORDER BY $order; ";
	debug($q,'getClubMembersCrs');
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
		
}	/* fxn */


function studentToClub($db,$dbg,$scid,$club_id){
	$q = " UPDATE {$dbg}.05_summaries SET `club_id` = '$club_id' WHERE `scid` = '$scid' 
		AND (`club_id`<1 OR `club_id` IS NULL OR `club_id`='') LIMIT 1;";	
	return $q;
}	/* fxn */



function clubScores($db,$dbg,$club_id,$qtr,$sch=VCFOLDER,$order="c.is_male DESC,c.name"){
	$dbo=PDBO;
	$order=$_SESSION['settings']['clublist_order'];	
	$q=" SELECT sc.*,c.is_male,c.name AS student,c.`code` AS `student_code`,sc.id AS `score_id`,cr.name AS classroom 
		FROM {$dbg}.`50_clubscores_{$sch}` AS sc 
		INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=sc.scid 
		INNER JOIN {$dbg}.`05_summaries` AS summ ON c.id=summ.scid 
		INNER JOIN {$dbg}.`05_classrooms` AS cr ON cr.id=summ.crid 
		WHERE sc.`qtr`='$qtr' AND summ.`club_id`='$club_id' ORDER BY $order; ";
	debug($q,'clubScores');
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */



function updateClubGrades($db,$dbg,$sch,$club_id,$qtr){
	$q="UPDATE {$dbg}.50_grades AS a
		INNER JOIN (
			SELECT s.* FROM {$dbg}.50_clubscores_{$sch} AS s 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=s.scid WHERE summ.club_id='$club_id' AND s.qtr=$qtr
		) AS b ON a.scid=b.scid
		SET a.q{$qtr}=b.total
		WHERE a.crstype_id='".CTYPECLUB."';";
	$db->query($q);
}	/* fxn */


function isCompleteClubscores($db,$dbg,$club_id,$qtr,$sch){
	$students=getClubMembers($db,$dbg,$club_id);		
	$num_a=count($students);
	debug("num_stud: ".$num_a);
	$scores=clubScores($db,$dbg,$club_id,$qtr,$sch);		
	$num_b=count($scores);
	debug("num_clubscores: ".$num_b);	
	return ($num_a==$num_b)? true:false;
}	/* fxn */

function isCompleteClubgrades($db,$dbg,$club_id){
	$students=getClubMembers($db,$dbg,$club_id);		
	$ar=buildArray($students,'scid');
	$num_a=count($students);
	$grades=clubGradesForSyncing($db,$dbg,$club_id);		
	$br=buildArray($grades,'scid');	
	$num_b=count($grades);
	// pr($num_a);pr($num_b);$ix = array_diff($ar,$br);echo "<hr />";pr($ix);exit;	
	return ($num_a==$num_b)? true:false;
}	/* fxn */

function syncClubscores($db,$dbg,$club_id,$qtr,$sch){
	$students=getClubMembers($db,$dbg,$club_id);		
	$ar = buildArray($students,'scid');	
	$scores=clubScores($db,$dbg,$club_id,$qtr,$sch);		
	$br = buildArray($scores,'scid');	
	$ix = array_diff($ar,$br);		
	debug($ar);
	debug($br);
	debug($ix);	
	$q="INSERT INTO {$dbg}.50_clubscores_{$sch}(`scid`,`qtr`) VALUES ";
	foreach($ix AS $scid){ $q.="('$scid','$qtr'),"; }
	debug($q);
	$q=rtrim($q,",");$q.=";";
	$db->query($q); 

}	/* fxn */


function purgeClubGrades($db,$dbg,$club_id){
	$students=getClubMembers($db,$dbg,$club_id);		
	$num_a=count($students);
	$scids=buildArray($students,'scid');
	$q="";foreach($scids AS $scid){ $q.="DELETE FROM {$dbg}.50_grades WHERE scid='$scid' AND crstype_id='".CTYPECLUB."'; "; }
	pr($q);$db->query($q);
	echo "Club grades deleted.";

}	/* fxn */

function syncClubgrades($db,$dbg,$club_id){
	/* 1 */
	purgeClubGrades($db,$dbg,$club_id);
	
	/* 2 */
	$students=getClubMembers($db,$dbg,$club_id);		
	$ar = buildArray($students,'scid');	
	$grades=clubGradesForSyncing($db,$dbg,$club_id);		
	$br = buildArray($grades,'scid');	
	$ix = array_diff($ar,$br);		
	debug($ar);
	debug($br);
	debug($ix);	
	$q="INSERT INTO {$dbg}.50_grades(`scid`,`crstype_id`) VALUES ";
	foreach($ix AS $scid){ $q.="('$scid','3'),"; }
	debug($q);
	$q=rtrim($q,",");$q.=";";
	// pr($q);
	$db->query($q);

	/* 3 */
	syncGradesCrs($db,$dbg,$club_id);
	
	/* 4 */
	syncClubcourse($db,$dbg,$club_id);
	
}	/* fxn */



function syncClubcourse($db,$dbg,$club_id){
	$q="UPDATE {$dbg}.05_summaries AS summ
		INNER JOIN (
			SELECT `id` AS `clubcourse_id`,`crid` FROM {$dbg}.05_courses WHERE crstype_id='".CTYPECLUB."'
		) AS crs ON crs.crid=summ.crid
		SET summ.clubcourse_id=crs.clubcourse_id		
		WHERE summ.`club_id`='$club_id'; ";
	echo "syncClubcourse"; pr($q);
	$db->query($q);	
}	/* fxn */

function syncGradesCrs($db,$dbg,$club_id){	
	$q="UPDATE {$dbg}.50_grades AS g 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=g.scid
		SET g.course_id=summ.clubcourse_id 
		WHERE summ.club_id='$club_id' AND g.crstype_id='".CTYPECLUB."' ; ";
	debug($q,'syncGradesCrs');
	$db->query($q);

}	/* fxn */

 
function clubGrades($db,$dbg,$club_id,$qtr,$is_dg=false){
	$dbo=PDBO;
	$fields=" g.`q1`,g.`q2`,g.`q3`,g.`q4`,g.`q5`,g.`q6`,";
	if($is_dg) { $fields=" dg{$qtr} AS grade,g.`dg1`,g.`dg2`,g.`dg3`,g.`dg4`,g.`dg5`,g.`dg6`, "; }
	$order=$_SESSION['settings']['clublist_order'];
	
	$q="SELECT cr.name AS classroom,g.q{$qtr} AS grade,g.id AS gid, {$fields}
			c.is_male,c.name AS student,c.code,summ.scid,summ.crid,summ.clubcourse_id,summ.clubcourse_id AS clubcrs 			
		FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbg}.`05_classrooms` AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbg}.50_grades AS g ON summ.scid=g.scid
		LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id
		WHERE crs.crstype_id='".CTYPECLUB."' 
			AND summ.club_id='$club_id' ORDER BY $order; ";			
		debug($q,'clubGrades');
		$sth=$db->querysoc($q);
		return $sth->fetchAll();

} 	/* fxn */

