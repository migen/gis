<?php 

// pr($data);

$cgdeci = $_SESSION['settings']['deciconducts'];
$decifconducts = $_SESSION['settings']['decifconducts'];
// pr($criteria[0]);

 
$qtr = $qtr;
$qqtr		= 'q'.$qtr;
$dgqtr = 'dg'.$qtr;

$is_locked;
$crsid 		 = $course['course_id']; 	
$num_criteria 	= count($criteria);

$flrgr = $_SESSION['settings']['floor_grade_ftnv'];



?>

<?php 

$home = $_SESSION['home'];

?>

<h5>
	<a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	<?php if($is_locked && $course['is_trait']==1): ?>
		| <a href="<?php echo URL.'advisers/characters/'.$course['crid'].'/2/'.$sy.DS.$qtr; ?>" >Summary</a>
	<?php endif; ?>
	
<span class="hd" >&nbsp; <a class="button" style="font-size:14px;" 
href='<?php echo URL."utils/cleanTPG/".$course['level_id'].DS.$course['crid'].DS.$course['id']."/$sy/$qtr"; ?>' > Clean Records </a> </span>	

	
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<?php $this->shovel('hdpdiv'); ?>

<!----------------------------------------------------------------------------------------------------------------->


<p><table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$crsid.DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$crsid.DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>		
	</td></tr>
	<tr><th class='white headrow'>Classroom</th><td><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
	<tr><th class='white headrow'>Subject</th><td><?php echo $course['subject']; ?></td></tr>	
	<tr class="hd" ><th class='white headrow'>CrsID</th><td><?php echo $course['course_id']; ?></td></tr>
	<tr><th class='white headrow'>Course</th><td><?php echo $course['name']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
	
</table>
</p>

<?php // pr($ix); ?>

<?php if(($_SESSION['qtr']==1) && (!empty($ix))): ?>
	<p>&nbsp; <a class="button" style="font-size:14px;" 
		href='<?php echo URL."utils/syncTPG/".$course['level_id'].DS.$course['crid'].DS.$course['id']."/$sy/$qtr"; ?>' > Sync Records </a> </p>	
<?php endif; ?>


<!----------------------------------------------------------------------->






<form method="POST" > <!-- for finalize use,cell edtiting is using ajax -->
<table id="tblExport"  class="gis-table-bordered table-fx" >
<thead class="frozen" >
<tr class="bg-blue2" >
	<td>#</td>
	<td class="hd" >CID</td>
	<td>ID Number</td>
	<td class="vc80">Student</td>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<td>
			<?php echo $criteria[$j]['code']; ?> 
			<span class="hd" ><br />Cri# <?php echo $criteria[$j]['criteria_id']; ?> </span>		
		
		</td>
	<?php endfor; ?>
<?php if($course['is_trait']==1): ?>
	<td class="vc80">Ave<br />Rating</td>	
<?php endif; ?>	
	<td class="vc100">Student</td>	
</tr>
</thead>



<?php for($i=0;$i<$num_students;$i++): ?>

<?php $ns = count($scores[$i]); ?>
<?php 
	if($ns == $num_criteria): 
?>	<!-- index matching -->

<?php 

?>

