

<?php 
	// pr($data);
	// pr($course);
	// pr($equivs);
	// pr($grades[0]);

$this->shovel('ratings',$ratings);

$decigrades = $_SESSION['settings']['decigrades'];

	// $g = equiv('8',$equivs);
	// pr($g);
		
	
?>


<?php if($num_students !== $num_grades): ?>
<p><?php 
	echo "Number of Grades: $num_grades <br />";
	echo "Number of Students: $num_students <br />";
?></p>

<a onclick="return confirm('Confirm?');" class="button" href='<?php echo URL."utils/cleanCourseGrades/$crid/$course_id/$sy"; ?>' >Sync Grades</a>
<a class="button" href='<?php echo URL."$home/course/$course_id/$sy/$qtr"; ?>' >Manage</a>

<?php endif; ?>

<!---------------------------------------------------------------------------------------->

<h5>
	Grades (EQ)
	| <?php $this->shovel('homelinks','teachers'); ?>
	| <a href="<?php echo URL.'averages/course/'.$course['id'].DS.$sy.DS.$qtr;  ?>" > FG </a>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a>
	
</h5>

<p>
	Please follow the sequence 1) Save  2) Finalize 
</p>
<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>


<!---------------------------------------------------------------------------------------->


<table class='table-fx gis-table-bordered'>
<tr class="hd" ><th>Locking</th><td>
	<?php if($is_locked): ?>
		<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Unlock </a>
	<?php else: ?>
		<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Lock </a>			
	<?php endif; ?>		
</td></tr>

<tr><th>Course ID</th><td><?php echo $course['course_id']; ?></td></tr>
<tr><th>Class</th><td><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
<tr><th>Subject</th><td><?php echo $course['label']; ?></td></tr>
<tr><th>Teacher Code</th><td><?php echo $course['teacher_code']; ?></td></tr>
<tr><th>Teacher</th><td><?php echo $course['teacher']; ?></td></tr>
<tr><th>Status</th><td>Q<?php echo $qtr.' - '; echo ($is_locked)? 'Closed':'Open'; ?></td></tr>
</table>

<br />

<table class='table-fx gis-table-bordered table-scores center'>
<tr class='headrow'>
<th>#</th>
<th>Student</th>
<?php for($j=1;$j<5;$j++): ?>
<th>
	<?php echo ($j==$qtr)? 'Raw':'Q'.$j; ?>
</th>
	<?php if($j==$qtr): ?>
		<th><?php echo "Q$j"; ?></th>
	<?php endif; ?>
<?php endfor; ?>
</tr>

<form id="form" method='post' > <!-- for batch edit/delete -->
<?php $i=1; ?>
<?php foreach($grades as $row): ?>

<input type="hidden" name="grades[<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" />


<tr class="<?php echo (even($i))? 'even':'odd'?>">
<!---------------------------------------------------------------------------------->

<td><?php echo $i; ?></td>
<td id="<?php echo 'GID: '.$row['gid'].' | SCID: '.$row['scid'].' : '.$row['student_code']; ?>" ondblclick="alert(this.id);" ><?php echo $row['student']; ?></td>

<!---------------------------------------------------------------------------------->

<?php for($j=1;$j<5;$j++): ?>

<td>
<?php if($qtr!=$j): ?>
	<?php ${'q'.$j} = $row['q'.$j] + $row['bonus_q'.$j]; echo number_format(${'q'.$j},$decigrades); ?>	
	<?php if($is_k12): ?>
		<br /><?php echo $row['dg'.$j]; ?>	
	<?php endif; ?>
<?php else: ?>	
	<input class="vc50 center" name="grades[<?php echo $i; ?>][grade]" value="<?php $grade = number_format($row['q'.$j],$decigrades); echo $row['rq'.$j]; ?>" <?php echo ($is_locked)? 'readonly' : NULL; ?> />

	<input type="hidden" class="vc50 center" name="grades[<?php echo $i; ?>][dg]" value="<?php $dg = rating($grade,$ratings); echo $dg; ?>" <?php echo ($is_locked)? 'readonly' : NULL; ?> />
	<?php if($is_k12): ?>
		<br /><?php echo $row['dg'.$j]; ?>
	<?php endif; ?>
<?php endif; ?>
</td>

<?php if($j==$qtr): ?>
	<th><?php echo $grade; ?></th>
<?php endif; ?>

<?php endfor; ?>



<!---------------------------------------------------------------------------------->
<input type="hidden"  name="grades[<?php echo $i; ?>][gid]" value="<?php echo $row['gid']; ?>"  />
<!---------------------------------------------------------------------------------->


</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>

<?php if(!$is_locked): ?>
<p>
	<p>Please follow the sequence 1) Save  2) Finalize </p>
	<input type="submit" onclick="return confirm('Save! Are you sure?');" name="submit" value="1 - Save"  />
	<button><span class="" onclick="redirectCourse();return false;" >2 - Finalize</span></button>
		
</p>
<?php endif; ?>

</form> <!-- for batch -->

<div class='ht100'></div>




<!--------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';	
var hdpass 	= '<?php echo HDPASS; ?>';
var crsid	= '<?php echo $crsid; ?>';
var sy   	= '<?php echo $sy; ?>';
var qtr 	= '<?php echo $qtr; ?>';


$(function(){	
	$('#hdpdiv').hide();
	hd();
	nextViaEnter();		
	selectFocused();		
});
	

	
function redirectCourse(){			
	var vurl 	= gurl + '/averages/course/'+crsid+'/'+sy+'/'+qtr;		
	window.location = vurl;

}
		
	
</script>
