
<h5>
	Classroom Teachers 
	
</h5>

<table class="gis-table-bordered" >
<tr>
<th>#</th>
<th>Crs</th>
<th>Type</th>
<th>Subject</th>
<th>Teacher</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crs']; ?></td>
	<td><?php echo $rows[$i]['ctype']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
</tr>
<?php endfor; ?>
</table>



