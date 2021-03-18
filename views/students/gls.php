<h5>
Students
</h5>

<!-------------------------------------------------------------------->


<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>#</th>
	<th>Login</th>
	<th>Name</th>
</tr>

<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['account']; ?></td>
	<td><?php echo $students[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>