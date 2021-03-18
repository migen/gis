
<style>

.ibox,.tdscore{ font-size:<?php echo $size.'em'; ?>;}
td.lightyellow{background:#ff9;}
td.bg-ivory{background:#f5f5f5;}
td.bg-darkivory{background:#fff;}
td.tdpnv{background:blue;}
</style>

<?php 

// pr('activities');
// pr($activities);
// echo "<hr />";
// pr('scores');
// pr($scores[0]);
// exit;

function base50($score,$max_score){
	$x=($score/$max_score)*50+50;
	return $x;
}

// echo "-is_transmuted:  $is_transmuted <br />";

$deciscores=$_SESSION['settings']['deciscores'];
$decicard=$_SESSION['settings']['decicard'];
$deciave=$_SESSION['settings']['deciave'];
$decipnv=$_SESSION['settings']['decipnv'];
$decitnv=$_SESSION['settings']['decitnv'];
$deciftnv=$_SESSION['settings']['deciftnv'];
$pg=$_SESSION['settings']['passing_grade'];
$show_dg=($with_dg)? NULL:"hidden";
$numcols = ($showcid)? 10 : 9;  $rank=1; 
$is_num=($course['is_num']==1)? true:false;

function rating1($x){
	pr($x);
}

?>

<!-- $s iterator scores,or num_students -->

<?php include('scores_activities.php'); ?>


<tr><th class="tdscore" colspan="<?php echo $gender_colspan; ?>" >BOYS </th></tr>

<?php $ct=0; ?>
<?php for($s=0;$s<$num_scores;$s++): ?>
<?php $ct++; ?>
<?php $t=$s+1; ?>
	<?php $r 	 = $s-1;?>
	<?php $score = $scores[$s];?>

<?php $ns = count($score); ?>
<?php if($ns == $num_activities): ?>	
<tr>

	<td id="<?php echo 'scid:'.$students[$s]['scid'].' | gid:'.$students[$s]['gid']; ?>" ondblclick="alert(this.id);" >
		<?php echo ($ct); ?></td>
	<?php if($showcid): ?>
		<td><?php echo $students[$s]['student_code']; ?></td>
	<?php endif; ?>	
	<td class="tdscore" >
		<?php if($editable): ?>
			<a href='<?php echo URL."scores/editStudent/$course_id/".$students[$s]['scid']."/$sy/$qtr"; ?>' >
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
			<?php // pr($i); pr($score[$i]); ?>
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
			<?php if(!$score[$i]['is_single']): ?>
				<td class="colshading center tdscore" > <?php echo $sg; ?></td>			
			<?php endif; ?>
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
			<?php $colspan=(!$score[$i]['is_single'])? 3:2; ?>
			<td colspan="<?php echo $colspan; ?>" class="colshading center bg-lightgreen" > 
			<?php $pnv = 0; ?>
			- </td>
		<?php endif; ?>
		
		<?php $sg=0; ?>
			
			<!-- summate TNV -->
			<?php $tnv += $pnv;   ?>							
			
				<!-- re-initialize a) isub,b) temppct,d) tempscore,d) tempmax, -->						
				<?php 
					$icri = 0; 
					$subtotal = 0; 
					$tempscore = 0; 
					$tempmax = 0; 
									
				?>

														
											
<?php  endif;  ?>
<?php endfor; ?>		<!-- #end all activities of each student  -->



