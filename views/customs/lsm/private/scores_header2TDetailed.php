<?php 


$cri_colors=array(1=>'pink',2=>'green',3=>'violet',4=>'yellow');
$acts_arr=buildArray($activities,'criteria_id');
$acts_arr = array_unique($acts_arr, SORT_REGULAR);
$this->shovel('scores_headcolor');



?>


<tr class="bold white bg-blue3" >			<!-- criteria row 1 -->
	<th colspan="<?php echo ($showcid)? '3':'2'; ?>" class='center'>
		<?php echo $course['level'].'-'.$course['section'].'-'.$course['subject'].' <br /> '.$course['teacher']; ?>
		| <span class="" ><?php echo ($is_locked)? "Locked":"Open"; ?></span>		
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
			<th class="center <?php echo $clscolor; ?>" colspan="<?php echo $colspan; ?>">
				<?php // pr($clscolor); ?>
				<?php if($home=='teachers'): ?>
					<a href="<?php echo URL.'scores/add/'.$course['id'].DS.$data['qtr'].DS.$activities[$i]['criteria_id']; ?>"><?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?></a>
				<?php else: ?>
					<?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?>				
				<?php endif; ?>
				<?php echo ($activities[$i]['is_raw'])? NULL:' - Pct'; ?>									
				<?php $colspan = 0; ?>
			</th>				
			
		<?php endif; ?>

	<!-- endfor num_activities for criteria row 1 -->
	<?php endfor; ?>
	
	<!-- total numerical value,colspan 5 for Q1 to Q4,and current Qtr -->
	<?php $cs = isset($_GET['printout'])? 5:8; if($qtr>3){ $cs+=1; }  ?>
	<th  colspan="<?php echo $cs; ?>" class='center'> 
		Total Numerical Value <br />	Descriptive Grade </th>  
					
</tr>			<!-- criteria row 1 -->

	










