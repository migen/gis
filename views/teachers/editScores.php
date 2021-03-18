<script>
	$(function(){	nextViaEnter();		});
</script>


<?php 
// pr($data);

$activity = $data['activity'];

$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];
$is_bedk12 	= ($is_k12 && !$is_ps);
// echo ($is_bedk12)? 'yes bedk12' : 'not bedk12';



?>

<h5>
	<a href="<?php echo URL.'teachers'; ?>">Home</a> |
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a> |
	Edit Scores - <?php echo $activity['activity']; ?> 
</h5>

<div class="half" >
<h5>Edit Scores - <?php echo $activity['activity']; ?> 
| <span onclick="tracehd();" >Paste Scores</span>
</h5>



<form method='POST'>

<table class='gis-table-bordered table-fx'>
<tr>
	<th class='bg-blue2'>Date (YYYY-MM-DD)</th>
	<td><input type='date' class='juice' name='data[Activity][date]' style='width:200px;' value="<?php echo isset($activity['date'])? $activity['date'] : date('Y-m-d'); ?>" ></td>
</tr>

<tr>	
	<th class='bg-blue2'>Criteria</th>
	<td>
		<select type='text' name='data[Activity][component_id]' class='vc200'  >
				<?php if($course['is_acad']): ?>
					<option>Choose Criteria</option>
					<?php	foreach($data['selects']['criteria'] as $sel): ?><option value="<?php echo $sel['component_id']; ?>"  <?php echo ($sel['criteria_id'] == $activity['criteria_id'])? 'selected' : null; ?> ><?php echo $sel['criteria']; ?></option><?php	endforeach; ?>				
				<?php else: ?>
					<option value="<?php echo $activity['criteria_id']; ?>" ><?php echo $activity['criteria']; ?></option>
				<?php endif; ?>
		</select>		
	</td>
</tr>

<?php if(($is_bedk12) && ($course['is_acad'])): ?>
	<tr>	
		<th class='bg-blue2'>Subcriteria</th>
		<td>
			<select type='text' name='data[Activity][subcomponent_id]' class='vc200' >
				<option>Choose Subcriteria</option>
				<?php	foreach($data['selects']['subcriteria'] as $sel): ?><option value="<?php echo $sel['subcriteria_id']; ?>"  <?php echo ($sel['subcriteria_id'] == $activity['subcriteria_id'])? 'selected' : null; ?>  ><?php echo $sel['subcriteria']; ?></option><?php	endforeach; ?>				
			</select>		
		</td>
	</tr>
<?php endif; ?>


<?php if(($course['is_acad']) || ($course['is_club'])): ?>
	<tr>
		<th class='bg-blue2'>Activity</th>
		<td>
				<input id='activity' type='text' name='data[Activity][name]' style="vc200" value="<?php echo $activity['activity']; ?>" >
				
		</td>
	</tr>
<?php endif; ?>

<tr>
	<th class='bg-blue2'>Max Score</th>	
	<td>
		<?php if($course['is_acad'] == 1): ?>
			<input type="text" name="data[Activity][max_score]" maxlength='3' class="vc50" value="<?php echo $activity['max_score']; ?>" />
		<?php elseif(($course['is_trait'] == 1) || ($course['is_psmapeh'] == 1)): ?>
			<?php   if($course['is_hs'] == 1): ?>
				<input type="text" name="data[Activity][max_score]" maxlength='3' style='width:50px' value="4" readonly>
			<?php   else: ?>
				<input type="text" name="data[Activity][max_score]" maxlength='3' style='width:50px' value="100" readonly>
			<?php   endif; ?>
		<?php elseif ($course['is_conduct'] == 1): ?>
		<input type="text" name="data[Activity][max_score]" maxlength='3' style='width:50px' value="100" readonly>
		<?php endif; ?>			
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


<?php $num_scores = count($data['scores']); ?>
<?php for($i=0;$i<$num_scores;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $data['scores'][$i]['student_code']; ?></td>
	<td><?php echo $data['scores'][$i]['student']; ?></td>
	<td><input type='text' name='data[Score][<?php echo $i; ?>][score]' value="<?php echo isset($data['scores'][$i]['score'])? $data['scores'][$i]['score'] : 0; ?>" ></td>
	<!-- hidden score_id for updating scores -->	

	<!-- if absent,0 score not included in the grade TNV computation -->
	<?php if($_SESSION['settings']['show_valid_radio'] == 1): ?>
		<td><input type='radio' name='data[Score][<?php echo $i; ?>][is_valid]' value='1' <?php echo ($data['scores'][$i]['is_valid'] == 1)? 'checked' : null;  ?>  >Present</td>
		<td><input type='radio' name='data[Score][<?php echo $i; ?>][is_valid]' value='0' <?php echo ($data['scores'][$i]['is_valid'] != 1)? 'checked' : null;  ?> 		  >Absent</td>		
	<?php endif; ?>
		
	
		<input type='hidden' name='data[Score][<?php echo $i; ?>][id]' value="<?php echo isset($data['scores'][$i]['score'])? $data['scores'][$i]['id'] : 0; ?>" >
</tr>


<?php endfor; ?>

</table>

<input type='submit' name='submit' value='Submit'> &nbsp; <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Cancel</a>

</form> <!-- editScoresForm -->

</div> 	<!-- scores half -->

<!-------------------------------------------------------------------------------------------------------------->

<div class="hd" > 	<!-- valuesFromExcel -->
	<button onclick="pasteFromExcel('scorebox','score');return false;"> Paste Value </button>
	<br /><br />
	<textarea id="scorebox" rows="30" cols="3"  ></textarea>

</div>	<!-- valuesFromExcel -->
