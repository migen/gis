<?php 


?>

<h5>
	<span class="u" onclick="tracehd();" >Cancel</span> POS
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'opos'; ?>" >POS</a>
<?php if($_SESSION['user']['privilege_id']==0): ?>
	<span class="" > | <a href="<?php echo URL.'pos/edit/'.$pos['id']; ?>" >Edit</a></span>
<?php endif; ?>	


</h5>

<form method="POST" >


<p><table class="gis-table-bordered table-fx <?php echo $tfsize; ?>" >

	<tr class="hd" ><th>CCID</th><td><input name="pos[ccid]" value="<?php echo $pos['ccid']; ?>" ></td></tr>
	<tr class="hd" ><th>ECID</th><td><input name="pos[ecid]" value="<?php echo $pos['ecid']; ?>" ></td></tr>
	
	<tr><th>POS ID</th><td><?php echo $pos['id']; ?></td></tr>
	<tr><th>OR #</th><td><input name="pos[orno]" value="<?php echo $pos['orno']; ?>" ></td></tr>
	<tr><th>Terminal</th><td><input name="pos[terminal]" value="<?php echo $pos['terminal']; ?>" ></td></tr>
	<tr><th>Is Credit</th><td><input name="pos[is_credit]" value="<?php echo $pos['is_credit']; ?>" ></td></tr>
	
	<tr><th>Time</th><td><input name="pos[datetime]" value="<?php echo $_SESSION['datetime']; ?>" ></td></tr>
	<tr><th>ID Number</th><td><?php echo $pos['customer_code']; ?></td></tr>
	<tr><th>Customer</th><td><?php echo $pos['customer']; ?></td></tr>
	<tr><th>Classroom</th><td><?php echo $pos['classroom']; ?></td></tr>
	<tr><th>Cashier</th><td><?php echo $pos['employee']; ?></td></tr>	

</table></p>


<table class="gis-table-bordered table-fx <?php echo $tfsize; ?>" >
<tr>
<th>IO</th>
<th>Prid</th>
<th>Price</th>
<th>Qty</th>
<th>Combo</th>
<th class="vc200" >Item</th>
<th class="vc60" >Subtotal</th>
</tr>
<?php 
	$numitems=0; 
	$is_rx=false;
	$i=0;
?>
<?php foreach($positems AS $row): ?>
<?php $numitems+=$row['qty']; ?>
<?php if($row['qty']<0){ $is_rx=true; } ?>
<tr>
	<td><input class="vc30" name="positems[<?php echo $i; ?>][io]" 
		value="1" readonly /></td>
	<td><input class="vc50" name="positems[<?php echo $i; ?>][product_id]" 
		value="<?php echo $row['product_id']; ?>" readonly /></td>
	<td><input class="vc50" name="positems[<?php echo $i; ?>][price]" 
		value="<?php echo $row['price']; ?>" readonly /></td>		
	<td><input class="vc50" type="number" name="positems[<?php echo $i; ?>][qty]" 
		value="<?php echo ($row['qty']*-1); ?>" readonly /></td>
	<td><input class="vc50" name="positems[<?php echo $i; ?>][combo]" 
		value="<?php echo $row['combo']; ?>" readonly /></td>		
	<td><?php echo $row['product']; ?></td>
	<td><input class="vc80" name="positems[<?php echo $i; ?>][amount]" 
		value="<?php echo ($row['amount']*-1); ?>" readonly /></td>
</tr>

<?php 
	$i++;
	endforeach; 
?>
	<tr><td colspan="6" >Item(s) Sold</td><td><?php echo $numitems; ?></td></tr>	
	<tr><td colspan="6" >Discount</td><td><input name="pos[discount]" class=""
		value="<?php echo ($pos['discount']*-1); ?>" readonly /></td></tr>
	<tr><td colspan="6" >Total</td><td><input name="pos[total]" class=""
		value="<?php echo ($pos['total']*-1); ?>" readonly /></td></tr>
	<tr><td colspan="6" >Tender Cash</td><td><input name="pos[tendercs]" class=""
		value="<?php echo ($pos['tendercs']*-1); ?>" readonly /></td></tr>		
	<tr><td colspan="6" >Bank</td><td><input name="pos[bank_id]" class=""
		value="<?php echo $pos['bank_id']; ?>" readonly /></td></tr>						
	<tr><td colspan="6" >Etc No.</td><td><input name="pos[etcno]" class=""
		value="<?php echo $pos['etcno']; ?>" readonly /></td></tr>						
	<tr><td colspan="6" >Tender Etc</td><td><input name="pos[tenderetc]" class=""
		value="<?php echo ($pos['tenderetc']*-1); ?>" readonly /></td></tr>				

</table>

<p>
<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');"  />
</p>


</form>

