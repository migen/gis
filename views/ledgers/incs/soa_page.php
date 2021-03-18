
<?php 
	$pmid = $student['paymode_id'];
	if(($pmid>4) || ($pmid<1)):
?>
	<div class="clear" ></div>
	<h5 class="red" >Please correct the <a href="<?php echo URL.'ledgers/student/'.$student['scid']; ?>" >Paymode</a></h5>
<?php 
	exit;	
	endif; 
?>
	

<?php 

	
	$paymode_id = $student['paymode_id'];
	$paymode_code = $student['paymode_code'];
	$numperiods = $student['numperiods']; 
	$dpfee = $tuition[$paymode_code.'_dpfee'];
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
						
	} 	/* not 1:annual */
	
	$discperiod = isset($student['discounts'])? $student['discounts']/$numperiods:0;		

	$stp = $tpays[$i];	/* studtpays */		
	$tpaid=0;
	foreach($stp AS $tpay){
		if($tpay['feetype_id']==$tfeeid){
			$tpaid+=$tpay['amountpaid'];	
		}
	}	/* fxn */
	$tpaid=number_format($tpaid,2,'.','');
	

	$atp = $apays[$i];	/* studapays */			
	$apaid=0;
	foreach($atp AS $apay){
		$apaid+=$apay['amountpaid'];	
	}	/* fxn */
	$apaid=number_format($apaid,2,'.','');
	
	$tpaid+=$apaid;
	
?>



<div class="center clear" style="" >

<?php 
	
	$inc = SITE.'views/customs/'.VCFOLDER.'/letterhead.php';
	include($inc); 
	
?>

</div>

<hr />	
<!--------------------------------------------------------------------------------------------------------------->

<div style="float:left;width:50%;"  >
<table class="table-fx" >
<tr><th >Student ID | Name</th><td><?php echo $student['studcode'].' - '.$student['student']; ?></td></tr>
<tr><th >Classroom</th><td><?php echo $classroom['level'].' - '.$classroom['section']; ?></td></tr>
</table>
</div>

<div style="float:left;width:45%;"  >
<table class="table-fx" >
<tr><th >Payment Period</th><td><?php echo getPeriod($student['periods']); ?>
<span class="screen" > 
	| <a href="<?php echo URL.'ledgers/student/'.$student['scid']; ?>" >Ledger</a>
	| <a href="<?php echo URL.'ledgers/soa/'.$student['scid']; ?>" >SOA</a>
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

<!--------------------------------------------------------------------------------------------------------------->
<div class="clear" >	<!-- tuition clear -->

<div style="margin-left:30%;" ><span  class="b tf16" >Assessment</span></div>

<table class='gis-table-bordered' >
<?php foreach($tuitions AS $row): ?>
<tr><td><?php echo $row['feetype']; ?></td><td class="vc300" >&nbsp;</td><td class="right" >
	<?php echo number_format($row['amount'],2); ?></td></tr>
<?php endforeach; ?>

<?php $discounts=0; ?>
<tr>
<th>Discounts</th>
<?php 
	echo '<td class="right" >';
	foreach($disces[$i] AS $disc){
		$discounts+=$disc['amountdue'];
		echo $disc['feetype'].' - '.number_format($disc['amountdue'],2).'<br />';
	} 
	echo '</td>';
?>
<td class="right" >(<?php echo number_format($discounts,2); ?>)</td>
</tr>

<?php $assessed-=$discounts; ?>

<tr><th colspan="2" >Total Fees</th><th class="right" >
	<span class="dr" ><?php echo number_format($assessed,2); ?></span>
</th></tr>


</table>

</div>	<!-- tuition clear -->

<p>&nbsp;</p>
<!--------------------------------------------------------------------------------------------------------------->

<div class="" style="float:left;width:100%;"  >	<!-- tuition clear -->
<table class="" >
<tr>
	<th style="border-bottom:1px solid black;" class="center" colspan="3" >Assessed Payables</th>
	<th class="center vc20"  >|</th>
	<th style="border-bottom:1px solid black;" class="center" colspan="2" >Payments</th>
