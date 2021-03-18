<h5>
	Edit Foundation Type
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'fdntypes/index/'.DBYR; ?>" >Foundation Types</a>
	| <a href="<?php echo URL.'fdntypes/delete/'.$id.DS.$sy; ?>" onclick="return confirm('Sure?');" >Delete</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Code</th><td><input class="" name="post[code]" value="<?php echo $row['code']; ?>" ></td></tr>
<tr><th>Name</th><td><input class="" name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Save"  /></th></tr>
</table>
</form>




