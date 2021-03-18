
<tr class="bold white bg-blue1" > 
	<th colspan="<?php echo ($showcid)? '3':'2'; ?>" class='center'>
		<?php echo $course['name'].' <br /> '.$course['teacher']; ?>	
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
				<?php echo ($activities[$i]['is_raw'])? NULL:' - Pct'; ?>									
				<?php $colspan = 0; ?>
			</th>				
			
		<?php endif; ?>

	<!-- endfor num_activities for criteria row 1 -->
	<?php endfor; ?>
	
	<!-- total numerical value column only  -->
	<th colspan="5" class="center"> Grades 	<?php if($is_k12): ?>	<br />	Descriptive Grade <?php endif; ?> </th>  
					
</tr>		<!--  hidden summary scores criteria row 1  -->

	

<!--   ================================================================================   ----------->	




<tr class='bg-blue2' > <!-- activity row 3nonkpup -->
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

		<!--   1 of 2 outcomes : cri equal,subcri equal -->
		<?php 	if($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ):  ?>
			<!-- activity name,max_score,edit | delete links -->
			
				<?php $subtotal 	+= $activities[$i]['max_score']; ?>
				<?php $hdmax += $activities[$i]['max_score']; ?>

		<!-- // 2nd outcome : different criteria  -->					
		<?php else: ?>			
				<?php  $subtotal 	 += $activities[$i]['max_score']; ?>
				<?php  $hdmax += $activities[$i]['max_score']; ?>
				<?php  $subtotal = 0; ?>			
			
			<td>Trns<br /><?php echo ($activities[$i]['is_raw'])? NULL : '(%)'; ?> </td>
			<td>PNV<br /><?php echo round($activities[$i]['weight']).'%'; ?></td>		<!-- partial numerical value -->			
			
	<?php endif; ?>
	
	<?php endfor; ?>	
	
			<td class="center"><br />Q1</td>
			<td class="center"><br />Q2</td>
			<td class="center"><br />Q3</td>
			<td class="center"><br />Q4</td>
			<td class="center vc200" ><br />Student</td>			
</tr>	<!-- activity row 3nonkpup -->