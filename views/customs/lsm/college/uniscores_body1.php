

<style>

.ibox,.tdscore{ font-size:<?php echo $size.'em'; ?>;}
td.lightyellow{background:#ff9;}
td.bg-ivory{background:#f5f5f5;}
td.bg-darkivory{background:#fff;}
td.tdpnv{background:blue;}

</style>

<?php 


function base50($score,$max_score){ $x=($score/$max_score)*50+50; return $x; }




?>

<!-- $s iterator scores,or num_students -->
<tr><th class="tdscore" colspan="<?php echo $gender_colspan; ?>" >BOYS </th></tr>

<?php $ct=0; ?>
<?php for($s=0;$s<$num_students;$s++): ?>
<?php $ct++; ?>
<?php $t=$s+1; ?>
	<?php $r=$s-1;?>
	<?php $score=$scores[$s];?>

<?php $ns = count($score); ?>
<?php if($ns == $num_activities): ?>	
<tr>
	<td id="<?php echo 'scid:'.$students[$s]['scid'].' | gid:'.$students[$s]['gid']; ?>" 
		ondblclick="alert(this.id);" class="vcenter" ><?php echo ($ct); ?></td>
	<?php if($showucid): ?>
		<td><?php echo $students[$s]['studcode']; ?></td>
	<?php endif; ?>	
	<td class="tdscore vcenter" >
		<?php if($editable): ?>
			<a href='<?php echo URL."uniscoresManager/editScid/$crs/".$students[$s]['scid']; ?>' >
				<?php echo $students[$s]['student']; ?></a>				
		<?php else: ?>
			<?php echo $students[$s]['student']; ?>				
		<?php endif; ?>
				
	</td>
	
	<?php 
		$incomplete	= false; 				
		$temppct	= 0;		/* for transmute */
		$icri		= 0;
		$isub		= 0; 		/* num_subcriteria per criteria */
		$tnv		= 0;		/* sum of all pnv */
		$ftnv		= 0;		/* final tnv based on flrgr */
		$subtotal	= 0;	
		/* detailed */
		$tempmax 	= 0;		/* subtotal */
		$tempscore 	= 0;		/* subscore */				
		/* hybrid */
		$sg=0;
for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;		
		$max		= $score[$i]['max_score'];
		$scr		= $score[$i]['score'];
		$valid		= $score[$i]['is_valid'];
		$weight		= $score[$i]['weight'];
		$ratio		= $scr / $max *100;
		if($valid){ $subtotal	+= $ratio; } 
				

	?>

<!--  /* 1 of 2 outcomes : cri equal or not */   -->
<?php if($score[$i]['criteria_id'] == @$score[$j]['criteria_id']): ?>		
		
		
	<?php if($valid): ?>	<!-- valid -->
	<?php if($score[$i]['is_raw']==0): ?>	<!-- pct -->		
		<td class="colshading center tdscore <?php echo ($scr<($max/2))? " fail" : null; ?> <?php echo ($i%2)? 'bg-darkivory':'bg-ivory'; ?> " >
			<?php echo number_format($scr,$deciscores); echo '<br />'; ?>	
			<?php if($scr < ($max/2)){ $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++;} ?>
			<?php $isub++; ?>
			<?php $icri=$isub; ?>
			<?php 					
				$rg = base50($scr,$data['activities'][$i]['max_score']);
				$rg=number_format($rg,$deciscores);
				echo $rg;
				$sg+=$rg;
			?>
		</td>						
	<?php else: ?>		<!-- Detailed -->
			<?php $icri++; ?>
		
			<td class="colshading center tdscore <?php echo ($i%2)? 'bg-darkivory':'bg-ivory'; ?>
				<?php echo ($score[$i]['score']<($score[$i]['max_score']/2))?"fail":null; ?>" >
				<?php $rg = number_format($score[$i]['score'],$deciscores); ?>	
				<!-- add pass-fail counter -->
				<?php $scpct=$score[$i]['score']/$score[$i]['max_score']; ?>					
				<?php if($scpct<$ppct) { $data['activities'][$i]['failed']++;  }  
					else { $data['activities'][$i]['passed']++; }	?> 									
				<!-- add counters: 1) tempscore 2) tempmax  -->
				<?php $tempscore += $score[$i]['score']; ?>
				<?php $tempmax	 += $score[$i]['max_score']; ?>
				<?php 
					echo $rg; 
					$sg+=$rg;
				
				?>
			</td>	
	<?php endif; ?>		<!-- pct -->
	<?php else: ?>		<!-- valid -->
		<td class="center colshading bg-lightgreen" > - </td>
		<?php ?>
	<?php endif; ?>		<!-- valid -->

<?php else:	/* 2nd outcome : different criteria  */ ?>				
		<?php if($valid): ?>
		<?php if($score[$i]['is_raw']==0): ?>	<!-- pct -->		
		
			<td class="colshading center tdscore <?php echo ($scr < ($max/2))? 'fail' : null; ?> <?php echo ($i%2)? 'bg-darkivory':'bg-ivory'; ?> " >
				<?php echo number_format($scr,$deciscores); echo '<br />'; ?>	
				<!-- add pass-fail counter -->			
				<?php if($scr < ($max/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?>
				<?php $isub++; ?>
				<?php $icri=$isub; ?>
				<?php 
					$rg = (base50($scr,$data['activities'][$i]['max_score']));
					$rg=number_format($rg,$deciscores);
					echo $rg;
					$sg+=$rg;

				?>				
			</td>
		<?php else: ?>		<!-- pct Detailed -->
				<?php $icri++; ?>		
				<td class="colshading center tdscore <?php echo ($i%2)? 'bg-darkivory':'bg-ivory'; ?>
					<?php echo ($score[$i]['score'] < ($score[$i]['max_score']/2))? " fail" : null; ?>" >
					<?php $rg = number_format($score[$i]['score'],$deciscores); ?>	
					<!-- add pass-fail counter -->
					<?php $scpct=$score[$i]['score']/$score[$i]['max_score']; ?>					
					<?php if($scpct<$ppct) { $data['activities'][$i]['failed']++;  }  
						else { $data['activities'][$i]['passed']++; }	?> 									
					<!-- add counters: 1) tempscore 2) tempmax  -->
					<?php $tempscore += $score[$i]['score']; ?>
					<?php $tempmax	 += $score[$i]['max_score']; ?>
					<?php 
						echo $rg; 
						$sg+=$rg;
					
					?>
				</td>		
		<?php endif; ?>		<!-- pct -->			
		<?php else: ?>	<!-- valid -->
			<td class="center colshading bg-lightgreen" > - </td>			
		<?php endif; ?>		<!-- valid -->
				<?php $isub=0; ?>
						
		<!-- 1) add counter,2) getPct 3) summate pct,--> 			
		<?php 
			$icri=($icri>0)? $icri:1;		
			$tempmax=($tempmax>0)? $tempmax:1;		
			if($score[$i]['is_raw']==0){
				$trns=($sg/$icri); 
			} else if($score[$i]['is_raw']==2){
				$trns=($sg/$icri);
			} else {
				$trns = $tempscore/$tempmax*50+50;	
				$trns=number_format($trns,$deciscores);
			}
			
		?>
		
		<!-- total,trns,pnv -->		
		<?php if($sg>0): ?>		
			<td class="colshading center tdscore" > <?php echo $sg; ?></td>			
			<td class="colshading center tdscore lightyellow" > <?php 
				echo number_format($trns,$deciscores);			
			?> </td>
			<td class="colshading center tdscore bg-blue1" > 
			<?php 
				$pnv=round($trns)*$weight/100;				
				echo number_format($pnv,$decipnv);  				
				
			?> 			
			</td>
		<?php else: ?>		
			<?php $colspan=3; ?>
			<td colspan="<?php echo $colspan; ?>" class="colshading center bg-lightgreen" > 
			<?php $pnv = 0; ?>
			- </td>
		<?php endif; ?>
		
		<?php $sg=0; ?>			
			<!-- summate TNV -->
			<?php $tnv += $pnv;   ?>										
				<!-- re-initialize a) isub,b) temppct,d) tempscore,d) tempmax, -->						
				<?php 
					$icri=0; 
					$subtotal=0; 
					$tempscore=0; 
					$tempmax=0; 
									
				?>																									
