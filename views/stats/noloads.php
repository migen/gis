<h5>
	No Loads (<?php echo $count; ?>)

	
</h5>


<table class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>Crs</th><th>Classroom</th><th>Subject</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crsid']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
</tr>
<?php endfor; ?>
</table>