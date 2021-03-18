<?php


$_SESSION['pos_order']=$pos_order="prepend";
$_SESSION['resfee']=$resfee="2500";
$_SESSION['is_enrolled_amount']=$is_enrolled_amount="5001";



function updateIsEnrolled($db,$sy){
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
