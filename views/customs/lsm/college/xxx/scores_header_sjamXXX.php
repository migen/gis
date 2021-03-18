
<?php 
$cri_colors=array(1=>'blue3',2=>'green',3=>'red',4=>'yellow');

$acts_arr=buildArray($activities,'criteria_id');
$acts_arr = array_unique($acts_arr, SORT_REGULAR);

function getColorByCriteria($cri,$cri_colors){
	switch($cri){
		case ($cri<5):return "bg-".$cri_colors[$cri];break;
		default:return "green";break;
	}
}	/* fxn */


?>



<tr class="bold white bg-blue1" >			<!-- criteria row 1 -->
	<th colspan="<?php echo ($showcid)? '3':'2'; ?>" class='center tdscore'>
		<?php echo $course['level'].'-'.$course['section'].'-'.$course['subject'].' <br /> '.$course['teacher']; ?>			
	</th>
	
	<?php
		$colspan = 0; 
		for($i=0;$i<$num_activities;$i++):
		$j = $i+1;
	?>
		<!--   // 1 of 2 outcomes : cri equal,subcri equal  -->
		<?php 	if($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ): ?>	
			<?php $colspan++; ?>
		<?php else: ?>	<!-- different criteria_id,next cell for next criteria -->
			<?php $colspan += 4;	?>		
			<?php $clscolor=getColorByCriteria($activities[$i]['criteria_id'],$cri_colors);  ?>			
			<?php $colspan=($activities[$i]['is_single']==1)? $colspan-=1:$colspan; ?>			
			<th class="red tdscore <?php echo $clscolor; ?> center" colspan="<?php echo $colspan; ?>">
			<?php 
					$sel=$activities[$i];					
					if($sel['is_raw']==0){ $prtcode='Pct'; }
					else if($sel['is_raw']==2){ $prtcode='Trns'; }
					else { $prtcode='Raw'; }
			
			?>
	<a href="<?php echo URL.'scores/add/'.$course['id'].DS.$data['qtr'].DS.$activities[$i]['criteria_id']; ?>">
		<?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?></a>

				<?php echo ' - '.$prtcode; // echo ($activities[$i]['is_raw'])? NULL:' - Pct';  ?>									
				<?php $colspan = 0; ?>
			</th>				
			
		<?php endif; ?>

	<!-- endfor num_activities for criteria row 1 -->
	<?php endfor; ?>
	
	<!-- total numerical value,colspan 5 for Q1 to Q4,and current Qtr -->
	<th colspan="<?php echo ($qtr>3)? 8:7; ?>" class='center tdscore'> Total Numerical Value <br />	Descriptive Grade</th>  
					
</tr>			<!-- criteria row 1 -->

	










