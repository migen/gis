<style>
.tdscore{ font-size:<?php echo $size.'em'; ?>;}
</style>


<?php 
// echo "is_transmuted:  $is_transmuted <br />";


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

<?php include('headrow.php'); ?>

<?php for($s=0;$s<$num_scores;$s++): ?>


	<?php $r 	 = $s-1;?>
	<?php $score = $scores[$s];?>

<?php $ns = count($score); ?>
<?php if($ns == $num_activities): ?>	
<tr>

	<td id="<?php echo 'scid:'.$students[$s]['scid'].' | gid:'.$students[$s]['gid']; ?>" ondblclick="alert(this.id);" ><?php echo $s+1; ?></td>
	<?php if($showcid): ?>
		<td><?php echo $students[$s]['student_code']; ?></td>
	<?php endif; ?>	
	<td>
		<?php if($editable): ?>
			<a href='<?php echo URL."scores/editStudent/$course_id/".$students[$s]['scid']."/$sy/$qtr"; ?>' >
				<?php echo $students[$s]['student']; ?></a>				
		<?php else: ?>
			<?php echo $students[$s]['student']; ?>				
		<?php endif; ?>
				
	</td>

	
	<?php 
		$incomplete	= false; 

		if(@$score[$i]['is_raw']==1){	/* raw */
			$tempmax 	= 0;		/* subtotal */
			$tempscore 	= 0;		/* subscore */			
			$temppct	= 0;		/* for transmute */
			$isub		= 0; 		/* num_subcriteria per criteria */
			$tnv		= 0;		/* sum of all pnv */
			$ftnv		= 0;		/* final tnv based on flrgr */
		
		} else {	/* pct */
			$temppct	= 0;		/* for transmute */
			$icri		= 0;
			$isub		= 0; 		/* num_subcriteria per criteria */
			$tnv		= 0;		/* sum of all pnv */
			$ftnv		= 0;		/* final tnv based on flrgr */
			$subtotal	= 0;
			
		}
	
	
	
		
		
									
for($i=0;$i<$num_activities;$i++): 

	if(@$score[$i]['is_raw']!=1){	/* raw */
		$max		= $score[$i]['max_score'];
		$scr		= $score[$i]['score'];
		$valid		= $score[$i]['is_valid'];
		$weight		= $score[$i]['weight'];
		$ratio		= $scr / $max *100;
		echo "pct <br />";
	} else {
		echo "raw";
	}
	

		$j = $i+1;		
		$max		= $score[$i]['max_score'];
		$scr		= $score[$i]['score'];
		$valid		= $score[$i]['is_valid'];
		$weight		= $score[$i]['weight'];
		$ratio		= $scr / $max *100;

		if($valid){ $subtotal	+= $ratio; } 
		// $subtotal	+= $ratio; 
		
		

	?>

<!--  /* 1 of 2 outcomes : cri equal or not */   -->
<?php if($score[$i]['criteria_id'] == @$score[$j]['criteria_id']): ?>		
		
		<?php if($valid): ?>		
			<td class="colshading center tdscore <?php echo ($scr < ($max/2))? " fail" : null; ?>" >
				<?php 
					// pr($score[$i]);
				?>
				<?php echo number_format($scr,$deciscores); ?>	
				<?php if($scr < ($max/2)){ $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++;} ?>
				<?php $isub++; ?>
				<?php $icri=$isub; ?>
			</td>			
		<?php else: ?>		
			<td class="center colshading bg-lightgreen" > - </td>
			<?php ?>
		<?php endif; ?>	
				
<?php else:	/* 2nd outcome : different criteria  */ ?>		
		<?php if($valid): ?>
			<td class="colshading center tdscore <?php echo ($scr < ($max/2))? 'fail' : null; ?>" ><?php echo number_format($scr,$deciscores); ?>		
				<!-- add pass-fail counter -->			
				<?php if($scr < ($max/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?>
				<?php $isub++; ?>
				<?php $icri=$isub; ?>
			</td>			
		<?php else: ?>
			<td class="center colshading bg-lightgreen" > - </td>			
		<?php endif; ?>		<!-- if score is_valid -->
				<?php $isub=0; ?>
						
		<!-- 1) add counter,2) getPct 3) summate pct,--> 			
		<?php 
			if($icri != 0){
				$trns	  = $subtotal/$icri;
			} else {
				$subtotal 	= 0;
				$trns		= 0;
				$incomplete = true;
			}			 
								
								
		?>

		
		<!-- total,trns,pnv -->
		<?php if($subtotal>0): ?>		
			<td class="colshading center tdscore" > <?php echo number_format($subtotal,$deciscores); ?> </td>
			<td class="colshading center tdscore" > <?php echo number_format($trns,$deciscores);   ?> </td>
			<td class="colshading center tdscore" > <?php $pnv = $trns * $weight / 100; echo number_format($pnv,$decipnv);  ?> 			
			</td>
		<?php else: ?>		
			<td colspan="3" class="colshading center bg-lightgreen" > 
			<?php $pnv = 0; ?>
			- </td>
		<?php endif; ?>
			
			<!-- summate TNV -->
			<?php $tnv += $pnv;   ?>							
			
				<!-- re-initialize a) isub,b) temppct,d) tempscore,d) tempmax, -->						
				<?php // $isub		 	 = 0; ?>
				<?php $icri		 	 = 0; ?>
				<?php $subtotal		 = 0; ?>

														
											
