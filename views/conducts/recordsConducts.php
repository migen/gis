<?php 

// $this->shovel('border');

$deciconducts = $_SESSION['settings']['deciconducts'];
$user = $_SESSION['user'];
$urid = $user['role_id'];
// pr($course);

?>

<h5>
	<?php echo $course['level'].' - '.$course['section']; ?> Conduct | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a>
	
<?php if($user['role_id']==RTEAC): ?>
	| <a href="<?php echo URL.'conducts/sortRanks/'.$sy.DS.$qtr.DS.$crid.DS.$course['course_id']; ?>">Ranks</a> 	
<?php endif; ?>
		<?php $params = $crid.DS.$course['course_id'].DS.$course['subject_id']."/$sy/$qtr" ;?>

		<!-- aggregates/tally - tally conducts if conductCourse is aggregate -->
	<?php if($course['is_sem']): ?>
		<?php if($qtr>2): ?>
			| <a href='<?php echo URL."semesters/conducts/$course_id/$sy/$qtr/2"; ?>' >2nd Sem</a>
		<?php endif; ?>	
	<?php endif; ?>	

	<?php if(!isset($_GET['edit'])): ?>
		| <a href='<?php echo URL."conducts/records/$course_id/$sy/$qtr?edit"; ?>' >Edit</a>
	<?php else: ?>
		| <a href='<?php echo URL."conducts/records/$course_id/$sy/$qtr"; ?>' >View</a>
	<?php endif; ?>
	
	| <span class="u" onclick="randomize('aim');" >Randomizer</span>	
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>
	| <a href="<?php echo URL.'conducts/process/'.$course['crid'].DS.$sy.DS.$qtr; ?>">Process</a> 	
	| <a href="<?php echo URL.'cdt/tally/'.$course['crid'].DS.$sy.DS.$qtr; ?>">Tally</a> 	
	| <a href='<?php echo URL."conducts/sync/$crid"; ?>' >Sync</a>	
	| <a href='<?php echo URL."copier/crs/".$course['course_id']; ?>' >Copier</a>		
	
</h5>

<p class="brown" >*Levels.with_conduct_dg=<?php echo ($with_dg)? 1:0; ?></p>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>


<?php 



?>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>

<!----------------------------------------------------------------------------------------------------------------->


<table class='gis-table-bordered table-fx'>
	<tr>
		<td class="hd" >
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course['course_id'].DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course['course_id'].DS.$sy.DS.$qtr; ?>" > Lock </a>
			<?php endif; ?>		
		</td>	
		<td><?php echo 'Crid#'.$course['crid']; ?></td>
		<td><?php echo $course['subject'].' #'.$course['course_id']; ?></td>
		<td><?php echo $course['teacher'].' #'.$course['tcid']; ?></td>	
		<td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td>
	</tr>	
	
</table><br />


<!----------------------------------------------------------------------------->
<?php if($num_conducts != $num_students): ?>
<p class="" ><?php
		echo "num-conducts: $num_conducts <br />";
		echo "num-students: $num_students <br />";
	?>
	
<a class="button" href='<?php echo URL."conducts/sync/$crid"; ?>' >Sync</a>	
<a onclick="return confirm('Confirm?');" class="button" href='<?php echo URL."utils/cleanCourseGrades/$crid/$course_id/$sy"; ?>' >Sync Grades</a>
<a class="button" href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>' >Manage</a>
</p>
	
	
<?php endif; ?>	

<!----------------------------------------------------------------------------->

<div style="float:left;width:70%" ><!-- left main -->

<form method="POST">	<!-- to update summaries conducts when finalizing,no need for grades since ajax editing -->

<table class="gis-table-bordered table-fx" >
<thead class="frozen" >
<tr class="bg-blue2" >
<th>#</th>
<th class="hd" >GID</th>
<th class="" >SCID</th>
<th>ID Number</th>
<th>Student</th>

