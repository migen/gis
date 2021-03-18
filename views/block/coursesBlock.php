<h5>
	Block Courses (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>

</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Subject</th>
	<th>Course</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo '#'.$rows[$i]['sub'].'-'.$rows[$i]['subject']; ?></td>
	<td><?php echo '#'.$rows[$i]['crs'].'-'.$rows[$i]['course']; ?></td>
</tr>
<?php endfor; ?>
</table>

