<?php 
	// pr($data);
	$cr = $data['classroom'];
?>

<!-- hyperlinks -->
<h5>
	Edit Bonuses |
	<?php $this->shovel('homelinks','teachers'); ?>
</h5>

<!------------------------------------------------------------------------->

<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $cr['section']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?></td></tr>
</table>
<br />

<!------------------------------------------------------------------------->


<form method='post'>

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th>SCID</th>
	<th>ID Number</th>
	<th>Student</th>
	<!-- left to right iteration -->
	<?php foreach($data['bonuses'][0] AS $row): ?>
		<th class='center'><?php echo $row['subject_code']; ?>
			<?php // echo '<br />'.$row['course_id'];?>
		</th>
	<?php endforeach; ?>
</tr>

<?php $bonuses = $data['bonuses']; ?>
<?php
	$qtr = $data['qtr'];
	$bqqtr = 'bonus_q'.$qtr; 

?>
<?php $num_students = $data['num_students']; ?>		
<?php $num_courses  = $data['num_courses']; ?>		

<?php $courses = $data['courses']; ?>
<?php // $num_courses = count($data['courses']); // complete,15,got missing index error ?>		
<?php $num_courses = count($data['bonuses'][0]); // incomplete 12,no index error ?>		

<?php $k = 100; ?>
<?php for($is=0;$is<$num_students;$is++): ?> 	<!-- loop thru num_students-->
<tr>
	<td><?php echo $is+1; ?></td>
	<td><?php echo $students[$is]['scid']; ?></td>
	<td><?php echo $students[$is]['student_code']; ?></td>
	<td><?php echo $students[$is]['student']; ?></td>
	
	<?php for($ic=0;$ic<$num_courses;$ic++): ?> 	<!-- loop thru num_courses,top down -->
		<?php $k++; ?>
		<td class='center' style='vertical-align:middle;'>
			<input type='text' name="data[Bonus][<?php echo $k; ?>][<?php echo $bqqtr; ?>]" value="<?php echo round($bonuses[$is][$ic][$bqqtr],2); ?> " style='width:80' class='center'>
			<input type='hidden' name="data[Bonus][<?php echo $k; ?>][id]" value="<?php echo $bonuses[$is][$ic]['grade_id']; ?>" style='width:50' class='center'>
						
		</td>	
	<?php endfor; ?>								<!-- endloop columns num_courses -->
</tr>
<?php endfor; ?>								<!-- endloop row num_students -->
</table>

<input type='hidden' name='qtr' value="<?php echo $bqqtr; ?>" >

<p>
	<input type='submit' name='submit' value="Update" >
	<button><a class="no-underline" href="<?php echo URL.'teachers/bonuses/'.$cr['crid'].DS.$data['qtr']; ?>" />Cancel</a></button>
</p>


</form>

<script>
	$(function(){	nextViaEnter();		});
</script>