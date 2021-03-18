<h5>
	<?php echo $this->shovel('breadlinks'); ?>
	Edit User
</h5>

<?php 
	// pr($data);
	
		
	$user = $data['user'];

?>


<form method='post'>
<table class='gis-table-bordered table-fx'>
<tr>
	<th class='vc100'>User</th>
	<td class='vc200'><?php echo $user['code']; ?></td>
</tr>

<tr>
	<th>Role</th>
	<td>
		<select class='full' name="data[User][role_id]" >
				<option value='0'>Non User</option>
			<?php foreach($data['selectsRoles'] AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id'] == $user['role_id'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option>			
			<?php endforeach; ?>
		</select>
	</td>
</tr>

<tr>
	<td>Pass</td>
	<td><?php if($user['has_pass']): ?>
			<a href="<?php echo URL.'users/changePass/'.$user['id']; ?>" >Change Pass</a>		
		<?php else: ?>
			<a href="<?php echo URL.'users/newPass/'.$user['id']; ?>" >Create Pass</a>
		<?php endif; ?>
	</td>
</tr>


<input type='hidden' name='data[User][contact_id]' value="<?php echo $user['id']; ?>"></td>


<tr>
	<td colspan=2>
		<input type='submit' name='submit' value='Update'>
		<a class='button' href="<?php echo URL.'users'; ?>">Cancel</a>	
	</td>
</tr>

</table>


</form>
