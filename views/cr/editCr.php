<h5>
	Edit Classroom | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'cr'; ?>" >Classrooms</a>
	| <a href="<?php echo URL.'cr/sessionizeLSM'; ?>" >Reset LSM</a>
	| <a href="<?php echo URL.'cr/ltd/'.$crid; ?>" >LTD</a>
	
	
</h5>


<?php 

// pr($data);



?>

<div class="half" >
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<?php foreach($cols AS $col): ?>
<tr>
	<th><?php echo $col; ?></th>
	<td><input name="post[<?php echo $col; ?>]" value="<?php echo $row[$col]; ?>" ></td>	
</tr>
<?php endforeach; ?>

<tr><th colspan=2><input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" ></th></tr>

</table>
</form>
</div>	<!-- row -->


<div class="clear ht100" ></div>