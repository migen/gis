<?php 


// echo "detailed - is_transmuted:  $is_transmuted <br />";

// pr($students[0]);


$deciscores = $_SESSION['settings']['deciscores'];
$decigrades = $_SESSION['settings']['decigrades'];
$decipnv 	= $_SESSION['settings']['decipnv'];
$decitnv 	= $_SESSION['settings']['decitnv'];
$deciftnv 	= $_SESSION['settings']['deciftnv'];
$pg 		= $_SESSION['settings']['passing_grade'];



?>


<?php $numcols = ($showcid)? 10 : 9;  ?>

<?php $rank=1; ?>

<!-- $s iterator scores,or num_students -->
<?php for($s=0;$s<$num_scores;$s++): ?>
	<?php $r 	 = $s-1;?>	
	<?php $score = $data['scores'][$s];?>
	
<?php $ns = count($score); ?>
<?php if($ns == $num_activities): ?>	
	

<tr>

	<td><?php echo $s+1; ?></td>
	<?php if($showcid): ?>
		<td><?php echo $students[$s]['student_code']; ?></td>
	<?php endif; ?>		
	<td>
		<?php if($editable): ?>
		<a href="<?php echo URL.'scores/editStudent/'.$course['id'].DS.$students[$s]['scid'].DS.$sy.DS.$qtr; ?>" ><?php echo $students[$s]['student']; ?></a>
		<?php else: ?>
			<?php echo $students[$s]['student']; ?>				
		<?php endif; ?>
	</td>	
		
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
			<!-- score column -->				
			<td class="colshading center <?php echo ($score[$i]['score'] < ($score[$i]['max_score']/2))? " fail" : null; ?>" ><?php echo number_format($score[$i]['score'],$deciscores); ; ?> </td>
			<!-- add pass-fail counter -->
			<?php if($score[$i]['score'] < ($score[$i]['max_score']/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?> 									
			<!-- add counters: 1) tempscore 2) tempmax  --> 				
			<?php $subcriscore   += $score[$i]['score']; ?>
			<?php $subcrimax	 += $score[$i]['max_score']; ?>
			<?php $crimax	 	 += $score[$i]['max_score']; ?>
			
		<?php else: ?> <!-- not valid case 1 of 3 -->
			<td class="center colshading bg-lightgreen" > - </td>			
		<?php endif; ?>
		
		<?php 	// 2nd outcome : same criteria,different subcriteria
			elseif(
				($score[$i]['criteria_id']    == @$score[$j]['criteria_id'] ) &&
				($score[$i]['subcriteria_id'] != @$score[$j]['subcriteria_id'] )
			):
		?> 

		<?php if($score[$i]['is_valid']):  ?>				
			<!-- add counters: 1) tempscore 2) tempmax  -->				
			<?php $subcriscore  += $score[$i]['score']; ?>				
			<?php $subcrimax   	+= $score[$i]['max_score']; ?>				
			<?php $crimax   	+= $score[$i]['max_score']; ?>	
		
			<td class="colshading center <?php echo ($score[$i]['score'] < ($score[$i]['max_score']/2))? " fail" : null; ?>" ><?php echo number_format($score[$i]['score'],$deciscores);  ?> </td>	
		<?php else: ?>			
			<td class="center colshading bg-lightgreen" > -  </td>  
		<?php endif; ?> 

		<?php if($subcrimax>0):  ?>				
			<!-- 1) add counter,2) getPct 3) summate pct,4) re-initialize a) tempscore,b) tempmax -->
			<?php
				$pct = $subcriscore / $subcrimax; 
				$isub ++;				
			?>
			
			<?php $temppct  += $pct; ?>			
			<!-- add pass-fail counter -->			
			<?php if($score[$i]['score'] < ($score[$i]['max_score']/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?> 										
			<?php 
				if($score[$i]['is_raw']){
					$subtrns 	+= transmute($pct,1);
				} else { $subtrns 	+= $pct*100; }			
				$totaltrns 	+= $subtrns;
				
			?>
			
		<!-- subtotal & then subtrns column -->								
		<td class="colshading center"><?php echo $subcriscore; ?> </td>
		<td class="center vcenter colshading"  > <?php echo number_format($subtrns,$deciscores);  ?> </td>

		<?php else: ?>	<!-- if subscri==0,then empty subtotal and subtrans columns -->
			<td colspan="2" class="center colshading bg-lightgreen" > -  </td> 
		<?php endif; ?>

		<?php 
			$subcriscore   	= 0; 						
			$subcrimax	 	= 0; 
			$subtrns 		= 0; 
		?>
		
		<?php else:	// 3nd outcome : different criteria altogether ?>
		<?php if($score[$i]['is_valid']): ?>						
			<!-- score column -->					
			<td class="colshading center <?php echo ($score[$i]['score'] < ($score[$i]['max_score']/2))? 'fail' : null; ?>" ><?php echo number_format($score[$i]['score'],$deciscores); ?> </td>			
			<?php if($score[$i]['score'] < ($score[$i]['max_score']/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?> 										
			
			<!-- add counters: 1) tempscore 2) tempmax  -->				
			<?php $subcriscore += $score[$i]['score']; ?>
			<?php $subcrimax   += $score[$i]['max_score']; ?>						 										
			<?php $crimax      += $score[$i]['max_score']; ?>						 										
						
		<?php else: ?> <!-- not valid case 3 of 3 -->
			<td class="center colshading bg-lightgreen" > - </td>			
		<?php endif; ?>	<!-- not valid case 3 of 3 -->
			
			
			<!-- total or subtotal column -->	
			<td class="colshading center <?php echo ($subcrimax==0)? 'bg-lightgreen' : null; ?> " >
				<?php echo ($subcrimax==0)?  '-' : $subcriscore; ?>				
			</td>
				<!-- 1) add counter,2) getPct 3) summate pct,--> 			
			<?php if($subcrimax != 0): ?>
				<?php $isub ++; ?>				
				<?php $pct 	    = $subcriscore / $subcrimax; ?>
				<?php $temppct += $pct; ?>
			<?php endif; ?>

			<!-- subtrns column -->	
			<td class="center vcenter colshading <?php echo ($subcrimax ==0)? 'bg-lightgreen' : null; ?> "  >
				<?php 
					if($subcrimax==0):
						echo " - ";
					else:					
						if($score[$i]['is_raw']){
							$subtrns 	+= transmute($pct,1);
							$totaltrns 	+= $subtrns;
							echo number_format($subtrns,$deciscores);				
							$subtrns = 0;	// reset subtrns = 0								
						} else {
							$subtrns 	+= $pct*100;
							$totaltrns 	+= $subtrns;
							echo number_format($subtrns,$deciscores); 				
							$subtrns = 0;														
						}
					endif;
				?>
			</td>
			
			<!--  TRNS columnn -->			
			<td class="colshading center <?php echo ($crimax==0)? 'bg-lightgreen' : null; ?>" > 
				<?php if($crimax==0) { echo '-'; } else {  $trns = $totaltrns/$isub; echo number_format($trns,$deciscores);  }   ?>  						
			</td>

			<!--  PNVcol -->			
			<td class="colshading center <?php echo ($crimax==0)? 'bg-lightgreen' : null; ?>" >
			<?php if($crimax==0) { $pnv = 0; echo '-'; $incomplete = true; } else { $pnv = $trns * $score[$i]['weight'] / 100; echo number_format($pnv,$decipnv); } ?></td>
			
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
			
