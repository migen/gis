<h3>
	Sections Grouping

</h3>

<table class="table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Grp</th>
	<th>Curr<br />Classroom</th>
	<th>Next<br />Classroom</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['grp']; ?></td>
	<td><?php echo $rows[$i]['curr_classroom'].' - #'.$rows[$i]['curr_lvl']; ?></td>
	<td><?php echo $rows[$i]['next_classroom'].' - #'.$rows[$i]['next_lvl']; ?></td>
</tr>
<?php endfor; ?>
</table>
