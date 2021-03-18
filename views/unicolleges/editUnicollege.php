<h5>
	Edit College | <?php $this->shovel('homelinks','College'); ?>
	
	
	
	
</h5>

<?php 

// pr($data);

?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Code</th><td><input name="post[code]" value="<?php echo $row['code']; ?>" ></td></tr>
<tr><th>Name</th><td><input name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
</table>
<br />
<input type="submit" name="submit" value="Save" >

</form>