<td class="center colshading tdscore" ><?php echo number_format($students[$s]['q1'],$decicard);  ?></td>
<td class="center colshading tdscore" ><?php echo number_format($students[$s]['q2'],$decicard);  ?></td>
<td class="center colshading tdscore" ><?php echo number_format($students[$s]['q3'],$decicard);  ?></td>
<td class="center colshading tdscore" ><?php echo number_format($students[$s]['q4'],$decicard);  ?></td>

			<!-- TNV 1 -->
			<?php 			
				$ftnv = ($tnv < $flrgr)? $flrgr : $tnv;							
				$ftnv = number_format($ftnv,$decicard);							
				$ftnv = ($raw_transmute==2)? round($ftnv):$ftnv;
				$grade = ($_SESSION['settings']['eqvs'] && $is_transmuted)? equiv($ftnv,$equivs):$ftnv; 			
				$ge = $tnv;  
				$qdg=($with_dg)? rating($grade,$ratings):NULL; 				
			?>
			<td class="center colshading tdscore <?php echo ($incomplete)? 'bg-lightgreen' : null; ?> " >
				<?php if($incomplete): ?> - <?php else: ?>	
					<?php echo number_format($tnv,$decitnv); ?>
				<?php endif; ?>
				<?php if((!$with_dg) || ($incomplete) ): ?> 
				<?php else : ?>
					<?php echo $qdg;  ?>
				<?php endif; ?>				
			</td>

			
			<!-- Raw 2 -->
			<td class="center colshading <?php echo ($incomplete)? 'bg-lightgreen' : null; ?> " >
				<?php if($incomplete): ?> - <?php else: ?>				
					<input class="ibox vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][raw]" 
						value="<?php echo number_format($ftnv,$deciftnv);  ?>" readonly />  
		<!-- so wont have any post-row for incomplete -->
<input type='hidden' name="data[Grade][<?php echo $s; ?>][gid]" value="<?php 
	echo isset($students[$s]['gid'])? $students[$s]['gid'] : null; ?>">
<input type='hidden' name="data[Grade][<?php echo $s; ?>][scid]" value="<?php echo $students[$s]['scid']; ?>" >
				<?php endif; ?> &nbsp; 
				<?php 
					if(isset($students[$s][$qqtr]) && $students[$s][$qqtr] != number_format($ftnv,2)) { $num_diff++; } ; 
				?>
			</td>

		<!-- FTNV 3 Grade Credits -->
			<?php $credit = $students[$s]['bonus_q'.$qtr]; ?>
			<td class="center  <?php echo ($ge<$pg)? 'bg-red':NULL; ?> " >
					<input class="ibox vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][qqtr]" 
						value="<?php echo number_format($ge,0);  ?>" readonly />  								
					<input class="ibox vc50 center" type="<?php echo $show_dg; ?>" name="data[Grade][<?php echo $s; ?>][dg]" 
						value="<?php echo $qdg;  ?>" readonly />
					<input class="ibox vc50 center <?php echo ($credit<0)? 'bg-pink':null; echo ($credit>0)? 'bg-lightgreen':null; ?>" name="data[Grade][<?php echo $s; ?>][bonus]" 
						value="<?php echo $students[$s]['bonus_q'.$qtr];  ?>" />						
				
			</td>
			

			

<?php if($qtr==4): ?> <!-- if Q4 -->			
		<?php
					
			$sumave=0; 
			for($k=1;$k<=$qtr;$k++){ 
				$sumave+=number_format($students[$s]['q'.$k],$decicard);
			}			
			if($is_shs){ $sumave=number_format($students[$s]['q3'],$decicard)+number_format($students[$s]['q4'],$decicard); }
			
			$ave=(!$is_shs)? ($sumave/$qtr):($sumave/2);
			$rave=round($ave,$deciave);			
			

		?>				
		<td class="vcenter" >
			<?php 
			
			?>			
			
			<input class="vc50 center" type="text" name="data[Grade][<?php echo $s; ?>][ave]" 
				value="<?php echo $rave;  ?>" readonly />	
			<input class="vc50 center" name="data[Grade][<?php echo $s; ?>][dgave]" type="<?php echo (!$is_num)? 'text':'hidden'; ?>"
				value="<?php echo (!$is_num)? rating($rave,$ratings):"";  ?>" readonly /> 													
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

<?php if(isset($students[$t]['is_male']) && (($students[$s]['is_male']!=$students[$t]['is_male']))): ?>
	<?php $ct=0; ?>
	<tr><th class="tdscore" colspan="<?php echo $colspan; ?>" >GIRLS</th></tr>
<?php endif; ?>

<?php endfor; ?> <!-- #data_students -->

<!-- -------------------------------------- Pass Fail Stats Below ------------------------------------- -->

<tr>

<th class="tdscore" colspan="<?php echo ($showcid)? '3':'2'; ?>" > Passed <br /> <span class='red'>Failed </span></th>

	
	<?php 
		// re-assign to pass the passed | failed index
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
		<th colspan="7">&nbsp;</th>	
		<?php if($is_locked && $with_score_ranks): ?>
			<td>&nbsp;</td>
		<?php endif; ?>				
		
</tr>

