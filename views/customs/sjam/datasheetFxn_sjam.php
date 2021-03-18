<?php

	if(isset($_POST['submit_custom'])){
		pr($_POST);
		$custom=$_POST['custom'];
		$date=$custom['date'];
		$name=$custom['name'];

		/* 2 */
		$q="UPDATE {$dbo} ";
		$q="INSERT INTO {$dbo}.customs(`date`,`name`)VALUES('$date','$name'); ";
		$sth=$db->query($q);
		pr($sth);
		
		pr($q);
		exit;
		
		// pr($q);
		// echo ($sth)? "Success":"Fail";			
		flashRedirect("students/datasheet/$scid","Updated enrollment.");			
		exit;		
	}


/* 
	// 4b - data student enrollment 
	$q="SELECT c.name,en.is_new,en.paymode_id,s.info_siblings,
			psum.promlvl,pl.name AS prevlevel			
		FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=$scid)		
		INNER JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id
		INNER JOIN {$dbo}.05_levels AS pl ON psum.currlvl=pl.id
		INNER JOIN {$dbg}.05_students AS s ON s.contact_id=c.id
		WHERE c.id=$scid LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['student']=$sth->fetch();
	debug($data['student']);
	
	$q="SELECT cr.id AS crid,cr.name AS classroom,cr.level_id AS lvl,l.name AS level
		FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE cr.section_id=1 ORDER BY cr.level_id;";
	$sth=$db->querysoc($q);
	$data['tmp_classrooms']=$sth->fetchAll();
	
 */
 
 