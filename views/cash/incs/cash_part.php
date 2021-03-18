<?php // pr($rows[0]); ?>



<h5>CASH</h5>
<table class="gis-table-bordered table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Type</th>
	<th>Denomination</th>
	<th class="right" >Count</th>
	<th class="right" >Amount</th>
</tr>
<?php $numitems=0; ?>
<?php for($i=0;$i<$count;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ($rows[$i]['is_bill']==1)? 'Bills':'Coins'; ?></td>
	<?php 
		$value = $rows[$i]['value']; 
		$numitems+=$row[$value];	
	?>
	<td class="right" ><?php echo $rows[$i]['value']; ?></td>	
	<td><input class="vc80 right pdr05" name="posts[<?php echo $rows[$i]['value']; ?>]" 
		value="<?php echo (isset($row[$value]))? $row[$value]:'0'; ?>"  /></td>
		
	<?php 
		$pk = str_replace('c','.',$value);
		$subtotal = $pk*$row[$value];		
	?>	
	
	<td class="right" ><?php echo number_format($subtotal,2); ?></td>
</tr>
<?php endfor; ?>

<tr><th colspan="3" >Cash on Hand</th>
<td class="right" ><?php echo $numitems; ?></td>
<th class="right" ><?php echo (isset($row['cash']))? number_format($row['cash'],2):0; ?></th></tr>

<tr><th colspan="5" >Sales</th></tr>
<?php $total_sales=0; ?>
<?php foreach($paytypes AS $pay): ?>
	<?php $total_sales+=$$pay['code']; ?>
	<tr><th colspan="3" ><?php echo $pay['name']; ?> Sales</th><td></td><td class="right" >
		<?php echo number_format($$pay['code'],2); ?></td></tr>
<?php endforeach; ?>
<tr><th colspan="3" >Total Sales</th><td></td><th class="right" ><?php echo number_format($total_sales,2); ?></th></tr>

<?php 
	$diff = ($row['cash']-$total_sales); 
	if(round($diff)==0){
		$compare="Balanced";
	} elseif(round($diff)>0){
		$compare="Over";
	} else {
		$compare="Short";	
	}
	
	
	
?>

<tr><th colspan="2" >Compare</th>
<td><?php echo $compare; ?></td>
<td></td>
	<th class="right" ><?php echo number_format($diff,2); ?></th>
</tr>

</table>


<p>
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Submit"  />
	<input type="submit" name="finalize" value="Finalize"  />
</p>
