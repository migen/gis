<h5>
	Moved Stocks Itemized
	| <a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
		
</h5>

<table class="gis-table-bordered" >
<tr>
	<th>Date</th>
	<td><?php echo $_GET['start']; ?> -- <?php echo $_GET['end']; ?></td>
</tr>
<tr>
	<th>Product</th>
	<td><?php echo $rows[0]['product']; ?></td>
	
</tr>

</table>

<table class="gis-table-bordered table-fx"  >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Order Qty</th>
	<th>Recvd Qty</th>
	<th>SMV#</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['date']; ?></td>
		<td><?php echo $rows[$i]['roqty']; ?></td>
		<td><?php echo $rows[$i]['rxqty']; ?></td>
		<td>
			<a href="<?php echo URL.'logistics/view/'.$rows[$i]['smv_id']; ?>" ><?php echo $rows[$i]['smv_id']; ?></a>
		| <a href="<?php echo URL.'logistics/edit/'.$rows[$i]['smv_id']; ?>" >Edit</a></td>
	</tr>
<?php endfor; ?>


</table>

