<h5>
	One to Many
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<?php 

pr($rows[0]);
pr($rows[1]);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Majors</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['scid']; ?></td>
		<td><?php echo $rows[$i]['student']; ?></td>
		<td><?php echo $rows[$i]['major']; ?></td>
	</tr>
<?php endfor; ?>
</table>
