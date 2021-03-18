<?php 
$url=SITE.'views/customs/'.VCFOLDER.'/customs.php';
include_once($url);
$preapp=($pos_order=='append')? 1:0;

// pr($data);
	
?>
<script type='text/javascript' src="<?php echo URL; ?>views/js/pos.js"></script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


<?php 
	$numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; 
	
	
?>




<h5>
	Credit POS Checkout
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."opos"; ?>' >POS</a>		
	| <span class="u" onclick="additem();" >Additem</span>
	
</h5>

<?php 
include_once(SITE.'views/opos/incs/find_orno.php'); 
?>

<div style="width:70%;float:left;" >		<!-- pos screen -->

<form id="posform" method="POST" >

<?php 
	include_once(SITE.'views/cpos/incs/pos_head.php');

?>


<div style="width:30px;height:60px;float:left;" >&nbsp;</div>
<div class="clear" >&nbsp;</div>


<!-- positems below -->
<div style="width:52%;float:left" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Prid</th><th>Product</th><th>Cost</th><th>Price</th><th>Qty</th><th>Amount</th><th>Date Credited</th></tr>
<tbody id="posrows" >
<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['amount']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input name="positems[<?php echo $i; ?>][product_id]" class="vc50" 
			value="<?php echo $rows[$i]['product_id']; ?>" >
		<input name="positems[<?php echo $i; ?>][combo]" type="hidden" 
					value="<?php echo $rows[$i]['combo']; ?>" >					
	</td>
	<td><input value="<?php echo $rows[$i]['product']; ?>" ></td>
	<td><input name="positems[<?php echo $i; ?>][cost]" class="vc80" value="<?php echo $rows[$i]['cost']; ?>" ></td>
	<td><input name="positems[<?php echo $i; ?>][price]" class="vc80" value="<?php echo $rows[$i]['price']; ?>" ></td>
	<td><input name="positems[<?php echo $i; ?>][qty]" class="vc50" value="<?php echo $rows[$i]['qty']; ?>" ></td>
	<td><input name="positems[<?php echo $i; ?>][amount]" class="subtotal vc80" value="<?php echo $rows[$i]['amount']; ?>" ></td>
	<td><input name="positems[<?php echo $i; ?>][datecr]" class="vc100" value="<?php echo $rows[$i]['datecr']; ?>" ></td>
</tr>
<?php endfor; ?>
</tbody>
</table>
</div>

<div class="clear"><br />
	<input type="submit" name="submit" value="Pay" onclick="return confirm('Sure?');" />
	<input type="submit" name="cancel" value="Cancel"  />
</div>

</form>




</div> <!-- pos screen -->






<script>
var total="<?php echo $total; ?>";

$(function(){
	// var x = total.toFixed(2);
	// $("#total").val(total.toFixed(2));
	$("#total").val(total);
	$("#tender").val(total);
	
	
})	/* fxn */


</script>