<?php





function mergeDuplicates($db,$sy,$scid_from,$scid_to){
	pr("<a href='".URL."mis/query' >Query</a>");	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$sch=VCFOLDER;
	/* scores */
	$q="UPDATE {$dbg}.50_scores SET scid=$scid_to WHERE scid=$scid_from;";
	pr($q);$sth=$db->query($q);echo ($sth)? "Scores Success":"Scores Fail";

	/* grades */
	$q="UPDATE {$dbg}.50_grades SET scid=$scid_to WHERE scid=$scid_from;";
	pr($q);$sth=$db->query($q);echo ($sth)? "Grades Success":"Grades Fail";


	/* summaries */
	$q="SELECT scid FROM {$dbg}.05_summaries WHERE scid=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if($row){
		$q="DELETE FROM {$dbg}.05_summaries WHERE scid=$scid_to;";
		$q.="UPDATE {$dbg}.05_summaries SET scid=$scid_to WHERE scid=$scid_from;";
		pr($q);$sth=$db->query($q);echo ($sth)? "Summaries Success":"Summaries Fail";		
	} else { pr($q);pr("Summaries - Do nothing. Already executed."); }
	

	/* summext */
	$q="SELECT scid FROM {$dbg}.05_summext WHERE scid=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if($row){
		$q="DELETE FROM {$dbg}.05_summext WHERE scid=$scid_to;";
		$q.="UPDATE {$dbg}.05_summext SET scid=$scid_to WHERE scid=$scid_from;";
		pr($q);$sth=$db->query($q);echo ($sth)? "Summext Success":"Summext Fail";
	} else { pr($q);pr("Summext - Do nothing. Already executed."); }
	

	/* students */
	$q="SELECT contact_id FROM {$dbg}.05_students WHERE contact_id=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if($row){
		$q="DELETE FROM {$dbg}.05_students WHERE contact_id=$scid_to;";
		$q.="UPDATE {$dbg}.05_students SET contact_id=$scid_to WHERE contact_id=$scid_from;";
		pr($q);$sth=$db->query($q);echo ($sth)? "Students Success":"Students Fail";
	} else { pr($q);pr("Students - Do nothing. Already executed."); }


	/* enrollments */
	$q="SELECT scid FROM {$dbo}.05_enrollments WHERE sy=$sy AND scid=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if($row){
		$q="DELETE FROM {$dbo}.05_enrollments WHERE sy=$sy AND scid=$scid_to;";
		$q.="UPDATE {$dbo}.05_enrollments SET scid=$scid_to WHERE sy=$sy AND scid=$scid_from;";
		pr($q);$sth=$db->query($q);echo ($sth)? "Enrollments Success":"Enrollments Fail";
	} else { pr($q);pr("Enrollments - Do nothing. Already executed."); }


	/* attd */
	$q="SELECT scid FROM {$dbg}.05_attendance WHERE scid=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if($row){
		$q="DELETE FROM {$dbg}.05_attendance WHERE scid=$scid_to;";
		$q.="UPDATE {$dbg}.05_attendance SET scid=$scid_to WHERE scid=$scid_from;";
		pr($q);$sth=$db->query($q);echo ($sth)? "Attd Success":"Attd Fail";
	} else { pr($q);pr("Attendance - Do nothing. Already executed."); }

	/* cdtgrades */
	$q="SELECT scid FROM {$dbg}.50_cdtgrades WHERE scid=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if($row){	
		$q="DELETE FROM {$dbg}.50_cdtgrades WHERE scid=$scid_to;";
		$q.="UPDATE {$dbg}.50_cdtgrades SET scid=$scid_to WHERE scid=$scid_from;";
		pr($q);$sth=$db->query($q);echo ($sth)? "CDT-Grades Success":"CDT-Grades Fail";
	} else { pr($q);pr("CDT Grades - Do nothing. Already executed."); }

	/* ar */
	$q="SELECT scid FROM {$dbg}.{$sch}_ar_{$sy} WHERE scid=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if($row){	
		$q="DELETE FROM {$dbg}.{$sch}_ar_{$sy} WHERE scid=$scid_to;";
		$q.="UPDATE {$dbg}.{$sch}_ar_{$sy} SET scid=$scid_to WHERE scid=$scid_from;";
		pr($q);$sth=$db->query($q);echo ($sth)? "AR Success":"AR Fail";
	} else { pr($q);pr("Accounts Receivables - Do nothing. Already executed."); }

	
	/* gradhonors */
	$q="UPDATE {$dbg}.50_gradhonors_{$sch} SET scid=$scid_to WHERE scid=$scid_from;";
	pr($q);$sth=$db->query($q);echo ($sth)? "Gradhonors Success":"Gradhonors Fail";

	pr("Purge");
	/* purge contact */
	$q="SELECT id FROM {$dbo}.00_contacts WHERE id=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$rowFrom=$sth->fetch();
	
	$q="SELECT id FROM {$dbo}.00_contacts WHERE id=$scid_to LIMIT 1; ";
	$sth=$db->querysoc($q);$rowTo=$sth->fetch();	
	if($rowFrom){	
		if($rowTo){
			$q="DELETE FROM {$dbo}.00_contacts WHERE id=$scid_from LIMIT 1;";
			pr($q);$sth=$db->query($q);echo ($sth)? "Purge Contact Success":"Purge Contact Fail";			
		} else {
			$q="UPDATE {$dbo}.00_contacts SET id=$scid_to WHERE id=$scid_from LIMIT 1;";
			pr($q);$sth=$db->query($q);echo ($sth)? "Move Contact Success":"Move Contact Fail";						
		}
	} else { pr($q);pr("Contacts - Do nothing. Already executed."); }
		

	/* purge profile */
	$q="SELECT id FROM {$dbo}.00_profiles WHERE contact_id=$scid_from LIMIT 1; ";
	$sth=$db->querysoc($q);$rowFrom=$sth->fetch();
	
	$q="SELECT id FROM {$dbo}.00_profiles WHERE contact_id=$scid_to LIMIT 1; ";
	$sth=$db->querysoc($q);$rowTo=$sth->fetch();	
	if($rowFrom){	
		if($rowTo){
			$q="DELETE FROM {$dbo}.00_profiles WHERE contact_id=$scid_from LIMIT 1;";
			pr($q);$sth=$db->query($q);echo ($sth)? "Purge Profile Success":"Purge Profile Fail";			
		} else {
			$q="UPDATE {$dbo}.00_profiles SET contact_id=$scid_to WHERE contact_id=$scid_from LIMIT 1;";
			pr($q);$sth=$db->query($q);echo ($sth)? "Move Profile Success":"Move Profile Fail";						
		}
	} else { pr($q);pr("Profiles - Do nothing. Already executed."); }

	echo "<br />Done.<hr />";
	
}	/* fxn */


	
	
	
	
	
	
	