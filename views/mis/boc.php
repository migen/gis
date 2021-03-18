<?php 

	// pr($courses[0]);

?>

<h5>
	Bill of Courses
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
</h5>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Pos</th>
	<th>Sub#</th>
	<th>Subject - Configure</th>
	<th>Classroom (Courses) - Teacher (Load) </th>
</tr>

<?php $i=0; ?>
<?php foreach($subjects AS $row): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['position']; ?></td>
	<td><?php echo $row['subject_id']; ?></td>
	<td class="vc100" ><a href='<?php echo URL."mis/subcourses/".$row['subject_id']; ?>' ><?php echo $row['name']; ?></a></td>
	<td>
	<?php foreach($courses[$i] AS $crs): ?>
		<a href='<?php echo URL."mis/clscrs/".$crs['crid']; ?>' ><?php echo $crs['classroom']; ?></a>
		- <a href='<?php echo URL."loads/teacher/".$crs['tcid']; ?>' ><?php echo $crs['teacher']; ?></a>
		<br />		 
	<?php endforeach; ?>
	</td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>