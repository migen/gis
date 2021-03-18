<?php if($has_previous_balance): ?>
<?php 
	$j=$i+1;
	
	$payable=array(
		'amount'=>$student['previous_balance'],
		'ptr'=>1,
		'feetype_id'=>3,
	);	
	// $pbr=updatePayableBalance($db,$payable,$payments); 	

?>		


	<tr>
		<td><?php echo $h; ?></td>
		<td><?php echo 'PREVIOUS BALANCE'; ?></td>
		<td>1</td>
		<td class="right" ><?php echo number_format($student['previous_balance'],2); ?></td>
		<td class="right" ><?php echo number_format($pbr['paid'],2); ?></td>
		<td class="right" >
			<?php 
				echo number_format($student['remaining_previous_balance'],2); 
			?>
		</td>
		<td><?php echo ($pbr['balance']>0)? 'Immediately':NULL; ?></td>
		<td><a href="<?php echo URL.'students/balances/'.$row['scid']; ?>" >Balances</a></td>		
		<td>
			<input type="hidden" id="amount-<?php echo $j; ?>-1" value="<?php echo number_format($pbr['balance'],2); ?>" />	
			<input type="hidden" id="feetype_id-<?php echo $j; ?>-1" value="<?php echo $payable['feetype_id']; ?>" />	
			<input type="hidden" id="ptr-<?php echo $j; ?>-1" value="<?php echo $payable['ptr']; ?>" />			
		</td>
		<td>
			<button onclick="pasteAmount(<?php echo $j; ?>,1);" >Copy</button>
		</td>		
	</tr>
	<?php $h++; // rowIndex ?>	
<?php endif; ?>	<!-- has_prevbal -->
