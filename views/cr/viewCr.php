<h5>
	View Classroom | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'cr'; ?>" >Classrooms</a>
	| <a href="<?php echo URL.'cr/edit/'.$crid; ?>" >Edit</a>
	| <a href="<?php echo URL.'cr/ltd/'.$crid; ?>" >LTD</a>
	
	
</h5>


<?php 

// pr($data);



?>

<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Adviser</th><td><?php echo $row['adviser']; ?></td></tr>
<tr><th>Level</th><td><?php echo $row['level']; ?></td></tr>
<tr><th>Section</th><td><?php echo $row['section']; ?></td></tr>
<tr><th>Major</th><td><?php echo $row['major']; ?></td></tr>
<tr><th>Department</th><td><?php echo $row['department']; ?></td></tr>
<tr><th>Sub Department</th><td><?php echo $row['subdepartment']; ?></td></tr>
<?php foreach($columns_array AS $col): ?>
<tr>
	<th><?php echo $col; ?></th>
	<td><?php echo $row[$col]; ?></td>	
</tr>
<?php endforeach; ?>


</table>

<div class="ht100" ></div>






