<tr class='bg-blue2' >
	<th>#</th>
	<?php echo ($showcid)? '<th>ID <br /> Number</th>' : NULL; ?>	
	<th class="tdscore" >Student</th>
	<!-- tempmax or criteria total -->
	<?php $subtotal   	=  0;  ?>
	<?php $hdmax =  0;  ?>
		
	<?php 
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;
	?>

		<!--   1 of 2 outcomes : cri equal,subcri equal -->
		<?php 	if($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ):  ?>
			<!-- activity name,max_score,edit | delete links -->
			<td class="tdscore" ><?php echo $activities[$i]['activity'].'<br /> ('.round($activities[$i]['max_score']).') <br />'.date('M-d',strtotime($activities[$i]['activity_date'])); ?>

			<?php if((!$is_locked) && ($teacher)): ?>			
				<a href="<?php echo URL.'scores/edit/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Edit</a> | 
				<a onclick="return confirm('Warning! Cannot Un-Delete!');" href="<?php echo URL.'scores/delete/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Del</a>  
			<?php endif; ?>	
				
				<?php $subtotal 	+= $activities[$i]['max_score']; ?>
				<?php $hdmax += $activities[$i]['max_score']; ?>
			</td>

		<!-- // 2nd outcome : different criteria  -->					
		<?php else: ?>					
			<td class="tdscore" ><?php echo $activities[$i]['activity'].'<br /> ('.round($activities[$i]['max_score']).') <br />'.date('M-d',strtotime($activities[$i]['activity_date']));  ?>			

			<?php if((!$is_locked) && ($teacher)): ?>			
				<a href="<?php echo URL.'scores/edit/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$data['qtr']; ?>">Edit</a> | 
				<a href="<?php echo URL.'scores/delete/'.$course['id'].DS.$activities[$i]['activity_id'].DS.$sy.DS.$qtr; ?>">Del</a>  			
			<?php endif; ?>

				<?php  $subtotal 	 += $activities[$i]['max_score']; ?>
				<?php  $hdmax += $activities[$i]['max_score']; ?>
			</td>
			<?php if(!$activities[$i]['is_single']): ?>
				<td class="tdscore" >Total <br /><?php echo '('.$subtotal.')'; $subtotal = 0; 
					// pr($activities[$i]);
				?></td>			
			
			<?php endif; ?>
			
			<td class="tdscore" ><?php echo $scores_trns; ?><br /><?php echo ($activities[$i]['is_raw'])? NULL : '(%)'; ?> </td>

			<td class="tdscore" ><?php echo $scores_pnv; ?>
				<br /><?php echo round($activities[$i]['weight']).'%'; ?></td>		<!-- partial numerical value -->			
			
	<?php endif; ?>
	
	<?php endfor; ?>	
	
			<td class="center tdscore"><br />Q1</td>
			<td class="center tdscore"><br />Q2</td>
			<td class="center tdscore"><br />Q3</td>
			<td class="center tdscore"><br />Q4</td>
			<td class="center tdscore"><?php echo $scores_tnv; ?><br />Q<?php echo $qtr; ?></td>			
			<td class="center tdscore"><?php echo $scores_raw; ?><br />Q<?php echo $qtr; ?></td>			
			<td class="center tdscore"><?php echo $scores_equiv; ?><br />Credits</td>			
			<?php if($qtr>3): ?>
				<th class="center tdscore" >Final<br />Ave</th>			
			<?php endif; ?>

			<?php if($is_locked && $with_score_ranks): ?>
				<td class="center tdscore"><br />Rank</td>
			<?php endif; ?>				
			
</tr>	<!-- activity row 3nonkpup -->
