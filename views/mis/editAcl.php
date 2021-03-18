<?php 


// pr($data);

?>
<h5>
	<a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL; ?>mis/addAcl'>Add Acl</a>
</h5>

<form method='POST'>
<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th>Module</th>
	<th>Role</th>
</tr>

<?php 
	$i = 1;
	foreach($acl AS $row):
?>
<tr>
	<td><?php echo $i; ?></td>
	
	<td>
		<select type='text' name='acl[<?php echo $i; ?>][module_id]'  >
			<?php	foreach($data['selects']['modules'] as $sel): ?><option <?php echo ($sel['id'] == $row['module_id'])? 'selected' : null; ?> value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>

	<td>
		<select type='text' name='acl[<?php echo $i; ?>][role_id]'  >
			<?php	foreach($data['selects']['roles'] as $sel): ?><option <?php echo ($sel['id'] == $row['role_id'])? 'selected' : null; ?> value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>
	
	<input type='text' name='acl[<?php echo $i; ?>][id]' value="<?php echo $row['id']; ?>" >
	
</tr>
<?php 
	$i++;
	endforeach; 
?>
</table>


<p>
	<input type='submit' name='submit' value='Update' >
	<button><a href="<?php echo URL.'mis/acl/'.MODULE_ID; ?>" class="no-underline black"  >Cancel</a></button>
</p>


</form>