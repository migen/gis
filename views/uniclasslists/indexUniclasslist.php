<h5>
	Classlist <?php echo $cr['classroom']; ?>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Student</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1l ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</table>
