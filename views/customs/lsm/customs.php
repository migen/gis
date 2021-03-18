<?php


$_SESSION['pos_order']=$pos_order="prepend";
$_SESSION['resfee']=$resfee="2500";
$_SESSION['is_enrolled_amount']=$is_enrolled_amount="5001";
$_SESSION['library_interval']=$library_interval="30";		/* library long enough */
$_SESSION['library_setup']=$library_setup=false;	/* ipdiff */
$_SESSION['library_photos']=$library_photos=true;	/* accor_library */
// $library_setup=true;



function updateIsEnrolled($db,$sy){
	// echo "custom LSM function for enrollment status";
	$is_enrolled_amount=$_SESSION['is_enrolled_amount'];
	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	/* updateIsEnrolled */
	$q="UPDATE {$dbo}.`00_contacts` AS a
		INNER JOIN {$dbg}.05_summaries AS summ ON a.id=summ.scid
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN (
			SELECT scid FROM {$dbg}.03_tsummaries WHERE paid<'$is_enrolled_amount'
		) AS b ON a.id=b.scid
		SET a.is_enrolled='0'
		WHERE a.is_enrolled='1';";
	pr($q);
	$db->query($q);	/* 5 */

	$q="UPDATE {$dbo}.`00_contacts` AS a
		INNER JOIN {$dbg}.05_summaries AS summ ON a.id=summ.scid
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id	
		INNER JOIN (
			SELECT scid FROM {$dbg}.03_tsummaries WHERE paid>='$is_enrolled_amount'
		) AS b ON a.id=b.scid
		SET a.is_enrolled='1'
		WHERE a.is_enrolled='0'; ";	
	pr($q);
	$db->query($q);		/* 6 */	
	exit;
	
	
	
}
