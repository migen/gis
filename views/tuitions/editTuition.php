<?php 



?>

<h5>
	Edit Tuition | <?php $this->shovel('homelinks'); ?>	
	| <a href="<?php echo URL.'tuitions/table/'.$row['sy']; ?>" >Table</a>
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<?php 
	$pkid=$row['pkid'];
?>
<tr><th>Level</th><td><?php echo $row['lvlname']; ?></td></tr>
<?php if($row['level_id']>13): ?>
	<tr><th>Level</th><td><?php echo $row['num']; ?></td></tr>
<?php endif; ?>
<tr><th>Total</th><td><?php echo $row['total']; ?></td></tr>
<tr><th>Change</th><td>	
	<input name="tuition[total]" value="<?php echo $row['total']; ?>" >
</td></tr>

<tr><th>Notes</th><td>	
	<textarea rows=12 cols=120 name="tuition[notes]" ><?php echo $row['notes']; ?></textarea>
</td></tr>


<tr><th colspan=2><input type="submit" name="submit" value="Save" ></th></tr>
</table>
</form>

