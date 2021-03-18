<table class='gis-table-bordered table-fx'>

<tr>
	<th class='bg-blue2'>Class
		<?php if(isset($_GET['debug'])){ echo '#'.$course['crid']; } ?>			
	</th>
	<td><?php echo $course['level'].' - '.$course['section']; ?></td>
</tr>
<tr>
	<th class='bg-blue2'>Subject 
		<?php if(isset($_GET['debug'])){ 			
			echo '#'.$course['subject_id']; 
			echo ' | Crs#'.$course['course_id']; 
		} ?>				
	</th>			
	<td><?php echo $course['subject']; ?></td>
</tr>


<tr>
	<th class='bg-blue2'>Date (YYYY-MM-DD)</th>
	<td><input type='date' class='full juice' name='data[Activity][date]' value="<?php echo isset($activity['date'])? $activity['date'] : date('Y-m-d'); ?>" ></td>
</tr>

<tr>	
	<th class='bg-blue2'>Criteria
		<?php if(isset($_GET['debug'])){ echo '#'.$activity['criteria_id']; } ?>			
	</th>
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
	<th class='bg-blue2'>Activity 
		<?php if(isset($_GET['debug'])){ echo '#'.$activity['activity_id']; } ?>		
	</th>
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
