<h5>Terminals

</h5>



<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
<th>ID</th>
<th>Group</th>
<th>Code</th>
<th>Name</th>
<th>IP</th>
<th>Location</th>
<th>&nbsp;</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $terminals[$i]['id']; ?></td>
	<td><?php echo $terminals[$i]['group']; ?></td>
	<td><?php echo $terminals[$i]['code']; ?></td>
	<td><?php echo $terminals[$i]['name']; ?></td>
	<td><?php echo $terminals[$i]['ip']; ?></td>
	<td><?php echo $terminals[$i]['location']; ?></td>
	<td><a href='<?php echo URL."mis/editTerminal/".$terminals[$i]['id']; ?>' >Edit</a></td>
</tr>
<?php endfor; ?>
</table>