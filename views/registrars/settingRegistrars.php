<h5>
	Setting 
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<?php 
// pr($data);
?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th><?php echo $row['name']; ?></th>
<td><input type="text" name="value" value="<?php echo $row['value']; ?>" ></td>
<input type="hidden" name="id" value="<?php echo $row['id']; ?>" >
</tr>
<tr><th colspan=2><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>