</tr>
<tr>
	<th class="vc150" >Description</th>
	<th class="vc80" >Due Date</th>
	<th class="right vc80" >Amount</th>
	<td class='vc20' >&nbsp;</td>
	<th>
		<div class='vc80' style="float:left;"  >OR Date</div>  
		<div class='vc80' style="float:left;"  >OR No.</div>
		<div class='vc50 right' style="float:left;"  >Amount</div>  
	</th>	<!-- 5 -->
	<th class="right" >Due</th>	<!-- 6 -->
	<th class="hd right" >Debit<br /><?php echo number_format($tpaid,2); ?></th>	<!-- 6 -->
	
</tr>

<?php 

	$tbalance=0;	
	$nowdues=0;
	
	$datedue = $tuition[$paymode_code.'_dpdue'];
	$amountdue = $tuition[$paymode_code.'_dpfee'];
	$pamt=pamt($amountdue,$discperiod);
	$tbalance = $pamt-$tpaid;
	$tpaid-=$pamt;
	$tpaid=($tpaid<0)?0:$tpaid;
	$isdue = isdue($datedue,$fdm,$ldm,$tbalance,$today);	
	$nowdues = ($isdue)? $nowdues+=$tbalance:$nowdues;

 
 ?>


<tr>
	<td>Tuition - 1st Payment</td>
	<td><?php echo $datedue; ?></td>
	<td class="right" ><?php echo number_format($pamt,2); ?></td>
	<td>&nbsp;</td>	
	<td class="right" >	
	<?php 
		echo "<table class='full' >";		
		foreach($tpays[$i] AS $tpay){
			if($tpay['pointer']==1){
				echo "<tr><td class='vc80' >".$tpay['datepaid']."</td><td class='vc80' >".$tpay['orno']."</td>"; 
				echo "<td class='right' >".number_format($tpay['amountpaid'],2).'</td></tr>'; 			
			} /* if */		
		}	/* foreach */
		echo "</table>";
	?>
	</td>
	<td class="right" ><?php echo ($isdue)? number_format($tbalance,2):'0.00'; ?></td>	
	<td class="hd right" ><?php echo number_format($tpaid,2); ?></td>	
	

</tr>

<!------------------ tuits 2 onwards ---------------------------------------------------------------------->

<?php if($paymode_id!=1): ?>	<!-- if not paymode id of 1:yearly -->
<?php for($j=2;$j<$limitperiods;$j++): ?>	<!-- leftperiods -->
<?php 


	$k=$j-2; 
	$datedue = trim($rpaydates[$k]);
	$pamt=pamt($annuity,$discperiod);
	
	if($datedue>$ldm){
		$tbalance = $tpaid;
	} else {
		$tbalance = $pamt-$tpaid;
		$tpaid-=$pamt;		
	}
	
	$tpaid=($tpaid<0)?0:$tpaid;
	$isdue = isdue($datedue,$fdm,$ldm,$tbalance,$today);	
	$nowdues = ($isdue)? $nowdues+=$tbalance:$nowdues;



?>

<tr>
	<td>Tuition - <?php echo getOrdinal($j).' Payment'; ?>
		<?php 
		
		?>
	</td>
	<td><?php echo $datedue; ?></td>
	<td class="right" ><?php echo number_format($pamt,2); ?> </td>	<!-- 3 -->
	<td>&nbsp;</td>
	
	<td class="right" >	
	<?php 
		$tp=0;
		echo "<table class='full' >";		
		foreach($tpays[$i] AS $tpay){
			if($tpay['pointer']==$j){
				echo "<tr><td class='vc80' >".$tpay['datepaid']."</td><td class='vc80' >".$tpay['orno']."</td>";  
				echo "<td class='right' >".number_format($tpay['amountpaid'],2).'</td></tr>'; 			
			} /* if */		
		}	/* foreach */
		echo "</table>";
						
	?>

	</td>
	<td class="right" ><?php echo ($isdue)? number_format($tbalance,2):'0.00'; ?></td>		
	<td class="hd right" ><?php echo number_format($tpaid,2); ?></td>		

