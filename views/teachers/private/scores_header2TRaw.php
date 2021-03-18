<?php 
$editable = (!$is_locked && $home=='teachers');


?>

<tr class="bold white bg-blue1" >
	<th colspan=3 class='center'>
		<?php echo $course['name'].'<br />'.$course['teacher']; ?>
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

	

<!--   ==================  Activity row for non kpup ================================   ----------->	


<tr class='bg-blue2' > 
	<th>#</th>
	<th>ID <br /> Number</th>
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
		<td class="center vc200" ><br />Student</td>			

		<?php if($locked_with_ranks): ?>
			<td class="center"><br />Rank</td>
		<?php endif; ?>				
			
</tr>	