<td class="center colshading" ><?php echo number_format($students[$s]['q1'],$decigrades); 
 if($is_k12): echo '<br>'.$students[$s]['dg1']; endif; ?></td>					
<td class="center colshading" ><?php echo number_format($students[$s]['q2'],$decigrades); 
 if($is_k12): echo '<br>'.$students[$s]['dg2']; endif; ?></td>				
<td class="center colshading" ><?php echo number_format($students[$s]['q3'],$decigrades); 
 if($is_k12): echo '<br>'.$students[$s]['dg3']; endif; ?></td>				
<td class="center colshading" ><?php echo number_format($students[$s]['q4'],$decigrades); 
 if($is_k12): echo '<br>'.$students[$s]['dg4']; endif; ?></td>				 

			
			<!-- TNV -->
			<td class=" center colshading <?php echo ($incomplete)? 'bg-lightgreen' : null; ?> " >		
				<?php if($incomplete): echo number_format($tnv,$decigrades); else: ?>				
					<?php $ftnv = ($tnv < $flrgr)? $flrgr : $tnv; ?>
					<?php echo number_format($tnv,$decitnv); ?>
				<?php endif; ?>
				<br />		
				<?php if((!$is_k12) || ($incomplete) ): ?> &nbsp;
				<?php else : ?>
					<?php $rtnv = ($is_k12)? round($tnv) : $tnv;  ?>
					<?php echo rating($rtnv,$ratings);  ?>
				<?php endif; ?>
			</td>
			
			<!-- FTNV -->
			<td class="center colshading <?php echo ($incomplete)? 'bg-lightgreen' : null; ?> " >
				<?php if($incomplete): ?> <?php $ftnv = $flrgr; ?>  
				<?php endif; ?>
					<input class="vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][raw]" value="<?php echo number_format($ftnv,$deciftnv);  ?>" readonly />  					

