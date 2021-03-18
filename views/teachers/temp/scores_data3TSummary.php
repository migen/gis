
<!-- $s iterator scores,or num_students -->
<?php for($s=0;$s<$num_students;$s++): ?>
	<!-- init $rqq -->
	<?php $score = $data['scores'][$s];?>
	
<tr>

	<td><?php echo $s+1; ?></td>
	<td><?php echo $students[$s]['student_code']; ?></td>
	<td><?php echo $students[$s]['student']; ?></td>		
		
	<?php 

		$incomplete = false;	// to determine if TNV has value or not

		$crimax 	= 0;		// kpup max
		$subcrimax 	= 0;		// subcriteria max
		$subcriscore 	= 0;		// subscore
		
		$temppct	= 0;		// for transmute
		$isub		= 0; 		// num_subcriteria per criteria
		$tnv		= 0;		// sum of all pnv

		$subtrns	= 0;		// pctage of kpup-subcriteria - 1) raw,2) trns 
		$totaltrns	= 0;		// total of subtrns per kpup reset to zero
									
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;

	?>

		
		<?php 	// 1 of 3 outcomes : cri equal,subcri equal
			if(		
				($score[$i]['criteria_id'] == @$score[$j]['criteria_id'] ) &&
				($score[$i]['subcriteria_id'] == @$score[$j]['subcriteria_id'] )
			):
		?>		
		
		<!-- check score is_valid -->
		<?php if($score[$i]['is_valid']): ?>		
				<?php if($score[$i]['score'] < ($score[$i]['max_score']/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?> 																
				<?php $subcriscore   += $score[$i]['score']; ?>
				<?php $subcrimax	 += $score[$i]['max_score']; ?>
				<?php $crimax	 	 += $score[$i]['max_score']; ?>								
		<?php endif; ?> 		<!-- check score is_valid -->
		
		<?php 	// 2nd outcome / case 2: same criteria,different subcriteria
			elseif(
				($score[$i]['criteria_id'] == @$score[$j]['criteria_id'] ) &&
				($score[$i]['subcriteria_id'] != @$score[$j]['subcriteria_id'] )
			):
		?> 
		
		<?php if($score[$i]['is_valid']):  ?>				
			<!-- score column -->									
				<?php $subcriscore  += $score[$i]['score']; ?>
				<?php $subcrimax    += $score[$i]['max_score']; ?>				
				<?php $crimax   	+= $score[$i]['max_score']; ?>				
			
			<!-- subtotal column -->								
				<!-- 1) add counter,2) getPct 3) summate pct,4) re-initialize a) tempscore,b) tempmax -->
				<?php $isub ++; ?>
				<?php $pct 	    = $subcriscore / $subcrimax; ?>
				<?php $temppct  += $pct; ?>
				<?php $subcriscore = 0; ?>
				<?php $subcrimax	 = 0; ?>
				
			<!-- subtrns column -->	
				<?php	
					if($score[$i]['is_raw']){
						$subtrns 	+= transmute($pct,1);
						$totaltrns 	+= $subtrns;
						$subtrns = 0;	// reset subtrns = 0															
					} else {
						$subtrns 	+= $pct*100;
						$totaltrns 	+= $subtrns;
						$subtrns = 0;														
					}
				?>
				
		<?php endif; ?> <!-- not valid case 2 of 3 -->
				
		<?php else:	// 3nd outcome : different criteria altogether ?>
		
		<?php if($score[$i]['is_valid']): ?>						
			<?php $subcriscore  += $score[$i]['score']; ?>
			<?php $subcrimax    += $score[$i]['max_score']; ?>						 								
			<?php $crimax   	+= $score[$i]['max_score']; ?>						 								
		<?php endif; ?>	<!-- not valid case 3 of 3 -->
			
			
			<!-- total or subtotal column -->	
			<?php if($subcrimax != 0): ?>
				<?php $isub ++; ?>				
				<?php $pct 	    = $subcriscore / $subcrimax; ?>
				<?php $temppct += $pct; ?>
			<?php endif; ?>

			<!-- subtrns column -->	
			<?php 
				if($subcrimax!=0){
					if($score[$i]['is_raw']){
						$subtrns 	+= transmute($pct,1);
						$totaltrns 	+= $subtrns;
						$subtrns = 0;	// reset subtrns = 0								
					} else {
						$subtrns 	+= $pct*100;
						$totaltrns 	+= $subtrns;
						$subtrns = 0;														
					}				
				}
			?>
			
			<!--  TRNS columnn -->			
			<td class="colshading center <?php echo ($crimax==0)? 'bg-lightgreen' : null; ?>" > 
				<?php if($crimax==0) { echo '-'; } else {  $trns = $totaltrns/$isub; echo number_format($trns,SDECI);  }   ?>  
			</td>

			<!--  PNVcol -->			
			<td class="colshading center <?php echo ($crimax==0)? 'bg-lightgreen' : null; ?>" >
			<?php if($crimax==0) { $pnv = 0; echo '-'; $incomplete = true; } else { $pnv = $trns * $score[$i]['weight'] / 100; echo number_format($pnv,SDECI); } ?></td>
			
			<!-- reset crimax  -->
			<?php $crimax = 0; ?>
			
			<!-- summate TNV -->
			<?php $tnv += $pnv;   ?>							
			
				<!-- re-initialize a) isub,b) temppct,d) tempscore,d) tempmax, -->						
				<?php $totaltrns = 0; ?> 			<!-- reset trns -->
				<?php $isub		 = 0; ?>
				<?php $temppct	 = 0; ?>
				<?php $subcriscore = 0; ?>
				<?php $subcrimax	 = 0; ?>
																									
		<?php  endif;  ?>
	<?php endfor; ?>		<!-- #end all activities of each student  -->

	<td class="center colshading" ><?php echo number_format($students[$s]['q1'],GDECI); echo '<br />'; echo ($bonus)? number_format($students[$s]['bonus_q1'],GDECI): NULL; echo '<br />'; if($bonustotal){ $bt = $students[$s]['q1'] + $students[$s]['bonus_q1']; echo number_format($bt,BTDECI); echo '<br />';   } if($is_k12): echo '<br>'.$students[$s]['dg1']; endif; ?></td>					
	<td class="center colshading" ><?php echo number_format($students[$s]['q2'],GDECI); echo '<br />'; echo ($bonus)? number_format($students[$s]['bonus_q2'],GDECI): NULL; echo '<br />'; if($bonustotal){ $bt = $students[$s]['q2'] + $students[$s]['bonus_q2']; echo number_format($bt,BTDECI); echo '<br />';   } if($is_k12): echo '<br>'.$students[$s]['dg2']; endif; ?></td>					
	<td class="center colshading" ><?php echo number_format($students[$s]['q3'],GDECI); echo '<br />'; echo ($bonus)? number_format($students[$s]['bonus_q3'],GDECI): NULL; echo '<br />'; if($bonustotal){ $bt = $students[$s]['q3'] + $students[$s]['bonus_q3']; echo number_format($bt,BTDECI); echo '<br />';   } if($is_k12): echo '<br>'.$students[$s]['dg3']; endif; ?></td>					
	<td class="center colshading" ><?php echo number_format($students[$s]['q4'],GDECI); echo '<br />'; echo ($bonus)? number_format($students[$s]['bonus_q4'],GDECI): NULL; echo '<br />'; if($bonustotal){ $bt = $students[$s]['q4'] + $students[$s]['bonus_q4']; echo number_format($bt,BTDECI); echo '<br />';   } if($is_k12): echo '<br>'.$students[$s]['dg4']; endif; ?></td>					

	
	<td class="center" ><?php echo $students[$s]['student']; ?></td>		
	<td class="hd center colshading" ><?php echo $students[$s]['scid']; ?></td>		
	<input type='hidden' name="data[Grade][<?php echo $s; ?>][gid]" value="<?php echo isset($students[$s]['gid'])? $students[$s]['gid'] : null; ?>" >			
	
</tr>


<?php endfor; ?> <!-- #data_students -->

