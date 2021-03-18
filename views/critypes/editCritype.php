<h5>
	Edit Critype
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'criteria'; ?>" >Criteria</a>
	| <a href="<?php echo URL.'critypes'; ?>" >Critypes</a>
	| <a href="<?php echo URL.'critypes/delete/'.$id; ?>" onclick="return confirm('Sure?');" >Delete</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><input class="" name="post[id]" value="<?php echo $row['id']; ?>" ></td></tr>
<tr><th>Name</th><td><input class="vc500" name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Save"  /></th></tr>
</table>
</form>




