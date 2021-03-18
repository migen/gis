

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>ID</th>
	<th>Name</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</table>
</form>
