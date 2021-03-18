<?php



function syncClassfeesToPayables($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	pr("&lvl&num");
	$lvl=isset($_GET['lvl'])? $_GET['lvl']:4;
	$num=isset($_GET['num'])? $_GET['num']:1;
	
	$q="SELECT *
		FROM {$dbo}.03_classfees 
		WHERE level_id=$lvl AND num=$num;
	";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	return $rows;
	
	
	if(isset($_GET['exe'])){
		$q="";
		
		
	}
	
	
	

	echo "<hr />";	

}	/* fxn */





// -------------------

function syncTsum($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q1=" SELECT scid FROM {$dbg}.`05_summaries` ORDER BY scid; ";
	$sth=$db->querysoc($q1);
	$a=$sth->fetchAll();
	$ac=$sth->rowCount();
	$ar=buildArray($a,'scid');	
	
	/* 2 */			
	$q2=" SELECT scid FROM {$dbg}.`03_tsummaries` ORDER BY scid; ";			
	$sth=$db->querysoc($q2);
	$b=$sth->fetchAll();
	$bc=$sth->rowCount();
	$br=buildArray($b,'scid');

	/* 3 */
	$ix=array_diff($ar,$br);

	pr("&tsum");
	pr("q1: $q1");
	pr("q2: $q2");
	echo (empty($ix))? "complete":"need syncing";
	
	if(isset($_GET['tsum'])){

		$ecid=$_SESSION['ucid'];$today=$_SESSION['today'];	
		if(!empty($ix)){
			$q=" INSERT INTO {$dbg}.03_tsummaries (`scid`) VALUES  ";
			foreach($ix AS $scid){ $q .= " ($scid),"; } $q = rtrim($q,",");$q .= "; ";
			pr($q);
			$sth=$db->query($q);echo "Summaries to Tsum: ";echo ($sth)? "Success":"Fail";			

		}	/* has-ix */
			
		
	}	/* tsum */
	
	echo "<hr />";

}	/* fxn */




function syncSummariesToEnrollments($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q1=" SELECT scid FROM {$dbg}.`05_summaries` ORDER BY scid; ";
	$sth=$db->querysoc($q1);
	$a=$sth->fetchAll();
	$ac=$sth->rowCount();
	$ar=buildArray($a,'scid');	
	
	/* 2 */			
	$q2=" SELECT scid FROM {$dbo}.`05_enrollments` WHERE sy=$sy ORDER BY scid; ";			
	$sth=$db->querysoc($q2);
	$b=$sth->fetchAll();
	$bc=$sth->rowCount();
	$br=buildArray($b,'scid');

	/* 3 */
	$ix=array_diff($ar,$br);
	pr("&summen");
	pr("q1: $q1");
	pr("q2: $q2");
	echo (empty($ix))? "complete":"need syncing";
	
	if(isset($_GET['summen'])){
		$ecid=$_SESSION['ucid'];$today=$_SESSION['today'];	
		if(!empty($ix)){
			$q=" INSERT INTO {$dbo}.05_enrollments (`sy`,`scid`) VALUES  ";
			foreach($ix AS $scid){ $q .= " ($sy,$scid),"; } $q = rtrim($q,",");$q .= "; ";
			pr($q);
			$sth=$db->query($q);echo "Summaries to Enrollments: ";echo ($sth)? "Success":"Fail";			
		}	/* has-ix */
			
		
	}	/* enrollments */	
	echo "<hr />";	

}	/* fxn */




function syncSummaries($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q1=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE `role_id`=1 AND `is_active`=1 ORDER BY id; ";
	$sth=$db->querysoc($q1);
	$a=$sth->fetchAll();
	$ac=$sth->rowCount();
	$ar=buildArray($a,'scid');	
	
	/* 2 */			
	$q2=" SELECT scid FROM {$dbg}.`05_summaries` ORDER BY scid; ";			
	$sth=$db->querysoc($q2);
	$b=$sth->fetchAll();
	$bc=$sth->rowCount();
	$br=buildArray($b,'scid');

	/* 3 */
	$ix=array_diff($ar,$br);
	pr("&consumm");
	pr("q1: $q1");
	pr("q2: $q2");
	echo (empty($ix))? "complete":"need syncing";
	
	if(isset($_GET['consumm'])){
		$ecid=$_SESSION['ucid'];$today=$_SESSION['today'];	
		if(!empty($ix)){
			$q=" INSERT INTO {$dbg}.05_summaries (`scid`) VALUES  ";
			foreach($ix AS $scid){ $q .= " ($scid),"; } $q = rtrim($q,",");$q .= "; ";
			pr($q);
			$sth=$db->query($q);echo "Active R1 Contacts to Summaries: ";echo ($sth)? "Success":"Fail";			
		}	/* has-ix */
			
		
	}	/* enrollments */	
	echo "<hr />";	

	
}	/* fxn */




