<h3>
	No Classroom (<?php echo $count; ?>)
	
	
</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>ID No</th>
	<th>Student</th>
	<th>Prev<br />Lvl-Crid</th>
	<th>Curr<br />Lvl-Crid</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo $rows[$i]['prevlvl'].'-'.$rows[$i]['prevcrid']; ?></td>
	<td><?php echo $rows[$i]['currlvl'].'-'.$rows[$i]['currcrid']; ?></td>
</tr>
<?php endfor; ?>
</table>
