<?php

function syncLevelConducts($db,$params){
	$data['lvl']=$lvl=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	$q="
		UPDATE {$dbg}.05_summaries AS a 
		INNER JOIN (
			SELECT
				summ.id AS summid,cr.name AS classroom,c.id AS scid,c.code AS studcode,c.name AS student,g.q{$qtr} AS grade,
				summ.conduct_q{$qtr} AS summgrade
			FROM {$dbo}.`00_contacts` AS c
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbg}.50_grades AS g ON g.scid=c.id
			WHERE g.crstype_id=5 AND cr.level_id=$lvl	
		) AS b ON a.id = b.summid
		SET a.conduct_q{$qtr}=b.grade		
		
		
	";
	
	if(isset($_GET['debug'])){ pr('<h1>Remove &debug to execute.</h1>'); prx($q); }	
	$sth=$db->query($q);
	echo ($sth)? "Success":"Fail";		
	shovel('return');
	
	
	
	
/* 	
	pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";		
	} else {
		pr("&exe to process");
	}
 */	
		
}	/* fxn */