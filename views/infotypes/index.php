<h5>Info Types

</h5>

<table class="gis-table-bordered table-fx" >

<tr><th>#</th><th>ID</th><th>Type</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>
