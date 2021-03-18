<h5>
	Add Pay Group
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'paygroups?sy='.DBYR; ?>" >Pay Groups</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Code</th><td><input class="" name="post[code]" value="" ></td></tr>
<tr><th>Name</th><td><input class="" name="post[name]" value="" ></td></tr>
<tr><th>Position</th><td><input class="" name="post[position]" value="1" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Add"  /></th></tr>
</table>
</form>