<!-- so wont have any post-row for incomplete -->
<input type='hidden' name="data[Grade][<?php echo $s; ?>][gid]" value="<?php echo isset($students[$s]['gid'])? $students[$s]['gid'] : null; ?>" >			
<input type='hidden' name="data[Grade][<?php echo $s; ?>][scid]" value="<?php echo $students[$s]['scid']; ?>" >			
				
				<br />		
				<?php 
					if(isset($students[$s][$qqtr]) && $students[$s][$qqtr] != number_format($ftnv,2)) { $num_diff++; } ; 
				?>

			</td>

			
		<?php 
			$grade = ($_SESSION['settings']['eqvs'] && $is_transmuted)? equiv($ftnv,$equivs):$ftnv; 
			$ge = gradeEquiv($grade);
			
		?>							
			<td class="center vcenter <?php echo ($ge<$pg)? 'bg-red':NULL; ?> " >	
					<?php // echo $rtnv; ?>
					<?php // echo $ftnv; ?>
					<input class="vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][qqtr]" 
						value="<?php echo number_format($ge,0);  ?>" readonly />  								
					
				<?php if((!$is_k12) || ($incomplete) ): ?> &nbsp;
				<?php else : ?>
					<input class="vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][dg]" value="<?php echo rating($grade,$ratings);  ?>" readonly />  
				<?php endif; ?>					
 			</td>

			<td class="center colshading" >
				<?php if($editable): ?>
				<a href="<?php echo URL.'scores/editStudent/'.$course['id'].DS.$students[$s]['scid'].DS.$sy.DS.$qtr; ?>" ><?php echo $students[$s]['student']; ?></a>
				<?php else: ?>
					<?php echo $students[$s]['student']; ?>				
				<?php endif; ?>
			</td>		

				
			<?php if($is_locked && $with_score_ranks): ?>
				<?php if($students[$s]['q'.$qtr]<@$students[$r]['q'.$qtr]){ $rank++; }  ?>			
				<td class="center"><?php echo $rank; ?></td>
			<?php endif; ?>				
			
					
</tr>


<?php else: ?>	

<tr>
	<td colspan="<?php echo $num_activities+$numcols; ?>" > Please update records of <a href="<?php echo URL.'scores/editStudent/'.$course['id'].DS.$students[$s]['scid'].DS.$sy.DS.$qtr; ?>" ><?php echo $students[$s]['student_code'].' - '.$students[$s]['student']; ?> </a> </td>
</tr>

<?php endif; ?>	


<?php endfor; ?> <!-- #data_students -->

<!-- =========================== Pass Fail Stats Below =========================== -->

<tr>
<th colspan="<?php echo ($showcid)? '3':'2'; ?>" > Passed <br /> <span class='red'>Failed </span></th>
	
	<?php 
		// re-assign to pass the passed | failed index
		$activities = $data['activities'];
		for($i=0;$i<$num_activities;$i++):
		$j = $i+1;

	?>
		<?php 	// 1 of 3 outcomes : cri equal,subcri equal
			if(		
				($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] == @$activities[$j]['subcriteria_id'] )
			):
		?>		
			<!-- PF column -->
			<th class='center' >
				<?php echo "P: ".$activities[$i]['passed']."<br />"; ?>
				<span class='red'><?php echo "F: ".$activities[$i]['failed']; ?></span>
			</th>				
			
		<?php 	// 2nd outcome : same criteria,different subcriteria
			elseif(
				($activities[$i]['criteria_id']    == @$activities[$j]['criteria_id'] ) &&
				($activities[$i]['subcriteria_id'] != @$activities[$j]['subcriteria_id'] )
			):
		?> 
			<!-- PF column -->		
			<th class='center' >
				<?php echo "P: ".$activities[$i]['passed']."<br />"; ?>
				<span class='red'><?php echo "F: ".$activities[$i]['failed']; ?></span>
			</th>				
			<!-- colspan 2 for subtotal & subtrns column -->
			<th colspan="2" >&nbsp; </th>
			
		<?php else: ?>	<!-- different criteria_id,next cell for next criteria -->
			<!-- PF column -->
			<th class='center' >
				<?php echo "P: ".$activities[$i]['passed']."<br />"; ?>
				<span class='red'><?php echo "F: ".$activities[$i]['failed']; ?></span>
			</th>				
		
			<!-- colspan 4: total,trns,pnv -->
			<th colspan="4" >&nbsp;</th>		
		<?php endif; ?>
				
	<?php endfor; ?>
		<!-- colspan 5 : Q1 to Q4,current TNV -->
		<th colspan="8">&nbsp;</th>	
		<?php if($is_locked && $with_score_ranks): ?>
			<td>&nbsp;</td>
		<?php endif; ?>				


		
</tr>