<?php  endif;  ?>
<?php endfor; ?>		<!-- #end all activities of each student  -->


			<!-- TNV 1 -->
			<?php 			
				$ftnv=($tnv < $flrgr)? $flrgr : $tnv;							
				$ftnv=number_format($ftnv,$decicard);							
				$ftnv=($raw_transmute==2)? round($ftnv):$ftnv;
				$grade=$ftnv;
				$ge=$tnv;  
				$rdge=number_format($ge,$decicard);
				
			?>			
		<!-- cut column -->
		<!-- TNV col 1: grade credits -->
		
		<?php $credit=(int)$students[$s]['bonus']; ?>
		<?php if($is_locked): ?>
			<?php if($is_numeric): ?>	<!-- locked-numeric -->
				<td class="center" ><?php echo $rdge.'<br />'.($students[$s]['bonus']+0); ?></td>
				<th class="center vcenter" ><?php $grade=$students[$s]['grade']; echo $grade+0; ?></th>
			<?php else: ?>	<!-- locked-dg  -->
				<td class="center" ><?php echo $rdge; echo ($students[$s]['bonus']>0)? '<br .>'.$credit:NULL; ?></td>
				<th class="center vcenter" ><?php echo $students[$s]['dg']; ?></th>
			<?php endif; ?>	<!-- locked-numeric -->									
		<?php else: ?>	<!-- locked -->
			<?php include('uniscores_form.php'); ?>
		
		<?php endif; ?>	<!-- locked -->
		
			
		<!-- TNV col 2: db grade -->


