
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


<!-- criteria row one -->
<tr class="bold white bg-blue1" >			
	<th colspan="<?php echo ($showucid)? '3':'2'; ?>" class='center tdscore'>
		<?php echo $course['name'].'<br /> '.$course['teacher']; ?>			
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
			<th class="red tdscore <?php echo $clscolor; ?> center" colspan="<?php echo $colspan; ?>">
			<?php 
					$sel=$activities[$i];					
					if($sel['is_raw']==0){ $prtcode=' - Pct'; }
					else if($sel['is_raw']==2){ $prtcode='-Trns'; }
					else { $prtcode=''; }
			
			?>
	<a href="<?php echo URL.'uniscores/add/'.$course['id'].DS.$activities[$i]['criteria_id']; ?>">
		<?php echo $activities[$i]['criteria'].' <br /> '.round($activities[$i]['weight']).'%';  ?></a>

				<?php echo $prtcode;   ?>									
				<?php $colspan = 0; ?>
			</th>							
		<?php endif; ?>

	<!-- endfor num_activities for criteria row 1 -->
	<?php endfor; ?>
	
	<th colspan="<?php echo 2; ?>" class='center tdscore'> Total </th>  
					
</tr>			<!-- criteria row 1 -->

	
<!---- header row two --->
<tr class='bg-blue2' >
	<th>#</th>
	<?php echo ($showucid)? '<th>ID <br /> Number</th>' : NULL; ?>	
	<th class="tdscore" >Student</th>
	<!-- tempmax or criteria total -->
	<?php $subtotal   	=  0;  ?>
	<?php $hdmax =  0;  ?>
		
	<?php 
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;
	?>

		<!--   1 of 2 outcomes : cri equal,subcri equal -->
		<?php 	if($activities[$i]['criteria_id'] == @$activities[$j]['criteria_id'] ):  ?>
			<td class="tdscore" ><?php echo $activities[$i]['activity'].'<br /> ('.round($activities[$i]['max_score']).') <br />'.date('M-d',strtotime($activities[$i]['date'])); ?>
			<?php if(!$is_locked): ?>			
				<br /><a href="<?php echo URL.'uniscoresManager/edit/'.$activities[$i]['aid']; ?>">Edit</a> | 
				<a onclick="return confirm('Warning! Cannot Un-Delete!');" href="<?php echo URL.'uniscoresManager/delete/'.$activities[$i]['aid']; ?>">Del</a>  
			<?php endif; ?>					
				<?php $subtotal+=$activities[$i]['max_score']; ?>
				<?php $hdmax+=$activities[$i]['max_score']; ?>
			</td>

		<!-- // 2nd outcome : different criteria  -->					
		<?php else: ?>					
			<td class="tdscore" ><?php echo $activities[$i]['activity'].'<br /> ('.round($activities[$i]['max_score']).') <br />'.date('M-d',strtotime($activities[$i]['date']));  ?>			
			<?php if(!$is_locked): ?>			
				<br /><a href="<?php echo URL.'uniscoresManager/edit/'.$activities[$i]['aid']; ?>">Edit</a> | 
				<a href="<?php echo URL.'uniscoresManager/delete/'.$activities[$i]['aid']; ?>">Del</a>  			
			<?php endif; ?>

				<?php  $subtotal+=$activities[$i]['max_score']; ?>
				<?php  $hdmax+=$activities[$i]['max_score']; ?>
			</td>
			<td class="tdscore" >Total<br /><?php echo '('.$subtotal.')'; $subtotal = 0; ?></td>						
			<td class="tdscore" >TRNS<br /><?php echo ($activities[$i]['is_raw'])? NULL : '(%)'; ?> </td>
			<td class="tdscore" >PNV<br /><?php echo round($activities[$i]['weight']).'%'; ?></td>	<!-- PNV -->
	<?php endif; ?>
	
	<?php endfor; ?>		
			<td class="center tdscore">TNV<?php if($is_numeric): ?><br />Credits<?php endif; ?></td>			
			<td class="center tdscore">Grade</td>			
</tr>	<!-- activity row  -->










