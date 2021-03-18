<?php 

// pr($data);

?>
<h5>
	<a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL; ?>mis/addAcl'>Add Acl</a>
</h5>

<!------------------------------------------------------------------------------------------------------------------------------>

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th>Module</th>
	<th>Role</th>
	<th>Actions</th>
</tr>

<?php 
	$i = 1;
	foreach($data['acl'] AS $row):
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row['module']; ?></td>
	<td><?php echo $row['role']; ?></td>
	<td>
		<a href="<?php echo URL.'admins/editAcl/'.$row['id']; ?>"> Edit</a>
		<?php if(($_SESSION['user']['role_id'] == 5) 
				&& ($_SESSION['user']['privilege_id'] == 3)): ?>
		|| <a href="<?php echo URL.'admins/deleteAcl/'.$row['id']; ?>" onclick="return confirm('Warning! You sure?');" > Delete</a>		
		<?php endif; ?>
	</td>
</tr>
<?php 
	$i++;
	endforeach; 
?>
</table>