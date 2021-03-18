<?php  
	$get = isset($_GET)? sages($_GET):'';	 

?>

<h5>Sales Report By Product Details
<span class="hd" >-HD-</span>
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."sirs/productSum/$product_id?start=$start&end=$end"; ?>'>Summary</a>
	| <a href="<?php echo URL.'pos'; ?>">Sales</a>
	| <a href="<?php echo URL.'pos/add'; ?>">Add</a>
	| <a href="<?php echo URL.'bills/loadingReport'; ?>">Loading</a>
	| <a href="<?php echo URL.'bills/inventoryReport'; ?>">Inventory</a>


</h5>


<p><table class="gis-table-bordered table-fx"  >
<tr><th>Category</th><td><?php echo $product['prodcategory']; ?></td></tr>

<tr>
<th>Go</th>
<td>
<select onchange="jsredirect('sirs/productEnum/'+this.value+ds+rget);" >
<option >Choose</option>
<?php foreach($products AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$product_id)? 'selected':NULL; ?> ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td>
</tr>

</table></p>


<!----------------------------------------------------------------------------------------------->

<p>
<form method='GET' >

<table class="gis-table-bordered" >
<tr class="headrow" >
<th>Product</th><th>Start</th><th>End</th><th>&nbsp;</th></tr>
<tr>
	<td>
		<select name="product_id" >
			<?php foreach($products AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  <?php echo ($sel['id']==$product_id)? 'selected':NULL; ?> > 
					<?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>
	</td>		

	<td><input class="pdl05 vc120" type='date' name='start' value="<?php echo (isset($_GET['start']))?$_GET['start']:$today; ?>" /></td>		
	<td><input class="pdl05 vc120" type='date' name='end' value="<?php echo (isset($_GET['end']))?$_GET['end']:$today; ?>" /></td>		

	<td><input type='submit' name='filter' value='Filter'></td>		
</tr>
</table>
</form>
</p>

<!----------------------------------------------------------------------------------------------->


<table class="gis-table-bordered table-fx " >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Customer</th>
	<th>Qty</th>
	<th>Amount</th>
</tr>


<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo date('m-d',strtotime($rows[$i]['datetime'])); ?></td>
	<td><?php echo ($rows[$i]['customer_pcid']==0)? 'Guest':$rows[$i]['customer']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
</tr>
<?php endfor; ?>

</table>


<!--------------------------------------------------->

<script>
var gurl = "http://<?php echo GURL; ?>";
var rget = "<?php echo $get; ?>";
var ds  = "<?php echo '/'; ?>";

$(function(){
	hd();

})

</script>



