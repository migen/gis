
<!-- k12 kpup -->


<tr class="bold bg-blue2" >		<!--  hidden summary scores criteria row 1  -->
	<th colspan="3" class='center'>
		<?php echo $course['name'].'<br />'.$course['teacher']; ?>
	</th>
	
	<?php
		for($i=0;$i<$num_activities;$i++):
		$j = $i+1;
	?>
		<!--  // 1 of 2 outcomes : 1) cri not equal,2) else -->
		<?php 	if($activities[$i]['criteria_id'] != @$activities[$j]['criteria_id']):	?>
	
			<!-- coslpan of 3: TRNS,PNV -->
			<th class="center" colspan="2">
				<?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?>
				<?php $colspan = 0; ?>
			</th>				
			
		<?php endif; ?>

	<!-- endfor num_activities for criteria row 1 -->
	<?php endfor; ?>
	
	<!-- total numerical value column only  -->
	<th colspan="5" class="center"> Grades 	<?php if($is_k12): ?>	<br />	Descriptive Grade <?php endif; ?> </th>  
					
</tr>		<!--  hidden summary scores criteria row 1  -->




<!--   ==================  Activity row 3 k12 ================================   ----------->	

<tr class='bg-blue2' > 
	<th>#</th>
	<th>ID <br /> Number</th>
	<th>Student</th>

<!----- ========================================================= ----------------->

		
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
			

		<?php 	// 2nd outcome : same criteria,different subcriteria
			elseif(
				($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] != @$activities[$j]['subcriteria_id'] )
			):
		?> 
						
					
		<?php else: ?>	<!-- 3rd outcome,next activity is a diff criteria -->
											
							
			<td>TRNS</td>
			<td>PNV<br /><?php echo number_format($activities[$i]['weight'],2).'%'; ?></td>		<!-- partial numerical value -->			
	<?php endif; ?>
	
	<?php endfor; ?>	
	
			<td class="center"><br />Q1</td>
			<td class="center"><br />Q2</td>
			<td class="center"><br />Q3</td>
			<td class="center"><br />Q4</td>
			<td class="center vc200" ><br />Student</td>			
			<td class="hd"><br />scid</td>
			
</tr>	<!-- activity row 3 kpup -->

