

<!-- arp below -->
<?php $total_payables=$total-$total_discount; ?>
<?php for($i=0;$i<$duedates_count;$i++): ?>
<?php // $total_payables+=$arp['adjusted_periodic']; ?>
<?php $row_amount=$arp['adjusted_periodic']; ?>
<?php $ptr=$i+1; ?>
<?php if($i==0){ $row_amount-=$resfee_paid; } ?>
<?php 
	$payable=array(
		'amount'=>$row_amount,
		'ptr'=>$ptr,
		'feetype_id'=>1,
	);	
	/* payableBalanceRow */	
	$pbr=updatePayableBalance($db,$payable,$payments); 
?>

<tr>
	<td><?php echo $i+1; ?>
		<?php 
			// pr($arp);
			// pr($row_amount); 
		?>
	</td>
	<td><?php echo 'Tuition Fee - '.getOrdinalEnrollment($i+1).' Payment'; ?></td>
	<td><?php echo $ptr; ?></td>
	<td class="right" ><?php echo number_format($row_amount,2); ?>
		<input type="hidden" id="amount-<?php echo $i; ?>-1" value="<?php echo $pbr['balance']; ?>" >
		<input type="hidden" id="feetype-<?php echo $i; ?>-1" value="Tuition Fee" >
		<input type="hidden" id="feetype_id-<?php echo $i; ?>-1" value="1" >
		<input type="hidden" id="ptr-<?php echo $i; ?>-1" value="<?php echo $ptr; ?>" />	
	</td>
	<td class="right" ><?php echo number_format($pbr['paid'],2); ?></td>
	<td class="right" ><?php echo number_format($pbr['balance'],2); ?></td>
	<td><?php echo $tfee_duedates_arr[$i]; ?></td>
	<td></td>
	<td></td>
	<td><button onclick="pasteAmount(<?php echo $i; ?>,1);" >Copy</button></td>
	
</tr>
<?php endfor; ?>	<!-- duedates_count -->
