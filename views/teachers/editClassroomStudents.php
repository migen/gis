<?php 

// pr($data);



?>


<form id='editStudentForm' method='post' >

<br />

<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>&nbsp;</th>
	<th>ID</th>
	<th>Code</th>
	<th>Name</th>
	<th>Classroom</th>
	<th>Pass</th>
	<th>Status</th>
</tr>

<tbody id='tableStudent'>
<?php 	
	$this->shovel('passgen'); 
?>

<?php $i=0; ?>
<?php foreach($data['Student'] as $row): ?>
<?php 
	$pass = passgen();
	
?>


<tr>
	<td>&nbsp;</td>

	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['student_code']; ?></td>
	<td><?php echo $row['student']; ?></td>	
	<td><?php echo $row['level'].' - '.$row['section']; ?></td>	
	<td><input id='pass<?php echo $i; ?>' class='pass' type='text' name='data[Student][<?php echo $i; ?>][pass]' value="<?php echo (!empty($row['pass']))? $row['pass'] : $pass; ?>" /></td>			

	<td>
		<input id='active_status<?php echo $i; ?>' type='radio' name='data[Student][<?php echo $i; ?>][status]' value="1" <?php echo ($row['status'] == 1)? "checked":null; ?> /> Active
		<input id='inactive_status<?php echo $i; ?>' type='radio' name='data[Student][<?php echo $i; ?>][status]' value="0" <?php echo ($row['status'] == 0)? "checked":null; ?> /> Inactive		
	</td>		


	<input type='hidden' name='data[Student][<?php echo $i; ?>][id]' value="<?php echo isset($row['id'])? $row['id']:null ?>"/>
</tr>





<?php $i++; ?>			
<?php endforeach; ?>
</tbody></table>
<?php 
	$crid = Session::get('crid');
?>
<input type='button' id='clearPasses' value='Clear Passes' onclick='clearpass();return false;' />

<input type='submit' name='submit' value='Submit'> &nbsp; <a href="<?php echo URL.'teachers/classroom/'.$crid; ?>">Cancel</a>


</form> <!-- editStudentForm -->