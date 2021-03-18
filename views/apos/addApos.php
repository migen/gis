<h3>
	Register Sale | <?php $this->shovel('homelinks'); ?>
	<?php include_once('apos_links.php'); ?>


<?php 
	
	// $_SESSION['q']="";
	// pr($_SESSION['q']);
?>
	
</h3>

<form method="POST" >
<table class="gis-table-bordered">
<tr><th>Date</th>
<td>
	<input name="pos[date]" value="<?php echo $today; ?>" >
	<span class="b" >Type: </span>
		<select name="pos[type_id]" >
			<?php foreach($types AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select>		
</td></tr>
<tr><th>Total</th><td><input name="pos[total]" id="total" value="0" ></td></tr>
</table>

<?php $numrows=(isset($_POST['numrows']))? $_POST['numrows']:1; ?>
<br />
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Product</th>
	<th>Cost</th>
	<th>Qty</th>
	<th>Price</th>
	<th>Amount</th>
</tr>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select name="positems[<?php echo $i; ?>][product_id]" onchange="productSelected(<?php echo $i; ?>,this.value);" >
			<option value=0 >Choose One</option>
			<?php foreach($products AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo "#",$sel['id']."-".$sel['name']." C:".$sel['cost']." P:".$sel['price']; ?></option>
			<?php endforeach; ?>		
		</select>
	</td>
	<td><input name="positems[<?php echo $i; ?>][cost]" class="vc80"  ></td>
	<td><input onchange="qtyChanged(<?php echo $i; ?>,this.value);" name="positems[<?php echo $i; ?>][qty]" value=1 type="number" class="vc50"  ></td>
	<td><input name="positems[<?php echo $i; ?>][price]" class="vc80"  ></td>
	<td><input name="positems[<?php echo $i; ?>][amount]" class="vc80 subtotal"  ></td>
</tr>
<?php endfor; ?>

</table>

<br /><input type="submit" name="submit" value="Submit" >

</form>


<br /><?php $this->shovel('numrows'); ?>



<script>

var gurl="http://<?php echo GURL; ?>"



function productSelected(i,prid){
	var vurl = gurl+"/ajax/xapos.php";	
	var task = "getProductDetails";
	var pdata="task="+task+"&prid="+prid;
	
	$.ajax({
		url: vurl,dataType: "json",type: "POST",async: true,
		data: pdata,			
		success: function(s) { 
			$('input[name="positems['+i+'][cost]"]').val(s.cost);
			$('input[name="positems['+i+'][price]"]').val(s.price);
			$('input[name="positems['+i+'][amount]"]').val(s.price);			

		}		  
    });				
	
}	/* fxn */

function qtyChanged(i,qty){
	var price=$('input[name="positems['+i+'][price]"]').val();
	var amount=price*qty;
	$('input[name="positems['+i+'][amount]"]').val(amount);				
	/* 2 */
	billTotal();
}	/* fxn */



function billTotal(){
	var total=0;
	$.each($('.subtotal'),function(){
		total+=parseFloat($(this).val());
	})
	$("#total").val(total);
	
}	/* fxn */










</script>