function syncCtp($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q1=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE `is_active`=1 ORDER BY id; ";
	$sth=$db->querysoc($q1);
	$a=$sth->fetchAll();
	$ac=$sth->rowCount();
	$ar=buildArray($a,'scid');	
	
	/* 2 */			
	$q2=" SELECT contact_id AS scid FROM {$dbo}.`00_ctp` ORDER BY contact_id; ";			
	$sth=$db->querysoc($q2);
	$b=$sth->fetchAll();
	$bc=$sth->rowCount();
	$br=buildArray($b,'scid');

	/* 3 */
	$ix=array_diff($ar,$br);
	pr("&ctp");
	pr("q1: $q1");
	pr("q2: $q2");
	echo (empty($ix))? "complete":"need syncing";
	
	if(isset($_GET['ctp'])){
		if(!empty($ix)){
			$q=" INSERT INTO {$dbo}.00_ctp (`contact_id`) VALUES  ";
			foreach($ix AS $scid){ $q .= " ($scid),"; } $q = rtrim($q,",");$q .= "; ";
			pr($q);
			$sth=$db->query($q);echo "Active Contacts to CTP: ";echo ($sth)? "Success":"Fail";			
		}	/* has-ix */		
	}	/* enrollments */	
	echo "<hr />";	

}	/* fxn */

function syncProfiles($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q1=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE role_id=1 AND `is_active`=1 ORDER BY id; ";
	$sth=$db->querysoc($q1);
	$a=$sth->fetchAll();
	$ac=$sth->rowCount();
	$ar=buildArray($a,'scid');	
	
	/* 2 */			
	$q2=" SELECT contact_id AS scid FROM {$dbo}.`00_profiles` ORDER BY contact_id; ";			
	$sth=$db->querysoc($q2);
	$b=$sth->fetchAll();
	$bc=$sth->rowCount();
	$br=buildArray($b,'scid');

	/* 3 */
	$ix=array_diff($ar,$br);
	pr("&profiles");
	pr("q1: $q1");
	pr("q2: $q2");
	echo (empty($ix))? "complete":"need syncing";
	
	if(isset($_GET['profiles'])){
		if(!empty($ix)){
			$q=" INSERT INTO {$dbo}.`00_profiles` (`contact_id`) VALUES  ";
			foreach($ix AS $scid){ $q .= " ($scid),"; } $q = rtrim($q,",");$q .= "; ";
			pr($q);
			$sth=$db->query($q);echo "Active Student-Contacts to Profiles: ";echo ($sth)? "Success":"Fail";			
		}	/* has-ix */		
	}	/* enrollments */	
	echo "<hr />";	

}	/* fxn */


function syncAttendance($db,$dbg=PDBG){
	$dbo=PDBO;
	$q1=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE role_id=1 AND `is_active`=1 ORDER BY id; ";
	$sth=$db->querysoc($q1);
	$a=$sth->fetchAll();
	$ac=$sth->rowCount();
	$ar=buildArray($a,'scid');	
	
	/* 2 */			
	$q2=" SELECT scid FROM {$dbg}.`05_attendance` ORDER BY scid; ";				
	$sth=$db->querysoc($q2);
	$b=$sth->fetchAll();
	$bc=$sth->rowCount();
	$br=buildArray($b,'scid');

	/* 3 */
	$ix=array_diff($ar,$br);
	pr("&attd");
	pr("q1: $q1");
	pr("q2: $q2");
	echo (empty($ix))? "complete":"need syncing";
	
	if(isset($_GET['attd'])){
		if(!empty($ix)){
			$q=" INSERT INTO {$dbg}.`05_attendance` (`scid`) VALUES  ";
			foreach($ix AS $scid){ $q .= " ($scid),"; } $q = rtrim($q,",");$q .= "; ";
			pr($q);
			$sth=$db->query($q);echo "Active Student-Contacts to Attendance: ";echo ($sth)? "Success":"Fail";			
		}	/* has-ix */		
	}	/* enrollments */	
	echo "<hr />";	

}	/* fxn */


