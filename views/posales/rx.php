<h5>
	Returns / Exchanges

</h5>


<form method="POST" >
<table class="gis-table-bordered" >

<tr>
<th>O</th>
<th>#</th>
<th>Barcode</th>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Amount</th>
<th>Find</th>
<th>Combo</th>
<th>IO</th>
<th>Cost</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 3; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr id="trow<?php echo $i; ?>" rel="<?php echo isset($row['id'])? $row['id']:''; ?>">

	<td><u onclick="deltrow(<?php echo $i; ?>);" class='blue' rel="<?php echo isset($row['id'])? $row['id']:''; ?>"></u></td>
	<td><?php echo isset($row['id'])? $row['id']:$i+1; ?></td>

	<td class="vc100" >
		<input type="text" class="full pdl05 bc" tabindex="<?php echo $i+1; ?>" id="barcode<?php echo $i; ?>" 
			  onchange="xgetProductByBarcode(<?php echo $i; ?>);return false;" accesskey="b" />		
	</td>

	<td id="tdproduct<?php echo $i; ?>" ><input class="full" id="prod<?php echo $i; ?>" readonly /></td>	
	
	<td class="vc50" ><input class="right full pdr05" name='positems[<?php echo $i; ?>][price]' 
		value="<?php echo isset($row['price'])? $row['price']:null; ?>" readonly /></td>
		
	<td class="vc50" ><input id="<?php echo $i; ?>" class="right full pdr05" type="number" min=0 
		name='positems[<?php echo $i; ?>][qty]' onchange="amt(this.id);return false;"  
		value="<?php echo isset($row['qty'])? $row['qty']:0; ?>" /></td>

	<td class="vc50" ><input class="subtotal full right pdr05" type="text" name='positems[<?php echo $i; ?>][amount]' value="<?php $amt = isset($row['amount'])? $row['amount']:0; echo number_format($amt,2); ?>" readonly /></td>
		
	<td class="vc50" >
		<input class="full pdl05" id="product<?php echo $i; ?>"  />		
		<input type="submit" name="auto" value="Filter" onclick="xposProductsByPart(<?php echo $i; ?>);return false;" />
	</td>

	<td class="vc20" >
		<input type="text" class="full right" name="positems[<?php echo $i; ?>][combo]" 
			value="<?php echo isset($row['combo'])? $row['combo']:null; ?>" readonly />		
		<input class="full" name="positems[<?php echo $i; ?>][product_id]" readonly />					
	</td>
	
	<td class="vc20" >
		<input type="text" class="full pdl05" name="positems[<?php echo $i; ?>][io]" value="0" readonly />				
	</td>	
	
	<td class="vc50" ><input class="right full pdr05" name='positems[<?php echo $i; ?>][cost]' 
		value="<?php echo isset($row['cost'])? $row['cost']:null; ?>" readonly /></td>
	
</tr>

<?php endfor; ?>

</table>

<p><input onclick="return confirm('Sure?');" type='submit' name='submit' value='Submit' /></p>
</form>


</form>





<p><?php $this->shovel('numrows'); ?></p>

