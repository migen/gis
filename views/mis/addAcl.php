<h5>
	<?php 	$controller = 'mis'; $this->shovel('homelinks',$controller); ?>
	| <a href='<?php echo URL; ?>mis/acl'>Acl</a>
</h5>

<!------------------------------------------------------------------------------------------------------------------------------>


<?php 

	// pr($data);

?>


<!------------------------------------------------------------------------------------------------------------------------------>



<form method='post' >

<br />

<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>&nbsp;</th>
	<th>Module</th>
	<th>Role</th>
</tr>

<tbody id='tableCriteria'>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>

	<td>
		<select type='text' name='acls[<?php echo $i; ?>][module_id]'  >
			<?php	foreach($data['selects']['modules'] as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>
	
	<td>
		<select type='text' name='acls[<?php echo $i; ?>][role_id]'  >
			<?php	foreach($data['selects']['roles'] as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>
	
</tr>



<?php endfor; ?>			
</tbody></table>

<p>
	<input type='submit' name='submit' value='Submit'> &nbsp; 
	<button><a href="<?php echo URL.'mis/acl/'.$level; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> 


<!-- form_numrows-->
<?php $this->shovel('numrows'); ?>
