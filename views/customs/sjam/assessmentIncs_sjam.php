<?php

	$sch=VCFOLDER;
	$incfile=SITE."views/customs/{$sch}/incs/enrollmentFxn_{$sch}.php";
	if(is_readable($incfile)){ include_once($incfile); $getAssessment="getAssessmentSjam"; } else { $getAssessment="getAssessment"; }
	include_once($incfile); 
	extract($student);
	
	/* process */
	$payarr=parsePayables($payables);	
	$discounts=$payarr['discounts'];
	$nondiscounts=$payarr['nondiscounts'];
	$student['total_discount']=$total_discount=$payarr['total_discount'];
	$student['total_nondiscount']=$total_nondiscount=$payarr['total_nondiscount'];
	$student['total_adjustment']=$total_adjustment=$total_nondiscount-$total_discount;
	
	
	/* process */	
	$arp=adjustPayablesSjam($student);
	// pr($arp);
	$interest=$arp['interest'];
	$adjusted_periodic=$arp['adjusted_periodic'];
	$initial_periodic=$arp['initial_periodic'];
	$student['resfee_paid']=$resfee_paid=getResfee($payments);
	$has_resfee=($resfee_paid>0)? true:false;

	/* process */
	$paymentsarr=parsePayments($payments);
	extract($paymentsarr);
	// $total_payable=($adjusted_periodic*$duedates_count)+$previous_balance+$total_nondiscount;

	$total_payable=0;
	foreach($payables AS $row){
		if($row['feetype_id']==1){
			$total_payable+=$row['amount'];
		}
	}
	
	$total_payable=$total_payable+$previous_balance+$total_nondiscount;		
	
	$total_payment=$paymentsarr['total_payment'];
	$total_balance=($total_payable-$total_payment);
	$balance_cutoff=$_SESSION['settings']['balance_cutoff'];	
	// $has_previous_balance=($previous_balance>$balance_cutoff)? true:false;
	$has_previous_balance=($previous_balance>0)? true:false;
	$has_other_payables=($total_nondiscount>0)? true:false;

	$logo_src=URL.'public/images/weblogo_sjam.png';	



	$tfd=getTfeesFromPayables($db,$sy,$scid);
	$tfeePayables=$tfd['rows'];
	$num_tfeePayables=$tfd['count'];
	
	/* updatePayablesWithTfees */
	$did_crud=syncTfeePayables($db,$sy,$scid,$arp,$tfd,$student);
	if($did_crud){ pr("assessment-did_crud:"); $payables=scidPayables($db,$sy,$scid,$fields=NULL); }

		
