<?php 

pr($data);

?>

<h5>
	Scores New
	<?php echo $course['course']; ?>
	
</h5>

<table class="gis-table-bordered" >
<thead>
<tr>
	<th>#</th>
	<th>Student</th>
	<?php foreach($activities AS $row): ?>
		<th><?php echo $row['activity']; ?></th>
	<?php endforeach; ?>
</tr>
</thead>
<tbody>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>

</tbody>
</table>


