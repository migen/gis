<?php // pr($rows[0]); 

// pr($data);
// pr($rows);
// pr($row);
// pr($rows[1]);
// pr($cheques[0]);

?>



<h5>CASH
(<?php echo ($row['is_finalized']==1)? 'Locked':'Open'; ?>)

</h5>
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
<?php $rv=$rows[$i]['realvalue']; ?>
<?php 
	$rv=$rows[$i]['realvalue']; 
	$value = $rows[$i]['value']; 
	$numitems+=$row[$value];	
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ($rows[$i]['is_bill']==1)? 'Bills':'Coins'; ?></td>
	<?php 
	?>
	<td class="right" ><?php echo $rows[$i]['value']; ?></td>	
	<td><input class="vc80 right pdr05" name="posts[<?php echo $value; ?>]" id="<?php echo $rv; ?>"
		value="<?php echo (isset($row[$value]))? $row[$value]:'0'; ?>" tabIndex="1"
			onchange="getSubtotal(<?php echo $i; ?>,this.value,this.id);" /></td>
		
	<?php 
		$pk = str_replace('c','.',$value);
		$subtotal = $pk*$row[$value];		
	?>	
	

	<td>
		<input class="subtotal right vc80" id="subtotal<?php echo $i; ?>" 
		value="<?php echo number_format($subtotal,2); ?>" readonly /></td>

	
</tr>
<?php endfor; ?>

<tr><th colspan="3" >Cash on Hand</th>
<td class="right" ><?php echo $numitems; ?></td>
<th class="right" id="total" ><?php echo (isset($row['cash']))? number_format($row['cash'],2):0; ?></th></tr>

<tr><th colspan="3" >Cash Sales</th><td></td><th class="right" ><?php echo number_format($cash_sales,2); ?></th></tr>
<tr><th colspan="3" >Cheque Sales</th><td></td><th class="right" ><?php echo number_format($cheque_sales,2); ?></th></tr>
<tr><th colspan="3" >Total Sales</th><td></td><th class="right" ><?php echo number_format($total_sales,2); ?></th></tr>

<?php 
	$diff = ($row['cash']-$cash_sales); 
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

<br />
<p>
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Submit"  />
	<?php if($row['is_finalized']!=1): ?>
		<input id="btn" type="submit" value="Finalize" 
			onclick="finalizeCashTally(<?php echo $row['id']; ?>);" />	
	<?php endif; ?>
	
	<?php if(($row['is_finalized']==1) && ($_SESSION['user']['privilege_id']==0)): ?>
		<input id="btn" type="submit" value="Unlock" 
			onclick="openCashTally(<?php echo $row['id']; ?>);" />	
	<?php endif; ?>
	
</p>



<?php if($num_cheques>0): ?>
<table class="gis-table-bordered" >
<tr><th>#</th><th>Bank</th><th>Amount</th><th>Reference</th><th class="screen" ></th></tr>
<?php for($i=0;$i<$num_cheques;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $cheques[$i]['bank']; ?></td>
	<td class="right" ><?php echo number_format($cheques[$i]['tenderetc'],2); ?></td>
	<td><?php echo $cheques[$i]['etcno']; ?></td>
	<td class="screen" ><a href="<?php echo URL.'cheques/posedit/'.$cheques[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
<?php else: ?>
<h4>No cheques.</h4>
<?php endif; ?>











<script>


function finalizeCashTally(cid){
	var vurl = gurl+'/ajax/xcash.php';		
	var task = "finalizeCashTally";			
	$.post(vurl,{task:task,cid:cid},function(){});	
	$('#btn'+i).hide();	
	return true;
}	/* fxn */


function openCashTally(cid){
	var vurl = gurl+'/ajax/xcash.php';		
	var task = "openCashTally";			
	$.post(vurl,{task:task,cid:cid},function(){});	
	$('#btn'+i).hide();	
	return true;
}	/* fxn */


function getSubtotal(i,count,rv){
	var x = parseInt(count)*parseFloat(rv);
	$('#subtotal'+i).val(x);


}

function getTotal(){

}

</script>
