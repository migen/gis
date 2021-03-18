<h5>
	Cxn Union
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>DB</th>
	<th>ID</th>
	<th>Logs</th>
	<th>Edit</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['dbname']; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['log']; ?></td>
	<td>
		<a href="<?php echo URL.'tests/editUnion/'.$rows[$i]['id'].'?dbname='.$rows[$i]['dbname']; ?>" >Edit</a>
	</td>
</tr>
<?php endfor; ?>
</table>
