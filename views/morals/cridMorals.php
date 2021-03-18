<h5>
	Classroom Conduct Awardees

</h5>

<table class="gis-table-bordered " >
<tr><th>#</th><th>Scid</th><th>Student</th><th>Grade</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['grade']; ?></td>
</tr>
<?php endfor; ?>
</table>
