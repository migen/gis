<?php 

// pr($data);

// pr($courses[6]);
// pr($courses[7]);
// pr($courses[4]);
// pr($courses[1]);
	

?>



<h5>
	<span ondblclick="xxtracehd();" >Courses </span> | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
	
</h5>


<form method="POST" >	<!-- form add courses -->
<!------------------------------------------------------------------>
<table class="table-fx gis-table-bordered">
<tr><th class="headrow white" >TCID</th><td><?php echo $teacher['tcid']; ?></td></tr>
<tr><th class="headrow white" >ID Number</th><td><?php echo $teacher['teacher_code']; ?></td></tr>
<tr><th class="headrow white" >Teacher</th><td><?php echo $teacher['name']; ?></td></tr>
</table> <br />

<!------------------------------------------------------------------------------------------------------------------------>

<table class="table-fx gis-table-bordered table-altrow">
<tr class='headrow'>
	<th>#</th>
	<th class="" >ID</th>
	<th class="vc150" >Classroom</th>
	<th>Type</th>
	<th class="vc120" >Subject</th>
	<th class="vc120" >Label</th>
	<th>Schedule</th>	
</tr>
<!-- tbody -->
<?php for($i=0;$i<$num_courses;$i++): ?>
	<?php $active = ($courses[$i]['is_active'])? true:false;  ?>
	<tr id="tr<?php echo $i; ?>" class="<?php echo (!$active)? 'red':NULL; ?>"  >
		<td id="<?php echo $courses[$i]['course_id']; ?>" onclick="alert(this.id);" ><?php echo $i+1; ?></td>
		<td><?php echo $courses[$i]['course_id']; ?></td>
		<td><?php echo $courses[$i]['classroom']; ?></td>
		<td><?php echo $courses[$i]['crstype']; ?></td>
		<td><?php echo $courses[$i]['subject']; ?></td>
		<td><?php echo $courses[$i]['label']; ?></td>
		<td><?php echo $courses[$i]['schedule']; ?></td>		
	</tr>
	
	<input type="hidden" name="courses[<?php echo $i; ?>][id]" value="<?php echo $courses[$i]['course_id']; ?>"  >
	
<?php endfor; ?>

</table>



</form> <!-- save -->



</table>

<!------------------------------------------------------------------------->