<?php for($j=1;$j<5;$j++): ?>
	<th class="center <?php echo ($qtr==$j)? 'current' : null; ?>" >
		<?php if($qtr==$j): ?>Q &nbsp; <input class="center vc30" type="text" name="data[qtr]" value="<?php echo $j; ?>" readonly />
			<br /><input class="vc60 center" id="igrade" value="" />			
			<br /><button onclick="populateColumn('grade');return false;">All</button>		
		<?php else: ?>Q<?php echo $j; ?><?php endif; ?>
	</th>
<?php endfor; ?>
<th class="center" >FG-<?php echo $qtr; ?></th>
<th></th>
</tr>
</thead>

<?php for($i=0;$i<$num_conducts;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>

<!----------------------------------------------------------------------------------------->	

<?php for($j=1;$j<5;$j++): ?>
	<input type="hidden"  name="data[summary][<?php echo $i; ?>][q<?php echo $j; ?>]" value="<?php echo $conducts[$i]['q'.$j]; ?>"  />
<?php endfor; ?>

		
	<td class="hd" ><?php echo $conducts[$i]['gid']; ?></td>
	<td class="" ><?php echo $conducts[$i]['scid']; ?></td>
	<td><?php echo $conducts[$i]['student_code']; ?></td>
	<td><?php echo $conducts[$i]['student']; ?></td>

<?php for($j=1;$j<5;$j++): ?>
	<td class="center <?php echo ($qtr==$j)? 'current' : null; ?>" >
		<?php if($qtr==$j): ?>				
			<input name="data[summary][<?php echo $i; ?>][q<?php echo $j; ?>]" id="aim<?php echo $i; ?>" 
				class="grade center vc80" type="text" value="<?php $cg =  number_format($conducts[$i]['q'.$j],$deciconducts); echo $cg; ?>" />
			<?php if($with_dg): ?> 
				<br /><?php echo $conducts[$i]['dg'.$j]; ?>
			<?php endif; ?>
			<input type="hidden" name="data[summary][<?php echo $i; ?>][gid]" value="<?php echo $conducts[$i]['gid']; ?>"  />		
		<?php else: ?> 
			<?php echo ($conducts[$i]['q'.$j]+0); ?>
			<?php if($with_dg): ?><br /><?php echo $conducts[$i]['dg'.$j]; ?><?php endif; ?>			
		<?php endif; ?>			
	</td>
<?php endfor; ?>	
	
	
<!----------------------------------------------------------------------------------------------------------------->
	
	<td class="center" >
		<?php echo ($conducts[$i]['q5']+0); ?>
			<input type="hidden" class="vc50 center" name="data[summary][<?php echo $i; ?>][final]" value="<?php echo $conducts[$i]['q5']; ?>" readonly />
		<?php if($with_dg): ?>
				<br /><?php echo $conducts[$i]['dg5']; ?>
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
		<input type='submit' name='submit' value='Save' onclick="return confirm('Sure?');"  /> 	
		<input type='submit' name='submit' value='Finalize' onclick="return confirm('Sure?');"  /> 		
	<?php  elseif(($_SESSION['srid']==RMIS) || ($_SESSION['srid']==RREG)):  
	
	?>
		<input type='submit' name='submit' value='Save On' onclick="return confirm('Sure?');"  /> 	
		<input type='submit' name='submit' value='Finalize On' onclick="return confirm('Sure?');"  /> 		
	<?php  endif;  ?>


<?php if(($is_locked) && ($_SESSION['srid']==RMIS)): ?>
	<p><input type="submit" name="submit" value="Save On"  /></p>	
<?php endif; ?>

		
</form>

</div>	<!-- left main -->

<div style="float:left;width:20%;" ><?php $this->shovel('clipboard'); ?></div>

<div class="clear ht100" ></div>




<!--------------------------------------------------------------------------->

<script>
var hdpass = '<?php echo HDPASS; ?>';
var min=<?php echo isset($_GET['min'])? $_GET['min']:70; ?>;
var max=<?php echo isset($_GET['max'])? $_GET['max']:99; ?>;
var count=<?php echo isset($num_students)? $num_students:10; ?>;

	$(function(){	
		$('#hdpdiv').hide();
		itago('clipboard');
		hd();
		shd();
		nextViaEnter();
		selectFocused();
		
	});
</script>
