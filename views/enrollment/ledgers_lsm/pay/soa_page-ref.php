

<?php 
	// pr($data);
	// pr($students);
	

	$pmid = $student['paymode_id'];
	if(($pmid>4) || ($pmid<1)):
?>
	<div class="clear" ></div>
	<h5 class="red" >Please correct the <a href="<?php echo URL.'assessment/assess/'.$student['scid']; ?>" >Paymode</a></h5>
<?php 
	exit;	
	endif; 
?>
	

<?php 

	$paymode_id = $student['paymode_id'];
	$paymode_code = $student['paymode_code'];
	$scid = $student['scid'];
	$discounts = round($student['discounts'],2);
	$tsumremarks = $student['tsumremarks'];
	$numperiods = $student['numperiods']; 
	$dpfee = round($tuition[$paymode_code.'_dpfee'],2);
	$dpdue = $tuition[$paymode_code.'_dpdue'];
		
	if($paymode_id!=1){	/* not 1:annual */
		$leftperiods = $numperiods-1;
		$limitperiods = $numperiods+1;
		$leftassessed = $assessed-$tuition[$paymode_code.'_dpfee'];
		$annuity = $leftassessed/$leftperiods;
		$paydates = $student['paydates'];
		$rpaydates = explode(',',$paydates);		
		$numpays = count($rpaydates);
		$annuity = ($tuition['total']-$dpfee)/$numpays;						
	} else {
		$leftperiods = 0;$limitperiods = 2;$leftassessed = 0;$annuity = 0;$paydates = NULL;
		$rpaydates = array();$numpays = 0;$annuity = 0;		
	} 	/* not 1:annual */

	$discperiod = isset($student['discounts'])? $student['discounts']/$numperiods:0;		
	$stp = $tpays[$i];	/* studtpays */				
	$fpaid=0;
	foreach($stp AS $tpay){
		$fpaid+=$tpay['amountpaid'];	
	}	/* fxn */
	$tfpaid=$fpaid=round($fpaid,2);

	$atp = $apays[$i];	/* studapays */				
	$apaid=0;
	foreach($atp AS $apay){
		$apaid+=$apay['amountpaid'];	
	}	/* fxn */
	$tapaid=$apaid=round($apaid,2);			
		
	$tpaid=$fpaid+$apaid;	
	$total_fees=$assessed-$discounts;	
	$atotal=$student['addons'];
	$taddons=0;

?>



<div class="center clear" style="" >

<?php 	
	$inc = SITE.'views/elements/letterhead_datetime.php';
	include($inc); 
	
?>

</div>

<hr />	
<!-------------------------------->

<div style="float:left;width:50%;"  >
<table class="table-fx" >
<tr><th >ID | Name</th><td><?php echo $student['studcode'].' - '.$student['student']; ?></td></tr>
<tr><th >Classroom</th><td><?php echo $student['classroom']; ?></td></tr>
</table>
</div>

<div style="float:left;width:45%;"  >
<table class="table-fx" >
<tr><th >Payment Period</th><td>
	<?php  // echo $ldm; ?>
	<?php  echo $ppr; ?>
<span class="screen" > 
	| <a href="<?php echo URL.'ledgers/pay/'.$student['scid'].DS.$sy; ?>" >Ledger</a>
	| <a href="<?php echo URL.'soas/soa/'.$student['scid'].DS.$sy; ?>" >SOA</a>
	| <a href="<?php echo URL.'assessment/assess/'.$student['scid'].DS.$sy; ?>" >Assmt</a>
</span>
</td></tr>
<tr><th >Payment Mode</th><td><?php echo $student['paymode']; ?>
<?php if($student['is_active']!=1): ?>
	| <span class="red" >Dropped</span>
<?php endif; ?>
</td></tr>
</table>
</div>
<br />
<br />

<div class="clear" ><hr /></div>

<!--------------------------------->
<div class="clear" >	<!-- tuition clear -->

<div style="margin-left:30%;" ><span  class="b tf16" >Assessment</span></div>

