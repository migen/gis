<?php 

$deciscores = $_SESSION['settings']['deciscores'];
$decigrades = $_SESSION['settings']['decigrades'];
$decipnv 	= $_SESSION['settings']['decipnv'];
$decitnv 	= $_SESSION['settings']['decitnv'];
$deciftnv 	= $_SESSION['settings']['deciftnv'];


?>


<?php $rank=1; ?>

<?php for($s=0;$s<$num_students;$s++): ?>

	<?php $r 	 = $s-1;?>
	<?php $score = $scores[$s];?>

<?php $ns = count($score); ?>
<?php if($ns == $num_activities): ?>	
<tr>

	<td><?php echo $s+1; ?></td>
	<td><?php echo $students[$s]['student_code']; ?></td>
	<td><?php echo $students[$s]['student']; ?></td>		
		
	<?php 
		for($i=0;$i<$num_activities;$i++): 
		$j = $i+1;
	?>
		<?php if($score[$i]['is_valid']): ?>						
			<td class="colshading center <?php echo ($score[$i]['score'] < ($score[$i]['max_score']/2))? 'fail' : null; ?>" ><?php echo number_format($score[$i]['score'],$deciscores); ?>			
				<?php if($score[$i]['score'] < ($score[$i]['max_score']/2)) { $data['activities'][$i]['failed']++;  }  else { $data['activities'][$i]['passed']++; }	?>					
			</td>
		<?php else: ?> 
			<td class="center colshading bg-lightgreen" > - </td>		
		<?php endif; ?>									
	<?php endfor; ?>		

		<td class="center colshading" ><?php echo number_format($students[$s]['q1'],$decigrades); 	
			if($is_k12): echo '<br>'.$students[$s]['dg1']; endif; ?></td>						
		<td class="center colshading" ><?php echo number_format($students[$s]['q2'],$decigrades);  
			if($is_k12): echo '<br>'.$students[$s]['dg2']; endif; ?></td>								
		<td class="center colshading" ><?php echo number_format($students[$s]['q3'],$decigrades); 
			if($is_k12): echo '<br>'.$students[$s]['dg3']; endif; ?></td>					
		<td class="center colshading" ><?php echo number_format($students[$s]['q4'],$decigrades); 	
			if($is_k12): echo '<br>'.$students[$s]['dg4']; endif; ?></td>					

		
		<td class="center colshading" >
			<?php if($data['editable']): ; ?> 
			<a href="<?php echo URL.'scores/editStudent/'.$course['id'].DS.$students[$s]['scid'].DS.$sy.DS.$qtr; ?>" ><?php echo $students[$s]['student']; ?></a>
			<?php else: ?>
				<?php echo $students[$s]['student']; ?>				
			<?php endif; ?>		
		</td>		
					
		<?php if($data['locked_with_ranks']):  ?>
			<?php if($students[$s]['q'.$qtr]<@$students[$r]['q'.$qtr]){ $rank++; }  ?>			
			<td class="center"><?php echo $rank; ?></td>
		<?php endif; ?>				
						
</tr>


<?php else: ?>	

<tr>
	<td colspan="<?php echo $num_activities+10; ?>" > Please update records of <a href="<?php echo URL.'scores/editStudent/'.$course['id'].DS.$students[$s]['scid'].DS.$sy.DS.$qtr; ?>" ><?php echo $students[$s]['student_code'].' - '.$students[$s]['student']; ?> </a> </td>
</tr>

<?php endif; ?>	


<?php endfor; ?> <!-- #data_students -->

<!-- =========================== Pass Fail Stats Below =========================== -->

<tr>
<th colspan=3 > Passed <br /> <span class='red'>Failed </span></th>
	
	<?php 
		$activities = $data['activities'];
		for($i=0;$i<$num_activities;$i++):
		$j = $i+1;

	?>
		<th class='center' >
			<?php echo "P: ".$activities[$i]['passed']."<br />"; ?>
			<span class='red'><?php echo "F: ".$activities[$i]['failed']; ?></span>
		</th>				
	<?php endfor; ?>
							
		<th colspan="5">&nbsp;</th>	
		<?php if($locked_with_ranks): ?>
			<td>&nbsp;</td>
		<?php endif; ?>				
		
</tr>






