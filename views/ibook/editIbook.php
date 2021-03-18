<h5>
	Edit Info
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'ibook'; ?>" >iBook</a>
	| <a href="<?php echo URL.'ibook/delete/'.$id; ?>" onclick="return confirm('Sure?');" >Delete</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Date</th><td><input type="date" name="post[date]" value="<?php echo $row['date']; ?>" ></td></tr>
<tr><th>Name</th><td><input class="vc500" name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Save"  /></th></tr>
</table>
</form>




