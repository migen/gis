
<h5>
	URL
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>Name</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>