<table class='' >
<?php foreach($tuitions AS $row): ?>
<tr><td><?php echo $row['feetype']; ?></td><td class="vc300" >&nbsp;</td><td class="right" >
	<?php echo number_format($row['amount'],2); ?></td></tr>
<?php endforeach; ?>

<tr>
<th>Discounts</th>
<td><?php foreach($disces[$i] AS $row){ echo $row['name'].'<br />'; }  ?></td>
<td class="right" >(<?php echo number_format($discounts,2); ?>)</td>
</tr>


<tr><th colspan="2" >Total Fees</th><th class="right" >
	<span class="dr" ><?php echo number_format($total_fees,2); ?></span>
</th></tr>


</table>

</div>	<!-- tuition clear -->

<p>&nbsp;</p>
<!-------------------------------------->

<div class="" style="float:left;width:100%;"  >	<!-- tuition clear -->
<table class="" style=""  >
<tr>
	<th style="border-bottom:1px solid black;" class="center" colspan="3" >Assessed Payables</th>
	<th class="center vc10"  >|</th>
	<th style="border-bottom:1px solid black;" class="center" colspan="3" >Payments</th>
</tr>
<tr>
	<th class="vc120" >Description</th>
	<th class="vc100" >Due Date</th>
	<th class="right vc70" >Amount</th>
	<td class='vc10' >&nbsp;</td>
	<th>
		<div class='vc100' style="float:left;"  >OR Date</div>  
		<div class='vc80' style="float:left;"  >OR No.</div>
		<div class='vc120 right' style="float:left;"  >Amount</div>  
	</th>	<!-- 5 -->
	<th class="right" >Due</th>	<!-- 6 -->
</tr>

<?php 

	$rcoll=0;
	$currdue=0;
	$totaloverdue=0;
	$bill=0;
	$fdues=0;
	$adues=0;
	$tsurg=0;	/* total surcharge */
	
	$datedue = $tuition[$paymode_code.'_dpdue'];
	$amountdue = $tuition[$paymode_code.'_dpfee'];
	$pamt=pamt($amountdue,$discperiod);	
	$isdue = isdue($datedue,$ldm);	
	if($isdue){$rcoll+=$pamt; }
	$bill+=$pamt;

	$tmp = $pamt-$fpaid;
	$fdue = ($tmp<0)? 0: $tmp;
	$fpaid = ($tmp<0)? $tmp*-1:0;
	$fdues = ($isdue)? $fdues+=$fdue:$fdues;
	
	/* 2 surg */		
	$surg = ($isdue && $fdue>0)? getSurcharge($fdue,$pmid,$datedue,$ldm,$paymodes):0;		
	$tsurg+=$surg;
	

	if((!$isdue) && (date('m',strtotime($datedue))==$como)){ $currdue+=$fdue; } 
	if($isdue){ $totaloverdue+=$fdue; } 
	

	
?>


<tr>
	<td>Reservation / Tuition</td>
	<td><?php echo $datedue; ?></td>
	<td class="right" ><?php echo number_format($pamt,2); ?></td>
	<td>&nbsp;</td>	
	<td class="right" >	
	<?php 
		echo "<table class='full ' >";		
		foreach($tpays[$i] AS $tpay){
			if($tpay['pointer']<2){
				echo "<tr><td class='vc80' >".$tpay['datepaid'];
				echo "</td><td class='vc60' >".$tpay['orno']."</td>"; 
				echo "<td class='right vc50' >".number_format($tpay['amountpaid'],2).'</td></tr>'; 			
			} /* if */		
		}	/* foreach */
		echo "</table>";
		
		
	?>
	</td>
	<td class="right" ><?php echo number_format($fdue,2); ?></td>	
	<td><?php ?></td>

</tr>

<!------------------ tuits 2 onwards --------------------->

