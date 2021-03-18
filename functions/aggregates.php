<?php



function getStudentAggregates($db,$dbg,$scid,$supsubject_id,$sy,$qtr,$course_id){			
	$dbo=PDBO;
	$q = "SELECT g.id AS gid,'$course_id' AS course_id,summ.scid AS scid,g.q$qtr,
			crs.id AS subcourse_id,crs.course_weight AS weight,crs.name AS subcourse,crs.code AS label,crs.supsubject_id			
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbg}.`05_summaries` AS summ ON g.scid = summ.scid		
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id			
		WHERE g.scid = '$scid' AND crs.supsubject_id = '$supsubject_id'
		ORDER BY crs.id ASC LIMIT 100; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function getStudentDetails($db,$scid){
	$dbo=PDBO;
	$q="SELECT c.* FROM {$dbo}.`00_contacts` AS c WHERE c.`id` = '$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);	
	return $sth->fetch();

}	/* fxn */


function updateStudentAggregates($db,$scid,$crid){
	$dbo=PDBO;$dbg=PDBG;
	$decicard=$_SESSION['settings']['decicard'];
	$q="UPDATE {$dbg}.50_grades AS g 
		INNER JOIN (
			SELECT * FROM {$dbg}.05_courses AS crs WHERE crs.crid='$crid'
		) AS crs ON g.course_id=crs.id 	
		INNER JOIN (
			SELECT crs.id AS supcrs,crs.label
			FROM {$dbo}.`00_contacts` AS c
				INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=crs.cid
				INNER JOIN {$dbg}.05_courses AS crs ON summ.crid=crs.crid
			WHERE c.id='$scid'		
		) AS a ON a.supcrs=crs.id	
		INNER JOIN (
			SELECT g.course_id,crs.label,crs.supsubject_id,
				ROUND(SUM(g.q1*crs.course_weight/100),".$decicard.") AS gsum1,
				ROUND(SUM(g.q2*crs.course_weight/100),".$decicard.") AS gsum2,
				ROUND(SUM(g.q3*crs.course_weight/100),".$decicard.") AS gsum3,
				ROUND(SUM(g.q4*crs.course_weight/100),".$decicard.") AS gsum4,
				ROUND(SUM(g.q5*crs.course_weight/100),".$deciave.") AS gsum5,
				ROUND(SUM(g.q6*crs.course_weight/100),".$deciave.") AS gsum6				
			FROM {$dbg}.50_grades AS g
				INNER JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id		
				INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id		
			WHERE g.scid='$scid' AND crs.supsubject_id>0
			GROUP BY crs.supsubject_id 			
		) AS b ON b.supsubject_id=crs.subject_id
		SET g.q1=b.gsum1,g.q2=b.gsum2,g.q3=b.gsum3,g.q4=b.gsum4,g.q5=b.gsum5,g.q6=b.gsum6
		WHERE g.scid='$scid'; ";
	$db->query($q);
		
	
}	/* fxn */



function updateStudentAggregatesQuery($db,$scid,$crid){
	$dbo=PDBO;$dbg=PDBG;
	$decicard=$_SESSION['settings']['decicard'];
	$deciave=$_SESSION['settings']['deciave'];
	$q="UPDATE {$dbg}.50_grades AS g 
		INNER JOIN (
			SELECT * FROM {$dbg}.05_courses AS crs WHERE crs.crid='$crid'
		) AS crs ON g.course_id=crs.id 	
		INNER JOIN (
			SELECT crs.id AS supcrs,crs.label
			FROM {$dbo}.`00_contacts` AS c
				INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
				INNER JOIN {$dbg}.05_courses AS crs ON summ.crid=crs.crid
			WHERE c.id='$scid'		
		) AS a ON a.supcrs=crs.id	
		INNER JOIN (
			SELECT g.course_id,crs.label,crs.supsubject_id,
				ROUND(SUM(g.q1*crs.course_weight/100),".$decicard.") AS gsum1,
				ROUND(SUM(g.q2*crs.course_weight/100),".$decicard.") AS gsum2,
				ROUND(SUM(g.q3*crs.course_weight/100),".$decicard.") AS gsum3,
				ROUND(SUM(g.q4*crs.course_weight/100),".$decicard.") AS gsum4,
				ROUND(SUM(g.q5*crs.course_weight/100),".$deciave.") AS gsum5,
				ROUND(SUM(g.q6*crs.course_weight/100),".$deciave.") AS gsum6				
			FROM {$dbg}.50_grades AS g
				INNER JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id		
				INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id		
			WHERE g.scid='$scid' AND crs.supsubject_id>0
			GROUP BY crs.supsubject_id 			
		) AS b ON b.supsubject_id=crs.subject_id
		SET g.q1=b.gsum1,g.q2=b.gsum2,g.q3=b.gsum3,g.q4=b.gsum4,g.q5=b.gsum5,g.q6=b.gsum6
		WHERE g.scid='$scid'; ";
	return $q;

	
}	/* fxn */




function summarizeGenave($db,$scid,$crid){	
	$dbo=PDBO;$dbg=PDBG;
	$decicard=$_SESSION['settings']['decicard'];
	$decigenave=$_SESSION['settings']['decigenave'];
	
	$q="SELECT g.`course_id` AS `course_id`,crs.`label` AS `course`,crs.`supsubject_id`,crs.`units`,
			c.`id` AS `contact_id`,c.`id` AS `student_id`,c.`name` AS `student`,c.`code` AS `student_code`,
			sub.`name` AS `subject`,g.`id` AS `gid`,g.*,
			sum.`ave_q1`,sum.`ave_q2`,sum.`ave_q3`,sum.`ave_q4`,sum.`ave_q5`
		FROM {$dbg}.`50_grades` AS `g`
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
			INNER JOIN {$dbg}.`05_summaries` AS sum ON sum.`scid`  = g.`scid` 
		WHERE g.`scid`='$scid' AND crs.`crid`='$crid' AND crs.`is_active`=1 	
			 AND ( crs.crstype_id = '1'  ) AND (crs.in_genave = '1')  AND (crs.semester = 0 ) 
		ORDER BY crs.`position`,crs.`id`;";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=count($rows);	
	$genave=array();
	$sumq1=0;$sumq2=0;$sumq3=0;$sumq4=0;$sumq5=0;
	foreach($rows AS $row){
		$sumq1+=number_format($row['q1'],$decicard);
		$sumq2+=number_format($row['q2'],$decicard);
		$sumq3+=number_format($row['q3'],$decicard);
		$sumq4+=number_format($row['q4'],$decicard);
		$sumq5+=number_format($row['q5'],$decicard);
	}

	$gaq1=number_format(($sumq1/$count),$decigenave);
	$gaq2=number_format(($sumq2/$count),$decigenave);
	$gaq3=number_format(($sumq3/$count),$decigenave);
	$gaq4=number_format(($sumq4/$count),$decigenave);
	$gaq5=number_format(($sumq5/$count),$decigenave);
	
	$q="UPDATE {$dbg}.05_summaries SET `ave_q1`='$gaq1',`ave_q2`='$gaq2',`ave_q3`='$gaq3',`ave_q4`='$gaq4',`ave_q5`='$gaq5'
		WHERE `scid`='$scid' LIMIT 1;";
	$db->query($q);
	
	
	
}	/* fxn */
