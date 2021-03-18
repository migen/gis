<h5>Add User</h5>



<form method='post'>

<table class='gis-table-bordered table-fx'>
<tr>
	<td>Parent</td>
	<td><select class='full' id='parent<?php echo $i; ?>' name='parent' >
			<?php	foreach($data['selectsContacts'] as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['code']; ?></option><?php	endforeach; ?>
	</select></td>	
</tr>

<tr>
	<td>Code</td>
	<td>
		<input type='text' name='code' >
	</td>	
</tr>

<tr>
	<td>Pass</td>
	<td>
		<input type='text' name='pass' >
	</td>	
</tr>

</table>

<input type='submit' name='submit' value='Add'>

</form>