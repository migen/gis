<h5>
	Emps
</h5>

<?php 
	pr($rows[0]);
?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>UCID</th>
	<th>PCID</th>
	<th>Code</th>
	<th>Name</th>
	<th>Role</th>
	<th>Priv</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['parent_id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['role_id']; ?></td>
	<td><?php echo $rows[$i]['privilege_id']; ?></td>
</tr>
<?php endfor; ?>

</table>
