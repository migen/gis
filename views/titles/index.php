<?php 

	// pr($data);


?>

<!------------------------------------------------------------------------------------------------------------------------>


<h5>
	Job Titles | 
	<?php 	$controller = 'mis'; $this->shovel('homelinks',$controller); ?>
	
</h5>

<!------------------------------------------------------------------------------------------------------------------------>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow">
	<th>#</th>
	<th>TID</th>
	<th>RID</th>
	<th>PID</th>
	<th>Role</th>
	<th>Job <br /> Titles </th>
	<th>Code</th>
</tr>

<?php for($i=0;$i<$num_titles;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $titles[$i]['title_id']; ?></td>
	<td><?php echo $titles[$i]['role_id']; ?></td>
	<td><?php echo $titles[$i]['privilege_id']; ?></td>
	<td><?php echo $titles[$i]['role']; ?></td>
	<td><?php echo $titles[$i]['name']; ?></td>
	<td><?php echo $titles[$i]['code']; ?></td>
</tr>
<?php endfor; ?>
</table>
