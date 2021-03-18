<?php




function updateTfeePayables($db,$sy,$scid){
	require_once(SITE."functions/enrollmentFxn.php");
	$sch=VCFOLDER;$ucSch=ucfirst($sch);
	$incfile=SITE."views/customs/{$sch}/incs/enrollmentFxn_{$sch}.php";
	if(is_readable($incfile)){ include_once($incfile); $arpFxn="adjustPayables{$ucSch}"; 
	} else { $arpFxn="adjustPayables"; }
	
	
	$star=scidAssessment($db,$sy,$scid,$fields=NULL);		// 1
	$student=$star['student'];		
	$arp=$arpFxn($student);									// 2
	$tfd=getTfeesFromPayables($db,$sy,$scid);				// 3

	$did_sync=syncTfeePayables($db,$sy,$scid,$arp,$tfd,$student);

	
	


}	/* fxn */
	
	
function updatePayableBalanceByScid($db,$sy,$scid){
	require_once(SITE."functions/enrollmentFxn.php");
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT *,id AS pkid,id AS payable_id FROM {$dbo}.30_payables WHERE sy=$sy AND scid=$scid ORDER BY feetype_id,ptr; ";
	$sth=$db->querysoc($q);
	$payables=$sth->fetchAll();
	
	// pr($payables);
	
	$q="SELECT *,id AS pkid,id AS payment_id FROM {$dbo}.30_payments WHERE sy=$sy AND scid=$scid ORDER BY feetype_id,ptr; ";
	$sth=$db->querysoc($q);
	$payments=$sth->fetchAll();

	$resfee_paid=0;	
	foreach($payments AS $payment){
		if($payment['feetype_id']==2){
			$resfee_paid+=$payment['amount'];
		}
	}
	
	foreach($payables AS $payable){
		if($payable['feetype_id']==1 AND $payable['ptr']==1){
			$payable['amount']-=$resfee_paid;
		}
		updatePayableBalance($db,$payable,$payments);
	}
	

	
}	/* fxn */




