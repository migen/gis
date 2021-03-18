<h5>
	Logs - Class Records Encoding (<?php echo $count; ?>)
</h5>

<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Classroom</th>
	<th>Subject</th>
	<th>Teacher</th>
	<th>Date</th>
	<th>Activity</th>
	<th>Max</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
<td><?php echo $i+1; ?></td>
<td><?php echo $rows[$i]['crid']; ?></td>
<td><?php echo $rows[$i]['classroom']; ?></td>
<td><?php echo $rows[$i]['subject']; ?></td>
<td><?php echo $rows[$i]['teacher']; ?></td>
<td><?php echo $rows[$i]['date']; ?></td>
<td><?php echo $rows[$i]['activity']; ?></td>
<td><?php echo $rows[$i]['max_score']; ?></td>
</tr>

<?php endfor; ?>
</table>