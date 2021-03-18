<?php 
	$crs=$course['course_id'];
?>
<h5>
	Activities | 
	<a href="<?php echo URL; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'sam/purgeCourseScores/'.$crs; ?>" >Purge Scores</a>
	| <a href='<?php echo URL."teachers/scores/$crs/$sy/$qtr"; ?>' >Scores</a>
	
	
</h5>

	<?php 

	// pr($data);

	
?>


<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Level</th><td><?php echo $course['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $course['section']; ?></td></tr>
	<tr><th class='white headrow'>Subject</th><td><?php echo $course['subject']; ?></td></tr>	
</table>


<br />

<h5>Advisory Classes</h5>

<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th>Date</th>
	<th>Criteria</th>
	<th>Activity</th>
	<th>Over</th>
	<th>Manage</th>
</tr>
<?php for($i=0;$i<$data['num_activities'];$i++): ?>
<?php $row = $data['activities'][$i]; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo date('M-d',strtotime($row['activity_date'])); ?></td>
	<td><?php echo $row['criteria']; ?></td>
	<td><?php echo $row['activity']; ?></td>
	<td><?php echo $row['max_score']; ?></td>
	<td>
		<a href="<?php echo URL.'scores/edit/'.$data['course_id'].DS.$row['activity_id'].DS.$sy.DS.$qtr; ?>">Edit</a> | 
		<a href="<?php echo URL.'scores/delete/'.$data['course_id'].DS.$row['activity_id'].DS.$sy.DS.$qtr.'&blank'; ?>" >Delete</a>
	</td>	
</tr>
<?php endfor; ?>
</table>