<?php if($paymode_id!=1): ?>	<!-- if not paymode id of 1:yearly -->
<?php for($j=2;$j<$limitperiods;$j++): ?>	<!-- leftperiods -->
<?php 

	$k=$j-2; 
	$datedue = trim($rpaydates[$k]);
	$pamt=pamt($annuity,$discperiod);
	$isdue = isdue($datedue,$ldm);		
	$bill+=$pamt;	
	$isdue = isdue($datedue,$ldm);		
	if($isdue){$rcoll+=$pamt; }	
	$tmp = $pamt-$fpaid;
	$fdue = ($tmp<0)? 0: $tmp;
	$fpaid = ($tmp<0)? $tmp*-1:0;
	$fdues = ($isdue)? $fdues+=$fdue:$fdues;

	
	/* 2 surg */		
	$surg = ($isdue && $fdue>0)? getSurcharge($fdue,$pmid,$datedue,$ldm,$paymodes):0;
	$tsurg+=$surg;
	
	if((!$isdue) && (date('m',strtotime($datedue))==$como)){ $currdue+=$fdue; } 	
	if($isdue){ $totaloverdue+=$fdue; } 
	

?>

<tr>
	<td>Tuition - <?php echo getOrdinal($j).' Payment'; ?>
		<?php 
		
		?>
	</td>
	<td class="vc100" ><?php echo $datedue; ?></td>
	<td class="right vc70" ><?php echo number_format($pamt,2); ?> </td>	<!-- 3 -->
	<td>&nbsp;</td>
	
	<td class="right" >	
	<?php 
		$tp=0;
		echo "<table class='full ' >";		
		foreach($tpays[$i] AS $tpay){
			if($tpay['pointer']==$j){
				echo "<tr><td class='vc100' >".$tpay['datepaid'];
				echo "</td><td class='vc80' >".$tpay['orno']."</td>";  
				echo "<td class='right vc50' >".number_format($tpay['amountpaid'],2).'</td></tr>'; 			
			} /* if */		
		}	/* foreach */
		echo "</table>";
								
	?>

	</td>
	<td class="right" ><?php echo ($isdue)? number_format($fdue,2):NULL; ?></td>		

</tr>	
<?php endfor; ?>	<!-- leftperiods -->
<?php endif; ?>	<!-- if not paymode id of 1:yearly -->

</table>
</div>	<!-- tuition clear -->


<p>&nbsp;</p>
<?php $fextra=round($tpaid,2)-round($total_fees,2); ?>

<h5>
<?php 
	
?>

</h5>

<div class="" style="float:left;width:100%;"  >	<!-- tuition clear -->
<?php if(!empty($auxes[$i])): ?>	<!-- has addons -->
<table class="no-gis-table-bordered" style=""  >

<tr class="" >
	<th class="vc150" >Addons</th>
	<th class="vc30" ></th>
	<th class="right vc70" >Amount</th>
	<td class='vc10' >&nbsp;</td>
	<th><table class="" >
			<tr><th class="vc100" >OR Date</th><th class="vc80" >OR No.</th><th class="vc120 right" >Amount</th></tr>
	</table></th>	<!-- 5 -->
	<th class="right" >Due</th>	<!-- 6 -->
</tr>

<?php 


$apaid=($fextra>0)? $apaid+=$fextra:$apaid;
foreach($auxes[$i] AS $row):	
	$feetype_id = $row['feetype_id'];
	$datedue=$row['datedue'];
	$pamt = $row['amountdue'];
	$taddons+=$pamt;
	$isdue=true;
	$rcoll+=$pamt;	
	$bill+=$pamt;	
	
	$tmp = $pamt-$apaid;
	$adue = ($tmp<0)? 0: $tmp;
	$apaid = ($tmp<0)? $tmp*-1:0;
	$adues = $adues+=$adue;

	$rowdue=$pamt;

	
?>




