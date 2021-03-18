<h5>
	<?php 
		
	?>
	Add <?php echo $table; ?> | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<?php

// pr($data);




?>

<form method="POST" >
<table class="gis-table-bordered" >

<?php foreach($columns AS $k=>$key): ?>
<tr><th><?php echo $key; ?></th>
	<td><input name="post[<?php echo $key; ?>]" /></td></tr>
<?php endforeach; ?>
<tr><td colspan=2 ><input type="submit" name="submit" value="Save" ></td></tr>
</table>
</form>

<div class="ht50 clear" >&nbsp;</div>
