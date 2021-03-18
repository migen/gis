<?php 

// pr($club_id);
// exit;
// $this->shovel('border');


?>

<h5>
	Club Members With Course (<?php echo $count; ?>)
	<?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/notes'; ?>" >Notes</a>
	| <a href="<?php echo URL.'clubs/members/'.$club_id.DS.$sy; ?>" >Members</a>
	| <a href="<?php echo URL.'clubs/tagging/'.$club_id; ?>" >Tagging</a>
	| <a href="<?php echo URL.'clubs/batch/'.$club_id; ?>" >Batch</a>
	| <a href="<?php echo URL.'clubs/scores/'.$club_id.DS.$sy.DS.$qtr; ?>" >Scores</a>
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr; ?>" >Grades</a>
	
</h5>

<?php include_once('incs/clubDetails.php'); ?>

<div class="half" >
<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>Course</th>
<th>Classroom</th>
<th>Scid</th>
<th>ID No.</th>
<th>Student</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo '#'.$rows[$i]['crs'].' - '.$rows[$i]['course']; ?></td>
	<td><?php echo '#'.$rows[$i]['crid'].' - '.$rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student_code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</table>
</div>	<!-- left -->

<div class="clear ht50" >&nbsp;</div>