</tr>


<?php else: ?>	


<tr>
	<td colspan="<?php echo $num_activities+$numcols; ?>" > Please update records of <a href="<?php echo URL.'unisync/scores/'.$course['id']; ?>" ><?php echo $students[$s]['studcode'].' - '.$students[$s]['student']; ?> </a> </td>
</tr>

<?php endif; ?>	

<?php if(isset($students[$t]['is_male']) && (($students[$s]['is_male']!=$students[$t]['is_male']))): ?>
	<?php $ct=0; ?>
	<tr><th class="tdscore" colspan="<?php echo $gender_colspan; ?>" >GIRLS</th></tr>
<?php endif; ?>

<?php endfor; ?> <!-- #data_students -->

<!----- Pass Fail Stats Below ------>

<tr>

<th class="tdscore" colspan="<?php echo ($showucid)? '3':'2'; ?>" > Passed <br /> <span class='red'>Failed </span></th>

	
	<?php 
		$activities = $data['activities'];
		for($i=0;$i<$num_activities;$i++):
		$j = $i+1;

	?>
		<!-- 1 of 2 outcomes : cri equal or not -->
		<?php if($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id']): ?>		
			<!-- PF column -->
			<th class='center tdscore' >
				<?php echo "P: ".$activities[$i]['passed']."<br />"; ?>
				<span class='red'><?php echo "F: ".$activities[$i]['failed']; ?></span>
			</th>				
						
		<?php else: ?>	<!-- different criteria_id,next cell for next criteria -->
			<!-- PF column -->
			<th class='center tdscore' >
				<?php echo "P: ".$activities[$i]['passed']."<br />"; ?>
				<span class='red'><?php echo "F: ".$activities[$i]['failed']; ?></span>
			</th>				
		
			<!-- colspan 3: total,trns,pnv -->
			<th colspan=3>&nbsp;</th>		
		<?php endif; ?>
				
	<?php endfor; ?>
		<!-- colspan 5 : Q1 to Q4,current TNV -->
		<th colspan=2 >&nbsp;</th>	
		
</tr>

