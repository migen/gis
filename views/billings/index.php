<h5>
	Billings
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'billings/add'; ?>">Add</a>
	


</h5>

<table class="gis-table-bordered table-fx" >
<tr>
<th>#</th>
<th>Date</th>
<th>Type</th>
<th>Amount</th>
<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['jobtype']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
	<td>
		<a href="<?php echo URL.'billings/view/'.$rows[$i]['id']; ?>" >View</a>
		| <a href="<?php echo URL.'billings/edit/'.$rows[$i]['id']; ?>" >Edit</a>
	</td>
</tr>
<?php endfor; ?>
</table>
