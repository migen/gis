<h5>
	Sales Report
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'pos'; ?>">Sales</a>
	| <a href="<?php echo URL.'pos/add'; ?>">Add</a>
	| <a href="<?php echo URL.'bills/loadingReport'; ?>">Loading</a>
	| <a href="<?php echo URL.'bills/inventoryReport'; ?>">Inventory</a>

<?php 

// echo "<p><a href='".URL."bills'>POS</a>";  	
// echo " &nbsp; | &nbsp; <a href='".URL."bills/add'>New</a></p>";  	

?>




</h5>


<!------------------------------------------------------------------------------------------------------->


<p><table class="gis-table-bordered" >
<form method="GET" >
<tr class="headrow" >
	<th>Date From</th>
	<th>Date To</th>
</tr>
<tr>
	<td><input class="vc150 pdl05 " type="date" name="from" value="<?php echo (isset($_GET['from']))? $_GET['from'] : $today; ?>" /></td>
	<td><input class="vc150 pdl05 " type="date" name="to" value="<?php echo (isset($_GET['to']))? $_GET['to'] : $today; ?>" /></td>
	<td><input input type="submit" name="search" value="Search"   /></td>
</tr>
</form>
</table></p>

<!------------------------------------------------------------------------------------------------------->


<h5>Total: P<?php echo number_format($total,2); ?> </h5>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
<th>#</th>
<th class="vc300" >Category</th>
<th>Subtotal</th>
</tr>

<?php $i=1; ?>
<?php foreach($categories AS $row): ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row['prodcategory']; ?></td>
	<td class="right"><?php echo number_format($row['subtotal'],2); ?></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>
