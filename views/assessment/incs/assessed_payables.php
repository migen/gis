<?php 

// pr($tpaid);

$numaddons=0;
foreach($taux AS $row){
	if($row['is_discount']!=1){
		$numaddons++;
	}
}

?>


<div class="divborder" >

<table class="gis-table-bordered table-fx tblpayables" style="font-size:<?php echo $font_assess; ?>;" >
<tr class="" >
	<th class="vc200" >Particulars</th>	<!-- 2 -->
	<th class="vc100" >Schedule</th>	<!-- 3 -->
	<th class="vc120 right" >Amount</th>	<!-- 4 -->
</tr>


<?php 

	$datedue=$dpdue; 	
	$pamt = pamt($dpfee,$discperiod);	

	
?>


<tr class="trpayables" >
	<?php $j=0; ?>
	<td><?php echo 'Tuition - 1st Payment';  ?></td>	<!-- 2 -->	
	<td id="sched<?php echo $i; ?>" ><?php echo $datedue; ?></td>	<!-- 3 -->
	<td class="right" > 
		<span class="u" onclick="copier(<?php echo $pamt; ?>,'amount');" >
			<?php echo number_format($pamt,2); ?></span>
		<?php if($tpaid>0): ?>	
		<br />- <?php echo number_format($tpaid,2); ?>
		<br /><?php $x=round($pamt,2)-round($tpaid,2); echo number_format($x,2); ?> 			
		<?php endif; ?>
	</td>	<!-- 4 -->		
	
</tr>

<?php if($tsum['paymode_id']>1): ?>	<!-- not yearly -->
<?php for($i=0;$i<$numpays;$i++): ?>		<!-- numpayments -->
<?php 
 
 
	$j=$i+1;	
	$datedue=trim($paydates[$i]); 
	$pamt=pamt($annuity,$discperiod); 			
	
?>


<tr>	
	</td>	<!-- 1 -->
	<td><?php echo 'Tuition - '; echo getOrdinal($j+1).' Payment';  ?></td>	<!-- 2 -->
	<td id="sched<?php echo $i; ?>" ><?php echo $datedue;  ?></td>	<!-- 3 -->
	<td class="right" ><span class="u" onclick="copier(<?php echo $pamt; ?>,'amount');" >
		<?php echo number_format($pamt,2); ?></span></td>	<!-- 4 -->
</tr> 
<?php endfor; ?>	<!-- numpayments -->
<?php endif; ?>	<!-- not yearly -->

<?php if($numaddons>0): ?>
	<tr><th colspan="3" >Addons</th></tr>
<?php endif; ?>

<?php 
	$j=$numpays; 
	$arunning=0;		
	
?>

<?php for($i=0;$i<$numtaux;$i++): ?>	<!-- taux -->
<?php if($taux[$i]['is_discount']!=1): ?>	<!-- addons -->

<?php 
	$pfee = $feetype_id = $taux[$i]['feetype_id'];	
	$datedue=$taux[$i]['due'];
	$pamt = $taux[$i]['amount'];				
	// pr($pamt);
	
?>
		
		<tr class="<?php echo ($isdue)? 'bg-pink':NULL; ?>" >		
			<td><?php echo $taux[$i]['feetype'];  ?></td>
			<td></td>	
			<td class="right" >
				<?php $auxamt = $pamt; ?>
				<span class="u" onclick="copier(<?php echo $auxamt; ?>,'amount');" >
					<?php echo number_format($auxamt,2); ?></span></td>	

</tr>

		
<?php endif; ?>	<!-- addons -->
<?php endfor; ?>	<!-- taux -->


<!-- auxes -->
</table>

</div>
