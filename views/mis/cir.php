<h5>
	MIS CIR (<?php echo $count; ?>)
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>ID</th>
<th>Name</th>
<th>View<br />Cridcavs</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'dupes/cridcavs/'.$rows[$i]['id']; ?>" >View</a></td>
</tr>
<?php endfor; ?>

</table>
