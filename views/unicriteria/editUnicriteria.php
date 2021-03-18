<h5>
	Edit | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'unicriteria'; ?>" >Criteria</a>

</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Code</th><td><input name="post[code]" value="<?php echo $row['code']; ?>" ></td></tr>
<tr><th>Name</th><td><input name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><th colspan=2><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>


