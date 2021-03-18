<h5>Classroom</h5>
<?php 
	// pr($data);
?>

<table class='gis-table-bordered table-fx'>

<tr><th>Level</th><td><?php echo $data['classroom']['level']; ?></td></tr>
<tr><th>Section</th><td><?php echo $data['classroom']['section']; ?></td></tr>
<tr><th>Total Students</th><td><?php echo $data['num_students']['total']; ?></td></tr>

</table>

<hr />

<!-- listStudents -->
<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>&nbsp;</th>
	<th>ID</th>
	<th>Code</th>
	<th>Student</th>
	<th>Pass</th>
	<th>Status</th>
	<th>Edit</th>
</tr>

<form method='post' > <!-- for batch edit/delete -->

<?php $i = 1; ?> <!-- for odd-even row shade -->
<?php foreach($data['students'] AS $row): ?>

<tr rel="<?php echo $row['id']; ?>" class="<?php echo (even($i))? 'even':'odd'?>" >
	<td><input type="checkbox" name="rows[<?php echo $row['id'];?>]" value="<?php echo $row['id']; ?>" /></td>
	<td id="id<?php echo $row['id']; ?>" ><?php echo $row['id']?></td>

	<td><?php echo $row['student_code']; ?></td>
	<td><?php echo $row['student']; ?></td>	
	<td><?php echo $row['pass']; ?></td>	
	<td <?php echo ($row['status'] == 1)? null : "class='red'"  ; ?> ><?php echo ($row['status'] == 1)? 'Active' : 'Inactive'  ; ?></td>
	
	<td>
		<a href="<?php echo URL.'teachers/editClassroomStudents/'.$row['id']; ?>">Edit</a> 
	</td>	
		
</tr>

<?php $i++;?>
<?php endforeach; ?>
</table>

<input type='submit' name='batch' value='Edit' >
<?php $this->shovel('boxes'); ?>

</form> <!-- for batch -->