<tr id="row<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td class="hd" >
		<input class="vc50" type="text" name="students[<?php echo $i; ?>][scid]" value="<?php echo $students[$i]['scid']; ?>" readonly  />
		<br /><input class="vc50" type="text" name="students[<?php echo $i; ?>][sumid]" value="<?php echo $students[$i]['sumid']; ?>" readonly  />	
	</td>
	<td><?php echo $students[$i]['student_code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<td class="center">
			<input class="center vc80 sc<?php echo $i; ?>" name="grades[<?php echo $i; ?>][<?php echo $j; ?>][grd]" type="text" value="<?php $ts = $scores[$i][$j]['q'.$qtr]; echo number_format($ts,$cgdeci); ?>"  <?php echo ($is_locked)? 'readonly' : null; ?> />
			<br /><?php $tr = rating($ts,$ratings); echo $tr; ?>			
			<input class="center vc80" name="grades[<?php echo $i; ?>][<?php echo $j; ?>][dg]" type="hidden" value="<?php echo $tr; ?>" <?php echo ($is_locked)? 'readonly' : null; ?> />
			<input class="center vc80 " name="grades[<?php echo $i; ?>][<?php echo $j; ?>][gid]" type="hidden" value="<?php echo $scores[$i][$j]['gid']; ?>" <?php echo ($is_locked)? 'readonly' : null; ?> />
			<input class="center vc80 " name="grades[<?php echo $i; ?>][<?php echo $j; ?>][fg]" type="hidden" value="<?php $fg = $scores[$i][$j]['q5']; echo $fg; ?>" <?php echo ($is_locked)? 'readonly' : null; ?> />
			<input class="center vc80 " name="grades[<?php echo $i; ?>][<?php echo $j; ?>][dgf]" type="hidden" value="<?php echo rating($fg,$ratings); ?>" <?php echo ($is_locked)? 'readonly' : null; ?> />
		</td>		
	<?php endfor; ?>	

<?php if($course['is_trait']==1): ?>
	<td class="center" >
		<input class="vc50 center sumgr<?php echo $i; ?>" type="text" name="data[Summary][<?php echo $i; ?>][<?php echo 'cq'.$qtr; ?>]" value="<?php echo number_format($students[$i]['c'.$qqtr],$decifconducts);  ?>"  readonly />  
			<br /><?php $trf = rating($students[$i]['cq'.$qtr],$ratings); echo $trf; ?>
			<input class="vc50 center sumdg<?php echo $i; ?>" type="hidden" name="data[Summary][<?php echo $i; ?>][<?php echo 'cdg'.$qtr; ?>]" value="<?php echo $trf;  ?>"  />  
			<input class="vc50 center" type="hidden" name="data[Summary][<?php echo $i; ?>][fg]"  value="<?php $fg = $students[$i]['cfg']; echo $fg; ?>" />  
			<input class="vc50 center" type="hidden" name="data[Summary][<?php echo $i; ?>][dgf]" value="<?php echo rating($fg,$ratings);  ?>"  />  		
	</td>
	<input type='hidden' name="data[Summary][<?php echo $i; ?>][sumid]" value="<?php echo $students[$i]['sumid']; ?>" >					

<?php endif; ?>

<?php if(!$is_locked): ?>		
	<td>
		<a href="<?php echo URL.'cav/edit/'.$course['course_id'].DS.$students[$i]['scid'].DS.$sy.DS.$qtr;  ?>"  ><?php echo $students[$i]['student']; ?></a>		
	</td>
	
<?php else: ?>			
	<td><?php echo $students[$i]['student']; ?></td>		
<?php endif; ?>			
	
	
</tr>

<?php else: ?>

<tr>
	<td colspan="<?php echo $num_criteria+5; ?>" > 
		<?php 
			// echo $ns; 
			// pr($scores[$i]);
		?>
		Please update records of 
		<a href="<?php echo URL.'utils/syncStudentTraits/'.$course['id'].DS.$students[$i]['scid'].DS.$sy.DS.$qtr; ?>" >
		<?php echo $students[$i]['student_code'].' - '.$students[$i]['student']; ?> </a>
	</td>
</tr>

<?php endif; ?>  <!-- index matching -->

<?php endfor; ?>
</table> 

<br />


	<input type='hidden' name='data[course_id]' value="<?php echo $course['id']; ?>">
	<input type='hidden' name='data[qqtr]' value="<?php echo $qqtr; ?>">		
	<input type='hidden' name='data[qtr]' value="<?php echo $qtr; ?>">
	<input type='hidden' name='data[dgqtr]' value="<?php echo $dgqtr; ?>">	
	<input type='hidden' name='data[numcri]' value="<?php echo $num_criteria; ?>">	

<p id="btns" >

	<?php if(!$is_locked): ?>
		<input type='submit' name='tally' value='Tally' onclick="return confirm('Are you sure?');" />
		<input type='submit' name='finalize' value='Finalize' onclick="return confirm('Are you sure?');" />
		<input type='submit' name='lock' value='Lock' onclick="return confirm('Are you sure?');" />
	<?php endif; ?>
</p>

<input type="hidden" name="data[flrgr]" value="<?php echo $flrgr; ?>"  />	

</form>



<!---------------------------------------------------------------------------------------------->

<?php 

// pr($scores[0]);
// pr($ratings);

?>


<!---------------------------------------------------------------------------------------------->


<script>

var numcri = <?php echo $num_criteria; ?>;
var hdpass = '<?php echo HDPASS; ?>';


$(function(){	
	$('#hdpdiv').hide();
	hd();
	nextViaEnter();	  
});


function disableBtns(){
	$('#btns').hide();	
}


function disablethis(bid){
	$('#'+bid).hide();	
}




// IMPT: for update all feature
function populateRow(inRow,inVal){
	var vr = '#'+inRow;
	$(vr+' td input').val(inVal);
}


</script>