<tr>
	<td><?php echo $row['feetype']; ?></td>
	<td class="vc30" >
	<?php 
	
	?></td>
	<td class="right vc70" ><?php echo number_format($pamt,2); ?></td>	<!-- 3 -->
	<td><?php 
	
	?></td>
	<td class="right" >	
	<?php 
		echo "<table class='full' >";		
		foreach($apays[$i] AS $apay){
			if(($apay['feetype_id']==$feetype_id) && ($apay['pointer']==$row['num'])){	
				$rowdue=$pamt-$apay['amountpaid']; 
				$pamt-=$apay['amountpaid'];
				echo "<tr><td class='vc80' >".$apay['datepaid'];
				echo "</td><td class='vc60' >".$apay['orno']."</td>";  
				echo "<td class='right vc100' >".number_format($apay['amountpaid'],2)."</td></tr>"; 			
			} /* if */
		}	/* foreach */
		echo "</table>";
				
	?>

	</td>
	<td class="right" ><?php echo number_format($rowdue,2); ?>
	</td>		
</tr>	
<?php endforeach; ?>	<!-- foreach auxes -->

</table>	
<?php endif; ?>	<!-- has addons -->
</div>	<!-- auxes clear -->

<!---------- aux clear ---------->

<div style="padding-left:60%;" >
<h5>
<?php 
$fdues=round($fdues,2);
$totalcoll=round($total_fees,2)+round($taddons,2); 
$totalbal=round($tpaid,2)-round($totalcoll,2);
$adues+=$fextra; 
$abal=round($adues,2)-round($apaid,2);
$tbal=$tfpaid-$total_fees;	

$overtpayamt=($tbal>0)? $tbal:0;
$addons=$taddons-$tapaid-round($overtpayamt,2); 


$tdues=round($currdue,2)+round($totaloverdue,2)+round($tsurg,2)+round($addons,2); 



?>

</h5>

<table class="no-gis-table-bordered" style="font-size:1.1em;"  >
	<tr><th colspan="2" ></th></tr>
	<tr><td>Current Due</td><td class="right" ><?php echo number_format($currdue,2); ?></td></tr>
	<tr><td>Total Overdue</td><td class="right" ><?php echo number_format($totaloverdue,2); ?></td></tr>
	<tr><td>Surcharge</td><td class="right" ><?php echo number_format($tsurg,2); ?></td></tr>
<?php  if($totalbal>0): ?>	
	<tr><td>Addons</td><td class="right" ><?php echo '0.00'; ?></td></tr>
	<tr><th>Total Dues</th><th class="right" ><?php echo '0.00'; ?></th></tr>
	<tr><th>Overpayment</th><th class="right" ><?php echo number_format($totalbal,2); ?></th></tr>
	<tr><th colspan="2" class="right" >
		<button id="ovrbtn<?php echo $i; ?>" onclick="ovrefund(<?php echo $i.','.$scid.','.round($totalbal); ?>);" >
				Refund </button></th>
	</tr>
	
<?php else: ?>
	<?php ?>
	<tr><td>Addons</td><td class="right" ><?php echo number_format($addons,2); ?></td></tr>
	<tr><th>Total Dues</th><th class="right" ><?php echo number_format($tdues,2); ?></th></tr>
<?php endif; ?>
</table>

</div>




<p>&nbsp;</p>


<div class="center" id="soafooter" >
<table class="no-gis-table-bordered" style="width:600px;" >

<?php if(isset($_GET['reminders'])): ?>
<tr><td colspan='2' style=""> <span class='b' >Reminder:</span> <?php echo $_SESSION['settings']['soa_message']; ?></td></tr>
<?php endif; ?>

<tr><th>Remarks</th><td>
<textarea onchange="xsaveTsumRemarks(this.value,<?php echo $scid; ?>);return false;" style="border:none;"
	rows="4" cols="80" id="remarks<?php echo $i; ?>"  /><?php echo $student['tsumremarks']; ?></textarea>
</td></tr>
</table>

<table class="" >
	<tr><td class="center" >Computer Generated Report. Signature Not Required.</td></tr>
	<tr><td class="center" >Date & Time Printed: <?php echo $timestamp; ?> </td></tr>
</table>

</div>	<!-- soafooter -->

