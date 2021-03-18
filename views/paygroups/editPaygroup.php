<h5>
	Edit Pay Group
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'paygroups?sy='.DBYR; ?>" >Pay Groups</a>
	| <a href="<?php echo URL.'paygroups/delete/'.$id; ?>" onclick="return confirm('Sure?');" >Delete</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Code</th><td><input class="" name="post[code]" value="<?php echo $row['code']; ?>" ></td></tr>
<tr><th>Name</th><td><input class="" name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><th>Position</th><td><input class="" name="post[position]" value="<?php echo $row['position']; ?>" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Save"  /></th></tr>
</table>
</form>