</tr>	
<?php endfor; ?>	<!-- leftperiods -->
<?php endif; ?>	<!-- if not paymode id of 1:yearly -->



<!------------------ tuits 2 onwards ---------------------------------------------------------------------->

</table>
</div>	<!-- tuition clear -->


<!---------------------- aux clear ----------------------------------------------------------------------------------------->
<p>&nbsp;</p>

<div class="" style="float:left;width:100%;"  >	<!-- auxes clear -->

<?php if(!empty($auxes[$i])): ?>	<!-- has addons -->


<table class="" >

<tr>
	<th class="vc150" >Addons</th>
	<th class="vc80" >Due Date</th>
	<th class="right vc80" >Amount</th>
	<td class="vc20" >&nbsp;</td>
	<th style="width:220px;" >		
		<div class='vc80' style="float:left;"  >Paid Date</div>  
		<div class='vc80' style="float:left;"  >OR</div>
		<div class='vc50 right' style="float:left;"  >Amount</div>  		
		
	</th>	<!-- 4 -->
	<th class="right" >Due</th>	<!-- 5 -->
	<th class="hd right" ><?php echo number_format($tpaid,2); ?></th>	<!-- 5 -->
</tr>

<?php 
// pr($tpaid);
		
?>


<!------------------ auxes onwards ---------------------------------------------------------------------->

<?php 

	// $aux = ($auxes[$i]);	
// pr($auxes[$i]);
	
foreach($auxes[$i] AS $row):	
	$datedue=$row['datedue']; 
	$pamt = $row['amountdue'];
	$feetype_id = $row['feetype_id'];
	
?>

<tr>
	<td><?php echo $row['feetype']; ?></td>
	<td><?php echo $datedue; ?></td>
	<td class="right" ><?php echo number_format($pamt,2); ?> </td>	<!-- 3 -->
	<td><?php 

	
	?></td>
	<td class="right" >	
	<?php 
		echo "<table class='full' >";		
		foreach($apays[$i] AS $apay){
			if($apay['feetype_id']==$feetype_id){		
				echo "<tr><td class='vc80' >".$apay['datepaid']."</td><td class='vc80' >".$apay['orno']."</td>";  
				echo "<td class='right' >".number_format($apay['amountpaid'],2)."</td></tr>"; 			
			} /* if */						
		}	/* foreach */
		echo "</table>";
		
		$tbalance = $pamt-$tpaid; 
		$tpaid-=$pamt;
		$tpaid=($tpaid<0)?0:$tpaid;
		
		$isdue = isdue($datedue,$fdm,$ldm,$tbalance,$today);			
		$nowdues = ($isdue)? $nowdues+=$tbalance:$nowdues;
		
	?>

	</td>
	<td class="right" ><?php echo ($isdue)? number_format($tbalance,2):'0.00'; ?></td>		
	<td class="hd right" ><?php echo number_format($tpaid,2); ?></td>		
</tr>	


<?php endforeach; ?>	<!-- foreach auxes -->



</table>	
<?php endif; ?>	<!-- has addons -->
</div>	<!-- auxes clear -->

<!---------------------- aux clear ----------------------------------------------------------------------------------------->

<div style="padding-left:60%;" >
<h5>
<?php 
if($tbalance<0){
	$tbalance*=-1;
	echo "Overpayment of P".number_format($tbalance,2).". <br />";
}
?>

Total Current Due: P<?php echo number_format($nowdues,2); ?>

<?php if(round($nowdues)>0): ?>
	<h4>Please pay immediately.</h4>
<?php endif; ?>

</h5>
</div>




<p>&nbsp;</p>
<!--------------------------------------------------------------------------------------------------------------->


<div class="ht100" >&nbsp;</div>

<div class="clear center" style="" >
<table class="" >
	<tr><td class="center" >Computer Generated Report. Signature Not Required.</td></tr>
	<tr><td class="center" >Date & Time Printed: <?php echo $timestamp; ?> </td></tr>
</table>
</div>

<h2><?php 

// pr($data);
// pr($apaid); 

?></h2>

<div class="ht100" >&nbsp;</div>


