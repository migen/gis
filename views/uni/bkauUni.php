<h5>
	Books Authors (Many to Many RDBMS) - reference for prerequisites 
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Book</th>
	<th>Author</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['book']; ?></td>
	<td><?php echo $rows[$i]['author']; ?></td>
</tr>
<?php endfor; ?>
</table>
