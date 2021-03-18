<h5>
	Edit Section
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'sections'; ?>" >Sections</a>
	
	
</h5>


<form method="POST" >

<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Position</th><td><input name="position" value="<?php echo $row['position']; ?>" /></td></tr>
<tr><th>Code</th><td><input name="code" value="<?php echo $row['code']; ?>" /></td></tr>
<tr><th>Name</th><td><input name="name" value="<?php echo $row['name']; ?>" /></td></tr>

<tr><td colspan="2" >
	<input type="submit" name="submit" value="Update" onclick="return confirm('Sure?');" />
	<button><a href="<?php echo URL.'sections'; ?>" >Cancel</a></button>
</td></tr>
</table>

</form>

