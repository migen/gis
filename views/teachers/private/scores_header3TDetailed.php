<?php 

?>

<!-- 3T kpup -->

<!-- criteria row 1,hd class for hiding row when showing summary -->
<tr class="bold white bg-blue1" >			
	<th colspan="<?php echo ($showcid)? '3':'2'; ?>" class='center'>
		<?php echo $course['level'].'-'.$course['section'].'-'.$course['subject'].' <br /> '.$course['teacher']; ?>			
	</th>
		
	<?php
		$colspan = 0; 
		for($i=0;$i<$num_activities;$i++):
		$j = $i+1;
	?>

		<?php 	// 1 of 3 outcomes : cri equal,subcri equal
			if(		
				($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] == @$activities[$j]['subcriteria_id'] )
			):
		?>	
			<?php $colspan++; ?>
		<?php 	// 2nd outcome : same criteria,different subcriteria
			elseif(
				($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] != @$activities[$j]['subcriteria_id'] )
			):
		?> 
			<?php $colspan += 3;	?>			
		<?php else: ?>	<!-- different criteria_id,next cell for next criteria -->
			<?php $colspan += 5;	?>					
			<th class='center' colspan="<?php echo $colspan; ?>">
				<?php if($editable): ?>
					<a href="<?php echo URL.'scores/add/'.$course['id'].DS.$qtr.DS.$activities[$i]['criteria_id']; ?>"><?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?></a>
				<?php else: ?>	
					<?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?>				
				<?php endif; ?>	
				<?php $colspan = 0; ?>
			</th>				
			
		<?php endif; ?>

	<!-- endfor num_activities for criteria row 1 -->
	<?php endfor; ?>
	
	<!-- total numerical value,colspan 5 for Q1 to Q4,and current Qtr -->
	<th colspan="8" class='center'> Total Numerical Value <br />	Descriptive Grade</th>  
					
</tr>			<!-- criteria row 1 -->


<!-------------------------- subcriteria row 2 for 3KPUP --------------------------------------------------------------------------------->

	<tr class="bold bg-blue2 darkgray">	
	<th colspan="<?php echo ($showcid)? '3':'2'; ?>" class='center'>&nbsp;</th>
			
	<?php 
		$colspan = 0;
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;
	?>
		<?php 	// 1 of 3 outcomes : cri equal,subcri equal
			if(		// compare cri-i to cri-j
				($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] == @$activities[$j]['subcriteria_id'] )
			):
		?>
			<?php $colspan++;	?>
		<?php 	// 2nd outcome : same criteria,different subcriteria
			elseif(
				($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] != @$activities[$j]['subcriteria_id'] )
			):
		?> 
			<?php $colspan += 3;	?>			
			<th colspan="<?php echo $colspan; ?>">
				<?php if($editable): ?>				
					<a href="<?php echo URL.'scores/add/'.$course['id'].DS.$qtr.DS.$activities[$i]['criteria_id'].DS.$activities[$i]['subcriteria_id']; ?>"  ><?php echo $activities[$i]['subcriteria'];  ?></a>				
				<?php else: ?>	
					<?php echo $activities[$i]['subcriteria'];  ?>				
				<?php endif; ?>		
				<?php echo ($activities[$i]['is_raw'])? NULL:'(%)';  ?>  														
				<?php $colspan = 0; ?>
			</th>				

		<?php 	// 3rd outcome
			else:
		?>	
			<?php $colspan +=5;	?>		
			<th colspan="<?php echo $colspan; ?>">
				<?php if($editable): ?>				
					<a href="<?php echo URL.'scores/add/'.$course['id'].DS.$qtr.DS.$activities[$i]['criteria_id'].DS.$activities[$i]['subcriteria_id']; ?>"  ><?php echo $activities[$i]['subcriteria'];  ?></a>				
				<?php else: ?>	<!-- if locked -->
					<?php echo $activities[$i]['subcriteria'];  ?>				
				<?php endif; ?>		<!-- if locked -->			
				 <?php echo ($activities[$i]['is_raw'])? NULL:'(%)';  ?>  														
				<?php $colspan = 0; ?>
			</th>				
					
		<?php endif; ?>  <!--  // compare cri-i to cri-j  -->
		
		
	<?php endfor; ?>	<!-- num_activities -->
	
		<th colspan="8">&nbsp;</th>		
	</tr>			<!-- subcriteria row 2 for 3KPUP -->


