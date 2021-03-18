<h5>
Actions

</h5>

<table class="gis-table-bordered table-altrow" >

<tr>
<th>#</th>
<th>Code</th>
<th>Name</th>
<th>ID</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
</tr>
<?php endfor; ?>

</table>