function syncEnrollmentsToSummaries($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	/* 1 */
	$q1=" SELECT scid FROM {$dbo}.`05_enrollments` WHERE `sy`=$sy ORDER BY scid; ";						
	$sth=$db->querysoc($q1);
	$a=$sth->fetchAll();
	$ac=$sth->rowCount();	
	$ar=buildArray($a,'scid');
	
	/* 2 */
	$q2=" SELECT scid FROM {$dbg}.`05_summaries` ORDER BY scid; ";						
	$sth=$db->querysoc($q2);
	$b=$sth->fetchAll();
	$bc=$sth->rowCount();
	$br=buildArray($b,'scid');

	/* 3 */
	$ix=array_diff($ar,$br);
	pr("&ensumm");
	pr("q1: $q1");
	pr("q2: $q2");
	echo (empty($ix))? "complete":"need syncing";
		
	if(!empty($ix)){
		$q=" INSERT INTO {$dbg}.05_summaries(`scid`) VALUES  ";
		foreach($ix AS $scid){ $q .= "($scid),";} $q=rtrim($q,",");$q.="; ";		
		if(isset($_GET['query'])){ pr($q); }
		$sth=$db->query($q);echo "Enrollments To Summaries: ";echo ($sth)? "Success":"Fail";			
	}	/* has-ix */ 
	echo "<hr />";
	
	
}	/* fxn */



function syncSummcridToEnrollments($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	pr("&encrid");
	$q="UPDATE {$dbo}.05_enrollments AS en
		INNER JOIN {$dbg}.05_summaries AS summ ON (en.sy=$sy && summ.scid=en.scid)
		SET en.crid=summ.crid; ";
	pr($q);	
	if(isset($_GET['encrid'])){
		$sth=$db->query($q);
		$msg=($sth)? "Sucess":"Fail"; 
		debug("$msg - $q");		
	}	/* encrid */
	echo "<hr />";
		
}	/* fxn */


function syncPromotions($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$pdbg=VCPREFIX.($sy-1).US.DBG;

 		// SET summ.crid=psum.promcrid; ";

	pr("&promsumm");
	$q="UPDATE {$dbg}.05_summaries AS summ
		INNER JOIN {$pdbg}.05_summaries AS psum ON summ.scid=psum.scid
		INNER JOIN {$pdbg}.05_classrooms AS cr ON (psum.promlvl=cr.level_id && cr.section_id=1)
 		SET summ.crid=cr.id; ";				
	pr($q);	
	if(isset($_GET['promsumm'])){
		$sth=$db->query($q);
		$msg=($sth)? "Sucess":"Fail"; 
		pr("Promsumm - $msg");		
	}	/* encrid */
	echo "<hr />";

	$q="UPDATE {$dbo}.05_enrollments AS en
		INNER JOIN {$dbg}.05_summaries AS summ ON (en.sy=sy && en.scid=summ.scid)
 		SET en.crid=summ.crid WHERE en.sy=$sy; ";		
		
	pr($q);	
	if(isset($_GET['promsumm'])){
		$sth=$db->query($q);
		$msg=($sth)? "Sucess":"Fail"; 
		pr("summcrid To encrid - $msg");		
	}	/* encrid */
	echo "<hr />";

		
}	/* fxn */

function syncTables($db,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	pr("Param-SY: $sy");
	$has_axis=$_SESSION['settings']['has_axis'];


	syncSummaries($db,$sy);	/* contacts-summaries */
	syncSummariesToEnrollments($db,$sy);	/* summaries-enrollments */
	syncSummcridToEnrollments($db,$sy);	/* summcrid-enrollment */			
	syncCtp($db,$sy);	/* summcrid-tsum */	
	syncProfiles($db,$sy);	/* summcrid-tsum */	
	syncAttendance($db,$dbg);	/* summcrid-tsum */	
	syncPromotions($db,$sy);
	
	if($has_axis){
		syncTsum($db,$sy);	/* summcrid-tsum */	
		syncClassfeesToPayables($db,$sy);	/* summcrid-tsum */	
		
		
	}	/* has_axis */
	
	pr("<a href='".URL."mis/query' >Query</a>");

	if(isset($_GET['exe'])){
		pr("<h3 style='color:brown' >Year *{$sy} Sync Summaries-Enrollments - &debug | GET-query for insert</h3>");
		debug("if summscid NOT in other CES-Tables | DELETE FROM {$dbg}.`05_summaries` WHERE scid=; ");
		debug("<a href='".URL."mis/query' >Query</a>");
		echo "<div class='ht100'>&nbsp;</div>";		
	}
	pr("&exe");	
	
}	/* fxn */

	
	