<!--   ==================  Activity row 3 k12 ================================   ----------->	

<tr class='bg-blue2' > 
	<th>#</th>
	<?php echo ($showcid)? '<th>ID <br /> Number</th>' : NULL; ?>	
	<th>Student</th>

<!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- -->


	<!-- tempmax or criteria total -->
	<?php $subtotal   	=  0;  ?>
	<?php $hdmax =  0;  ?>
		
	<?php 
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;
	?>

		<?php 	// 1 of 3 outcomes : cri equal,subcri equal
			if(		
				($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] == @$activities[$j]['subcriteria_id'] )
			):
		?>
			<!-- activity name,max_score,edit | delete links -->
			<td><?php echo $activities[$i]['activity'].'<br /> ('.round($activities[$i]['max_score']).') <br />'.date('M-d',strtotime($activities[$i]['activity_date'])); ?>

			<?php if(($editable) && ($teacher)): ?>
				<br /><a href="<?php echo URL.'scores/edit/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Edit</a> | 
				<a onclick="return confirm('Cannot Un-Delete!');" href="<?php echo URL.'scores/delete/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Del</a>  
			<?php endif; ?>
				
				<?php $subtotal 	+= $activities[$i]['max_score']; ?>
				<?php $hdmax += $activities[$i]['max_score']; ?>
			</td>

		<?php 	// 2nd outcome,case 2 : same criteria,different subcriteria
			elseif(
				($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] != @$activities[$j]['subcriteria_id'] )
			):
		?> 
			<td><?php echo $activities[$i]['activity'].'<br /> ('.round($activities[$i]['max_score']).' <br />'.date('M-d',strtotime($activities[$i]['activity_date'])); ?>

			<?php if((!$is_locked) && ($teacher)): ?>
				<a href="<?php echo URL.'scores/edit/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Edit</a> | 
				<a href="<?php echo URL.'scores/delete/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Del</a> 
			<?php endif; ?>
			
				<?php $subtotal 	+= $activities[$i]['max_score']; ?>
				<?php $hdmax += $activities[$i]['max_score']; ?>
			</td>
			<td>Total <br /><?php echo '('.$subtotal.')'; $subtotal = 0; ?></td>
			<td>Sub<br />Trns<br /><?php echo ($activities[$i]['is_raw'])? NULL:'(%)'; ?> </td>
										
		<?php else: ?>
					
			<td><?php echo $activities[$i]['activity'].'<br /> ('.round($activities[$i]['max_score']).') <br />'.date('M-d',strtotime($activities[$i]['activity_date']));  ?>

			<?php if((!$is_locked) && ($teacher)): ?>
				<a href="<?php echo URL.'scores/edit/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Edit</a> | 
				<a href="<?php echo URL.'scores/delete/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Del</a> 
			<?php endif; ?>
				
				<?php  $subtotal 	 += $activities[$i]['max_score']; ?>
				<?php  $hdmax += $activities[$i]['max_score']; ?>
				<?php // pr($activities[$i]); ?>				
			</td>
			<td>Total <br /><?php echo '('.$subtotal.')'; $subtotal = 0; ?></td>			
			<td>Sub<br />Trns<br /><?php echo ($activities[$i]['is_raw'])? NULL:'(%)'; ?> </td>
			
			<td><?php echo $scores_trns; ?></td>
			<td><?php echo $scores_pnv; ?><br />
				<?php echo number_format($activities[$i]['weight'],2).'%'; ?></td>		<!-- partial numerical value -->			
	<?php endif; ?>
	
	<?php endfor; ?>	
	
			<td class="center"><br />Q1</td>
			<td class="center"><br />Q2</td>
			<td class="center"><br />Q3</td>
			<td class="center"><br />Q4</td>
			<td class="center" ><br /><?php echo $scores_tnv; ?></td>			
			<td class="center" ><br /><?php echo $scores_raw; ?></td>			
			<td class="center" ><br /><?php echo $scores_equiv; ?></td>			
			<td class="center vc200" ><br />Student</td>		
			<?php if($is_locked && $with_score_ranks): ?>
				<td class="center"><br />Rank</td>
			<?php endif; ?>				
			
</tr>	<!-- activity row 3 kpup -->

