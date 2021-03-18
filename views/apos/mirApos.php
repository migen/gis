<h3>
	<?php echo ($joint_table)? "Joint Table":"Separate Tables"; ?>
	- Master Inventory Report (MIR) | <?php $this->shovel('homelinks'); ?>
	<?php include_once('apos_links.php'); ?>

	
</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Product</th>
	<th>Cost</th>
	<th>Price</th>
	<th>End<br />Invty</th>
	<th>Pur</th>
	<th>Total</th>
	<th>Sold</th>
	<th>Revenues</th>
	<th>CGS</th>
	<th>Gross<br />Profit</th>
	<th>Curr<br />End<br />Invty</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$product=$rows[$i]['product'];
	$cost=$rows[$i]['cost'];
	$price=$rows[$i]['price'];
	$ending_inventory=$rows[$i]['ending_inventory'];
	$qty_sold=$rows[$i]['qty_sold'];
	$qty_purchased=$buyrows[$i]['qty_purchased'];
	$total_inventory=$ending_inventory+$qty_purchased;
	$revenues=$qty_sold*$price;
	$cgs=$qty_sold*$cost;
	$gross_profit=$revenues-$cgs;
	$current_ending_inventory=$total_inventory-$qty_sold;
	
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $product; ?></td>
	<td><?php echo $cost; ?></td>
	<td><?php echo $price; ?></td>
	<td><?php echo $ending_inventory; ?></td>
	<td><?php echo $qty_purchased; ?></td>
	<td><?php echo $total_inventory; ?></td>
	<td><?php echo $qty_sold; ?></td>
	<td><?php echo $revenues; ?></td>
	<td><?php echo $cgs; ?></td>
	<td><?php echo $gross_profit; ?></td>
	<td><?php echo $current_ending_inventory; ?></td>
	

</tr>
<?php endfor; ?>
</table>
