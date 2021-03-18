<h3>
	Assessment | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>
	

</h3>

<img src="<?php echo URL.'public/images/weblogo_sjam.png'; ?>" width="100" height="100" >

<?php 

// pr($student);
$sch=VCFOLDER;
$incfile=SITE."views/customs/{$sch}/incs/enrollmentFxn_{$sch}.php";
include_once($incfile); 

?>

<table class="gis-table-bordered" >
<tr>
	<th>ID No.</th>
	<th><?php echo $student['studcode']; ?></th>
</tr>
<tr>
	<th>Name</th>
	<th><?php echo $student['studname']; ?></th>
</tr>

<tr>
	<th>Payment Mode</th>
	<th><?php echo ucfirst($student['paymode']); ?></th>
</tr>

</table>

<hr />
<!----------------- tfeedetails ------------------------------->
<table class="gis-table-bordered" >
	<?php $total_tfeedetails=0; ?>
	<?php for($i=0;$i<$tfeedetails_count;$i++): ?>
	<?php 
		$amount=$tfeedetails[$i]['amount']; 
		$total_tfeedetails+=$amount;	
	?>
	
	<tr>
		<td><?php echo $tfeedetails[$i]['feetype_id']; ?></td>
		<td><?php echo $tfeedetails[$i]['feetype']; ?></td>
		<td><?php echo $tfeedetails[$i]['amount']; ?></td>
	<tr>
	<?php endfor; ?>
	<tr>
		<th colspan=2>Total</th>
		<th><?php echo number_format($total_tfeedetails,2); ?></th>
	</tr>

</table>

<hr />
<!----------------- paydues ------------------------------->

<?php

$arp=adjustPayablesSjam($student);
$periodic_adjusted=$arp['periodic_adjusted'];
$periodic_initial=$arp['periodic_initial'];
$student['resfee_paid']=$resfee_paid=getResfee($payments);

?>

<table class="gis-table-bordered" >
<tr>
	<th>Fees Description</th>
	<th>Amount</th>
	<th>Date Due</th>
<tr>
<tr>
	<td>Upon enrollment</td>
	<?php 
		$payable_first=$periodic_adjusted-$resfee_paid;
	?>
	<td class="right" ><?php echo number_format($payable_first,2); ?></td>
	<td><?php echo $paydates[0]; ?></td>
<tr>

<?php for($i=1;$i<$paydates_count;$i++): ?>
<tr>
	<td><?php echo getOrdinalEnrollment($i+1).' Payment'; ?></td>
	<td><?php echo number_format($periodic_adjusted,2); ?></td>
	<td><?php echo $paydates[$i]; ?></td>
</tr>
<?php endfor; ?>

</table>

<div class="clear ht100" ></div>



