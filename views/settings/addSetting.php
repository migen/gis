<h5>
	Add | <?php $this->shovel('homelinks'); ?>
	
	
</h5>



<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><input name="post[id]" value="<?php echo $id; ?>" ></td></tr>
<tr><th>Label</th><td><input name="post[label]" placeholder="label" ></td></tr>
<tr><th>Label</th><td><input name="post[name]" placeholder="name" ></td></tr>
<tr><th>Value</th><td><input name="post[value]" placeholder="value" ></td></tr>
<tr><th colspan=2 >
<input type="submit" name="submit" value="Save" >
</th></tr>
</table>
</form>