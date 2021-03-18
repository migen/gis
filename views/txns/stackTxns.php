<h5>
	Individual Transactions
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<?php 


?>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Year</th>
	<th>Item</th>
	<th>Amount</th>
	<th>DB Name</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['year']; ?></td>
	<td><?php echo $rows[$i]['item']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
	<td><?php echo $rows[$i]['dbname']; ?></td>
	<td>Edit</td>
</tr>
<?php endfor; ?>
</table>
