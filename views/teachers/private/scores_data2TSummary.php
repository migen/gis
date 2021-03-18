<?php $numcols = ($showcid)? 10 : 9;  


$deciscores = $_SESSION['settings']['deciscores'];
$decigrades = $_SESSION['settings']['decigrades'];
$decipnv 	= $_SESSION['settings']['decipnv'];
$decitnv 	= $_SESSION['settings']['decitnv'];
$deciftnv 	= $_SESSION['settings']['deciftnv'];


?>


<!-- $s iterator scores,or num_students -->
<?php for($s=0;$s<$num_students;$s++): ?>
	<?php $score = $data['scores'][$s];?>
	<?php $rqg = 0;?>
<tr>

	<td><?php echo $s+1; ?></td>
	<?php if($showcid): ?>
		<td><?php echo $students[$s]['student_code']; ?></td>
	<?php endif; ?>	
	<td id="<?php echo 'GID: '.$students[$s]['gid'].' | '.$students[$s]['scid'].' : '.$students[$s]['student_code']; ?>" ondblclick="alert(this.id);" ><?php echo $students[$s]['student']; ?></td>		
		
	<?php 

		$hdtotal 	= 0;		// summaryscores or hd total
		$incomplete	= false; 
		
		$tempmax 	= 0;		// subtotal
		$tempscore 	= 0;		// subscore
		
		$temppct	= 0;		// for transmute
		$isub		= 0; 		// num_subcriteria per criteria
		$tnv		= 0;		// sum of all pnv
									
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;

	?>

		<!--  // 1 of 2 outcomes : cri equal or not   -->
		<?php if($score[$i]['criteria_id'] == @$score[$j]['criteria_id']): ?>		
		
		<!-- check score is_valid -->
		<?php if($score[$i]['is_valid']): ?>		
			<!-- score column -->				
				<!-- add pass-fail counter -->
				<?php if($score[$i]['score'] < ($score[$i]['max_score']/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?> 									
				<!-- add counters: 1) tempscore 2) tempmax  -->
				<?php $tempscore += $score[$i]['score']; ?>
				<?php $tempmax	 += $score[$i]['max_score']; ?>
				<?php $hdtotal += $score[$i]['score']; ?>
			
		<?php endif; ?>	<!-- if score is valid -->				
				
		<?php else:	// 2nd outcome : different criteria altogether ?>
		
		<?php if($score[$i]['is_valid']): ?>						
			<!-- score column -->					
				<!-- add pass-fail counter -->			
				<?php if($score[$i]['score'] < ($score[$i]['max_score']/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?> 										
				<!-- add counters: 1) tempscore 2) tempmax  -->
				<?php $tempscore += $score[$i]['score']; ?>
				<?php $tempmax   += $score[$i]['max_score']; ?>	
				<?php $hdtotal += $score[$i]['score']; ?>				
		<?php endif; ?>		<!-- if score is_valid -->
						
			<!-- total column -->								
				<!-- 1) add counter,2) getPct 3) summate pct,--> 			
			<?php if($tempmax != 0): ?>
				<?php $isub ++; ?>				
				<?php $pct 	    = $tempscore / $tempmax; ?>
				<?php $temppct += $pct; ?>
			<?php endif; ?>

			<!-- for summary or hd only -->
			<td class="colshading center" ><?php echo number_format($hdtotal,$deciscores); ?></td>
			
			
		<!--  TRNS columnn -->			
		<?php if($score[$i]['is_raw']): ?>
			<td class="colshading center <?php echo ($tempmax ==0)? 'bg-lightgreen' : null; ?>" > <?php if($tempmax == 0) { echo '-'; } else { $trns = transmutePct($temppct,$isub); echo number_format($trns,$deciscores); }   ?> </td>
		<?php else: ?>
			<td class="colshading center <?php echo ($tempmax ==0)? 'bg-lightgreen' : null; ?>" > <?php if($tempmax == 0) { echo '-'; } else { $trns = ($tempscore/$tempmax)*100; echo number_format($trns,$deciscores); }   ?> </td>
		<?php endif; ?>
			
			
			
			<!--  PNVcol -->			
			<td class="colshading center <?php echo ($tempmax ==0)? 'bg-lightgreen' : null; ?>" ><?php if($tempmax == 0) { $pnv = 0; echo '-'; $incomplete = true; } else { $pnv = $trns * $score[$i]['weight'] / 100; echo number_format($pnv,$deciscores); } ?></td>
			<!-- summate TNV -->
			<?php $tnv += $pnv;   ?>							
			
				<!-- re-initialize a) isub,b) temppct,d) tempscore,d) tempmax, -->						
				<?php $isub		 = 0; ?>
				<?php $temppct	 = 0; ?>
				<?php $tempscore = 0; ?>
				<?php $tempmax	 = 0; ?>
				<?php $hdtotal	 = 0; ?>
														
											
		<?php  endif;  ?>
	<?php endfor; ?>		<!-- #end all activities of each student  -->

			<td class="center colshading" ><?php echo number_format($students[$s]['q1'],$decigrades); 
				if($is_k12): echo '<br>'.$students[$s]['dg1']; endif; ?></td>					
			<td class="center colshading" ><?php echo number_format($students[$s]['q2'],$decigrades); 
				if($is_k12): echo '<br>'.$students[$s]['dg2']; endif; ?></td>					
			<td class="center colshading" ><?php echo number_format($students[$s]['q3'],$decigrades); 
				if($is_k12): echo '<br>'.$students[$s]['dg3']; endif; ?></td>					
			<td class="center colshading" ><?php echo number_format($students[$s]['q4'],$decigrades); 
				if($is_k12): echo '<br>'.$students[$s]['dg4']; endif; ?></td>					
			
			<td class="center colshading" ><?php echo $students[$s]['student']; ?></td>		
			<td class="hd center colshading" ><?php echo $students[$s]['scid']; ?></td>		
			<input type='hidden' name="data[Grade][<?php echo $s; ?>][gid]" value="<?php echo isset($students[$s]['gid'])? $students[$s]['gid'] : null; ?>" >			

</tr>
<?php endfor; ?> <!-- #data_students -->

<!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- -->
<!-- =-=-=-=-=-=-=-=-=-=-=- Pass Fail Stats Below =-=-=-=-=-=-=-=-=-=-=-=-=-=- -->




