<h5>
	Bills (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."bills/add"; ?>'>Cashier</a>			

</h5>

<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Customer</th>
	<th>Amount</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['customer']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
</tr>
<?php endfor; ?>
</table>