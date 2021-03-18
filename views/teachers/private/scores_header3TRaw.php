

<!-- 3T kpup -->

<tr class="bold white bg-blue1" >			
	<th colspan="<?php echo ($showcid)? '3':'2'; ?>" class='center'>
		<?php echo $course['name'].' <br /> '.$course['teacher']; ?>	
	</th>
	
	<?php
		$colspan = 0; 
		for($i=0;$i<$num_activities;$i++):
		$j = $i+1;
	?>

		<?php if($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id']): ?>	<!-- different criteria_id,next cell for next criteria -->
			<?php $colspan += 1;	?>							
		<?php else: ?>
			<?php $colspan += 1;	?>					
			<th class='center' colspan="<?php echo $colspan; ?>">
				<?php 
					// pr($activities[$i]['criteria']); 
					// echo $activities[$i]['criteria']; 
				?>
				<?php if($editable): ?>
					<a href="<?php echo URL.'scores/add/'.$course['id'].DS.$data['qtr'].DS.$activities[$i]['criteria_id']; ?>"><?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?></a>
				<?php else: ?>	
					<?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?>				
				<?php endif; ?>	
				<?php $colspan = 0; ?>
			</th>							
		<?php endif; ?>

	<?php endfor; ?>
	
	<th colspan="5" class='center'> Total Numerical Value <br />	Descriptive Grade</th>  					
</tr>


<!-------------------------- subcriteria row 2 for 3KPUP --------------------------------------------------------------------------------->

	<tr class="bold bg-blue2 darkgray">	
		<th colspan="<?php echo ($showcid)? '3':'2'; ?>" class='center'>&nbsp;</th>
			
	<?php 
		$colspan = 0;
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;
	?>
	
		<?php if($activities[$i]['subcriteria_id'] == @$activities[$j]['subcriteria_id']): ?>	<!-- different criteria_id,next cell for next criteria -->
			<?php $colspan += 1;	?>							
		<?php else: ?>
			<?php $colspan += 1;	?>					
			<th class='center' colspan="<?php echo $colspan; ?>">
				<?php if($editable): ?>				
					<a href="<?php echo URL.'scores/add/'.$course['id'].DS.$data['qtr'].DS.$activities[$i]['criteria_id'].DS.$activities[$i]['subcriteria_id']; ?>"  ><?php echo $activities[$i][SUBCRITERIA_HEAD];  ?></a>				
				<?php else: ?>	
					<?php echo $activities[$i]['subcriteria'];  ?>				
				<?php endif; ?>		
				<?php echo ($activities[$i]['is_raw'])? NULL:'(%)';  ?>  															<?php $colspan = 0; ?>
			</th>				
		<?php endif; ?>
	<?php endfor; ?>
	
		<th colspan="5">&nbsp;</th>				
	</tr>
	

<!--   ==================  Activity row 3 k12 ================================   ----------->	

<tr class='bg-blue2' > 
	<th>#</th>
	<?php echo ($showcid)? '<th>ID <br /> Number</th>' : NULL; ?>	
	<th>Student</th>


	<?php 
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;
	?>

		<td><?php echo $activities[$i]['activity'].'<br /> ('.round($activities[$i]['max_score']).') <br />'.date('M-d',strtotime($activities[$i]['activity_date'])); ?>
		<?php if($editable): ?>
			<br /><a href="<?php echo URL.'scores/edit/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Edit</a> | 
			<a onclick="return confirm('Warning! Cannot Un-Delete!');" href="<?php echo URL.'scores/delete/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Del</a>  
		<?php endif; ?>		
	<?php endfor; ?>	

		<td class="center"><br />Q1</td>
		<td class="center"><br />Q2</td>
		<td class="center"><br />Q3</td>
		<td class="center"><br />Q4</td>
		<td class="center"><br />Student</td>
			
		<?php if($locked_with_ranks): ?>
			<td class="center"><br />Rank</td>
		<?php endif; ?>				
			
</tr>	<!-- activity row 3 kpup -->

