
<h5>Test CAV Matrix</h5>

<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
<th>#</th>
<th>Student</th>
	<?php foreach($teachers AS $row): ?>
		<th><span class="vertical" ><?php echo $row['label']; ?></span></th>
	<?php endforeach; ?>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<?php $rows=$grades[$i]; ?>
	<?php foreach($rows AS $row): ?>
		<td><?php echo number_format($row['ave'],2); ?></td>
	<?php endforeach; ?>
</tr>
<?php endfor; ?>	<!-- count -->



</table>
