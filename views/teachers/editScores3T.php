

<?php 
// pr($data);
// exit;
// pr($course);



// pr($activity);

$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];
$is_k12 	= ($is_k12 && !$is_ps);
// echo ($is_k12)? 'yes bedk12' : 'not bedk12';



?>

<h5>
	<a href="<?php echo URL.'teachers'; ?>">Home</a> |
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a>
	
| Edit Scores - <?php echo $activity['activity']; ?> 
| <span onclick="tracehd();" >Paste Scores</span>
	
</h5>

<div class="half" >

<form method='POST'>

<table class='gis-table-bordered table-fx'>

<tr>
	<th class='bg-blue2'>Class</th>
	<td><?php echo $course['level'].' - '.$course['section']; ?></td>
</tr>
<tr>
	<th class='bg-blue2'>Subject</th>
	<td><?php echo $course['subject']; ?></td>
</tr>


<tr>
	<th class='bg-blue2'>Date (YYYY-MM-DD)</th>
	<td><input type='date' class='full juice' name='data[Activity][date]' value="<?php echo isset($activity['date'])? $activity['date'] : date('Y-m-d'); ?>" ></td>
</tr>

<tr>	
	<th class='bg-blue2'>Criteria</th>
	<td>
		<select class='full' type='text' name='data[Activity][component_id]'   >
				<?php if($course['is_acad'] || $course['is_elective']): ?>
					<option>Choose Criteria</option>
					<?php	foreach($data['selects']['criteria'] as $sel): ?><option value="<?php echo $sel['component_id']; ?>"  <?php echo ($sel['criteria_id'] == $activity['criteria_id'])? 'selected' : null; ?> ><?php echo $sel['criteria']; ?></option><?php	endforeach; ?>				
				<?php else: ?>
					<option value="<?php echo $activity['criteria_id']; ?>" ><?php echo $activity['criteria']; ?></option>
				<?php endif; ?>
		</select>		
	</td>
</tr>

<?php if($kpup): ?>
	<tr>	
		<th class='bg-blue2'>Subcriteria</th>
		<td>
			<select class='full' type='text' name='data[Activity][subcomponent_id]'  >
				<option>Choose Subcriteria</option>
				<?php	foreach($data['selects']['subcriteria'] as $sel): ?><option value="<?php echo $sel['subcriteria_id']; ?>"  <?php echo ($sel['subcriteria_id'] == $activity['subcriteria_id'])? 'selected' : null; ?>  ><?php echo $sel['subcriteria']; ?></option><?php	endforeach; ?>				
			</select>		
		</td>
	</tr>
<?php endif; ?>


<tr>
	<th class='bg-blue2'>Activity</th>
	<td>
			<input class="full pdl05" id='activity' type='text' name='data[Activity][name]' value="<?php echo $activity['activity']; ?>" >
			
	</td>
</tr>


<tr>
	<th class='bg-blue2'>Max Score</th>	
	<td>
		<input type="text" name="data[Activity][max_score]" maxlength='3' class="pdl05 full" value="<?php echo $activity['max_score']; ?>" />
	</td>
</tr>

	<input type='hidden' name='data[Activity][activity_id]' value="<?php echo $activity['activity_id']; ?>" >
</table>

<hr />

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Score</th>
</tr>

<!------------------ data ------------------------------------------------------------------->

<?php $num_scores = count($data['scores']); ?>
<?php for($i=0;$i<$num_scores;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $scores[$i]['student_code']; ?></td>
	<td><?php echo $scores[$i]['student']; ?></td>
	<td><input id="score<?php echo $i; ?>" class="right vc70 pdr05" name='data[Score][<?php echo $i; ?>][score]' 
		value="<?php echo isset($data['scores'][$i]['score'])? $data['scores'][$i]['score'] : 0; ?>" ></td>

	<?php if($_SESSION['settings']['show_valid_radio'] == 1): ?>
		<td><input type='radio' name='data[Score][<?php echo $i; ?>][is_valid]' value='1' <?php echo ($scores[$i]['is_valid'] == 1)? 'checked' : null;  ?>  >Present</td>
		<td><input type='radio' name='data[Score][<?php echo $i; ?>][is_valid]' value='0' <?php echo ($scores[$i]['is_valid'] != 1)? 'checked' : null;  ?> 		  >Excused</td>		
	<?php endif; ?>
		
	
		<input type='hidden' name='data[Score][<?php echo $i; ?>][id]' value="<?php echo isset($scores[$i]['score'])? $scores[$i]['id'] : 0; ?>" >
</tr>


<?php endfor; ?>

</table>

<p>
	<input type='submit' name='submit' value='Submit'> &nbsp; 	
	<button><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="no-underline" >Cancel</a></button>
</p>	

</form> <!-- editScoresForm -->

</div> 	<!-- scores half -->


<!-------------------------------------------------------------------------------------------------------------->

<div class="hd" > 
	<button onclick="pasteFromExcel('scorebox','score');return false;"> Paste Value </button>
	<br /><br />
	<textarea id="scorebox" rows="30" cols="3"  ></textarea>

</div>	<!-- valuesFromExcel -->


<!------------------------------------------------------------------------------------------------->

<script>
	$(function(){	
		hd();
		nextViaEnter();		
		selectFocused();
		
	});
</script>


