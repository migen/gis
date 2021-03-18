<h5>Sales Report By Product Summary


	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."sirs/productEnum/$product_id?start=$start&end=$end"; ?>'>Details</a>
	| <a href="<?php echo URL.'pos'; ?>">Sales</a>
	| <a href="<?php echo URL.'pos/add'; ?>">Add</a>
	| <a href="<?php echo URL.'bills/loadingReport'; ?>">Loading</a>
	| <a href="<?php echo URL.'bills/inventoryReport'; ?>">Inventory</a>


</h5>


<table class="gis-table-bordered table-fx"  >
<tr><th>Category</th><td><?php echo $product['prodcategory']; ?></td></tr>
<tr><th>Product</th><td><?php echo $product['product']; ?></td></tr>
<tr><th>Start</th><td><?php echo $start; ?></td></tr>
<tr><th>End</th><td><?php echo $end; ?></td></tr>
<tr><th>Qty</th><td><?php echo $row['sumqty']; ?></td></tr>
<tr><th>Total</th><td><?php echo $row['sumamount']; ?></td></tr>
</table>



<!-- >

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
	<td><?php echo $rows[$i]['customer_pcid']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
</tr>
<?php endfor; ?>

</table>

-->
