<h5>
	<?php echo $this->shovel('breadlinks'); ?>
	View User
</h5>

<?php 
	// pr($data);
	$user = $data['user'];
	$groups = $data['groups'];
	echo 'Groups:';
	pr($groups);

?>

<table class='gis-table-bordered table-fx'>

<tr>
	<th>Code</th>
	<td><?php echo $user['code']; ?></td>
</tr>


<tr>
	<th>Role</th>
	<td><?php echo $user['role']; ?></td>
</tr>


</table>