<?php  endif;  ?>
<?php endfor; ?>		<!-- #end all activities of each student  -->



			<td class="center colshading tdscore" ><?php echo number_format($students[$s]['q1'],$decigrades);  
				if($is_k12): echo '<br>'.$students[$s]['dg1']; endif; ?></td>							
			
			<td class="center colshading tdscore" ><?php echo number_format($students[$s]['q2'],$decigrades); 
				if($is_k12): echo '<br>'.$students[$s]['dg2']; endif; ?></td>					
			
			<td class="center colshading tdscore" ><?php echo number_format($students[$s]['q3'],$decigrades);  
				if($is_k12): echo '<br>'.$students[$s]['dg3']; endif; ?></td>					

			<td class="center colshading tdscore" ><?php echo number_format($students[$s]['q4'],$decigrades); 
				if($is_k12): echo '<br>'.$students[$s]['dg4']; endif; ?></td>					

			
			<!-- TNV -->
			<td class="center vcenter colshading tdscore <?php echo ($incomplete)? 'bg-lightgreen' : null; ?> " ><br />
				<?php if($incomplete): ?> - <?php else: ?>				
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
			<td class="center vcenter colshading tdscore <?php echo ($incomplete)? 'bg-lightgreen' : null; ?> " >
				<?php // echo $rtnv; ?>
				<?php if($incomplete): ?> - <?php else: ?>				
					<input class="vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][raw]" 
						value="<?php echo number_format($ftnv,$deciftnv);  ?>" readonly />  
		<!-- so wont have any post-row for incomplete -->
<input type='hidden' name="data[Grade][<?php echo $s; ?>][gid]" value="<?php echo isset($students[$s]['gid'])? $students[$s]['gid'] : null; ?>" >			

<input type='hidden' name="data[Grade][<?php echo $s; ?>][scid]" value="<?php echo $students[$s]['scid']; ?>" >			
					
				<?php endif; ?>
				<br />		
				<?php 
					if(isset($students[$s][$qqtr]) && $students[$s][$qqtr] != number_format($ftnv,2)) { $num_diff++; } ; 
				?>
			</td>

		<?php 
			$ftnv = number_format($ftnv,2);
			$grade = ($_SESSION['settings']['eqvs'] && $is_transmuted)? equiv($ftnv,$equivs):$ftnv; 
			$ge = gradeEquiv($grade);  
		?>							
			<td class="center vcenter <?php echo ($ge<$pg)? 'bg-red':NULL; ?> " ><br />
				<?php $credit = $students[$s]['bonus_q'.$qtr]; ?>
			
					<input class="vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][qqtr]" 
						value="<?php echo number_format($ge,0);  ?>" readonly />  								
					
	
				<input class="vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][dg]" 
					value="<?php echo rating($grade,$ratings);  ?>" readonly />  
				<input class="vc50 center <?php echo ($credit<0)? 'bg-pink':null; 
					echo ($credit>0)? 'bg-lightgreen':null; ?>" name="data[Grade][<?php echo $s; ?>][bonus]" 
					value="<?php echo $students[$s]['bonus_q'.$qtr];  ?>" />										
			</td>

			
			<td class="center colshading" >
				<?php if($editable): ?>
					<a href='<?php echo URL."scores/editStudent/$course_id/".$students[$s]['scid']."/$sy/$qtr"; ?>' >
						<?php echo $students[$s]['student']; ?></a>
				<?php else: ?>
					<?php echo $students[$s]['student']; ?>				
				<?php endif; ?>
			</td>		

<?php if($qtr==4): ?> <!-- if Q4 -->			
		<?php 
			$sumave=0; 
			for($k=1;$k<$qtr;$k++){ 
				$sumave+=number_format($students[$s]['q'.$k],$decigrades);
			}
			$sumave+=number_format($ge,$decigrades);
			$ave=$sumave/$qtr;

		?>				
		<td>
			<input class="vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][ave]" 
				value="<?php echo number_format($ave,$decigrades);  ?>" readonly />	
			<input class="vc50 center" name="data[Grade][<?php echo $s; ?>][dgave]" 
				value="<?php echo rating($ave,$ratings);  ?>" readonly /> 													
		</td>
<?php endif; ?> <!-- if Q4 -->			
			
			
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

<!-- -------------------------------------- Pass Fail Stats Below ------------------------------------- -->

<tr>

<th colspan="<?php echo ($showcid)? '3':'2'; ?>" > Passed <br /> <span class='red'>Failed </span></th>

	
	<?php 
		// re-assign to pass the passed | failed index
		$activities = $data['activities'];
		for($i=0;$i<$num_activities;$i++):
		$j = $i+1;

	?>
		<!-- 1 of 2 outcomes : cri equal or not -->
		<?php if($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id']): ?>		
			<!-- PF column -->
			<th class='center' >
				<?php echo "P: ".$activities[$i]['passed']."<br />"; ?>
				<span class='red'><?php echo "F: ".$activities[$i]['failed']; ?></span>
			</th>				
						
		<?php else: ?>	<!-- different criteria_id,next cell for next criteria -->
			<!-- PF column -->
			<th class='center' >
				<?php echo "P: ".$activities[$i]['passed']."<br />"; ?>
				<span class='red'><?php echo "F: ".$activities[$i]['failed']; ?></span>
			</th>				
		
			<!-- colspan 3: total,trns,pnv -->
			<th colspan=3>&nbsp;</th>		
		<?php endif; ?>
				
	<?php endfor; ?>
		<!-- colspan 5 : Q1 to Q4,current TNV -->
		<th colspan="8">&nbsp;</th>	
		<?php if($is_locked && $with_score_ranks): ?>
			<td>&nbsp;</td>
		<?php endif; ?>				
		
</tr>

