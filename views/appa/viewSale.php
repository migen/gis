<h5>
	View Sale | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'appa'; ?>" >Appa POS</a>
	
</h5>

<?php 

// pr($data);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>Date | Time</th>
	<td><?php echo $pos['date'].' '.$pos['time']; ?></td>
</tr>
<tr>
	<th>Employee</th>
	<td><?php echo $pos['employee']; ?></td>
</tr>
<tr>
	<th>Total</th>
	<td><?php echo $pos['total']; ?></td>
</tr>


</table>

<br />

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Product</th>
	<th class="right" >Price</th>
	<th class="center" >Qty</th>
	<th class="right" >Subtotal</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $items[$i]['product']; ?></td>
	<td class="right" ><?php echo number_format($items[$i]['price'],2); ?></td>
	<td class="center" ><?php echo $items[$i]['qty']; ?></td>
	<td class="right" ><?php echo number_format($items[$i]['subtotal'],2); ?></td>
</tr>
<?php endfor; ?>
</table>
