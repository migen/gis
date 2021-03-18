<h5>
	Edit | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Label</th><td><?php echo $row['label']; ?></td></tr>
<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>Value</th><td><input name="post[value]" value="<?php echo $row['value']; ?>" ></td></tr>
<tr><th colspan=2 >
<input type="submit" name="submit" value="Save" >
</th></tr>
</table>
</form>