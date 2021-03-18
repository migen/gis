<?php 

$deciconducts = $_SESSION['settings']['deciconducts'];
$user = $_SESSION['user'];
$urid = $user['role_id'];


?>

<h5>
	Conduct | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	<?php if($user['role_id']==RTEAC): ?>
		| <a href="<?php echo URL.'averages/courseRanks/'.$course['course_id'].DS.$sy.DS.$qtr; ?>">Ranks</a> 	
	<?php endif; ?>
		<?php $params = $crid.DS.$course['course_id'].DS.$course['subject_id']."/$sy/$qtr" ;?>

	<!-- aggregates/tally - tally conducts if conductCourse is aggregate -->

</h5>


<?php 



?>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>

<!----------------------------------------------------------------------------------------------------------------->


<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course['course_id'].DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course['course_id'].DS.$sy.DS.$qtr; ?>" > Lock </a>
			<?php endif; ?>		
	</td></tr>

	<tr class="hd" ><th class='white headrow'>CRID</th><td><?php echo $course['crid']; ?></td></tr>
	<tr class="hd" ><th class='white headrow'>CrsID</th><td><?php echo $course['course_id']; ?></td></tr>
	<tr><th class='white headrow'>Classroom</th><td class="vc200" ><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
	<tr><th class='white headrow'>Subject</th><td><?php echo $course['subject']; ?></td></tr>	
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table><br />

<!----------------------------------------------------------------------------->
<?php if($num_conducts != $num_students): ?>
<p class="" ><?php
		echo "num-conducts: $num_conducts <br />";
		echo "num-students: $num_students <br />";
	?>
	
<a onclick="return confirm('Confirm?');" class="button" href='<?php echo URL."utils/cleanCourseGrades/$crid/$course_id/$sy"; ?>' >Sync Grades</a>
<a class="button" href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>' >Manage</a>
</p>
	
	
<?php endif; ?>	

<!----------------------------------------------------------------------------->


<form method="POST">	<!-- to update summaries conducts when finalizing,no need for grades since ajax editing -->

<table class="gis-table-bordered table-fx" >
<thead class="frozen" >
<tr class="bg-blue2" >
<th>#</th>
<th class="hd" >GID</th>
<th class="hd" >SCID</th>
<th>ID Number</th>
<th>Student</th>

<?php for($j=1;$j<5;$j++): ?>
	<th class="center <?php echo ($qtr==$j)? 'current' : null; ?>" >
		<?php if($qtr==$j): ?>Q &nbsp; <input class="center vc30" type="text" name="data[qtr]" value="<?php echo $j; ?>" readonly /><?php else: ?>Q<?php echo $j; ?><?php endif; ?>
	</th>
<?php endfor; ?>
<th class="center" >FG-<?php echo $qtr; ?></th>

</tr>
</thead>

<?php for($i=0;$i<$num_conducts;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>

<!------------------------------------------------------------------------------------------------------------------------------------------------>	

<?php for($j=1;$j<5;$j++): ?>
	<input type="hidden"  name="data[summary][<?php echo $i; ?>][q<?php echo $j; ?>]" value="<?php echo $conducts[$i]['q'.$j]; ?>"  />
<?php endfor; ?>

		
	<td class="hd" ><?php echo $conducts[$i]['gid']; ?></td>
	<td class="hd" ><?php echo $conducts[$i]['scid']; ?></td>
	<td><?php echo $conducts[$i]['student_code']; ?></td>
	<td><?php echo $conducts[$i]['student']; ?></td>

<?php for($j=1;$j<5;$j++): ?>
	<td class="center <?php echo ($qtr==$j)? 'current' : null; ?>" >
		<?php if($qtr==$j): ?>				
			<input name="data[summary][<?php echo $i; ?>][q<?php echo $j; ?>]" class="center vc80" type="text" value="<?php $cg =  number_format($conducts[$i]['q'.$j],$deciconducts); echo $cg; ?>"  <?php echo ($is_locked)? 'readonly' : null; ?> />
			<?php if($with_dg): ?> 
				<br /><?php echo $conducts[$i]['dg'.$j]; ?>
			<?php endif; ?>
			<input type="hidden" name="data[summary][<?php echo $i; ?>][gid]" value="<?php echo $conducts[$i]['gid']; ?>"  />		
		<?php else: ?> 
			<?php echo $conducts[$i]['q'.$j]; ?>
			<?php if($with_dg): ?><br /><?php echo $conducts[$i]['dg'.$j]; ?><?php endif; ?>			
		<?php endif; ?>			
	</td>
<?php endfor; ?>	
	
	
<!----------------------------------------------------------------------------------------------------------------->
	
	<td class="center" >
		<?php echo $conducts[$i]['q'.$intfqtr]; ?>
			<input type="hidden" class="vc50 center" name="data[summary][<?php echo $i; ?>][final]" value="<?php echo $conducts[$i]['q'.$intfqtr]; ?>" readonly />
		<?php if($with_dg): ?>
				<br /><?php echo $conducts[$i]['dg'.$intfqtr]; ?>
		<?php endif; ?>			
	</td>
	
	<?php if($urid==RMIS || $urid == RREG): ?>
		<td><a href='<?php echo URL."conducts/edit/$sy/$qtr/$course_id/".$conducts[$i]['scid']; ?>' >Edit</a></td>
	<?php endif; ?>			
	<input type="hidden" name="data[summary][<?php echo $i; ?>][scid]" value="<?php echo $conducts[$i]['scid']; ?>"  />
	
		
</tr>
<?php endfor; ?>
</table> <br />



<?php  if(($_SESSION['srid']==RTEAC) && (!$is_locked)):  ?>
	<input type='submit' name='submit' value='Save' onclick="return confirm('Are you sure?');"  /> 	
	<button><a class="no-underline txt-black" href='<?php echo URL."conducts/sortRanks/$sy/$qtr/$crid/$course_id"; ?>' >Finalize</a></button>		
<?php  endif;  ?>

	
</form>


<!--------------------------------------------------------------------------->

<script>
var hdpass = '<?php echo HDPASS; ?>';

	$(function(){	
		$('#hdpdiv').hide();
		hd();
		nextViaEnter();
		selectFocused();
		
	});
</script>
