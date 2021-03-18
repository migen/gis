<?php 
	// pr($data);
	$cr 	= $classroom;
	$qtr 	= $qtr;
	$bqqtr 	= 'bonus_q'.$qtr; 
	
?>



<!-- hyperlinks -->
<h5>
	Edit Credits
	| <?php $this->shovel('homelinks','teachers'); ?>	
</h5>


<!--------------------------------------------------------------------------->

<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>Cr-Crs</th><td><?php echo $course['crid'].' - '.$course['course_id']; ?></td></tr>
	<tr><th class='white headrow'>Level</th><td><?php echo $course['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $course['section']; ?></td></tr>
	<tr><th class='white headrow'>Course</th><td><?php echo $course['name']; ?></td></tr>
	<tr><th class='white headrow'>qtr</th><td><?php echo $qtr; ?> - 
		<?php 
			if($qtr<5){
				echo ($is_locked)? 'Closed':'Open';
			} 
		?>	
	</td></tr>
	<tr><th class='white headrow'>Subject</th><td class="b" ><?php echo $course['subject']; ?></td></tr>	
	
</table><br />


<!--------------------------------------------------------------------------->


<form method='post'>

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th class="hd" >SCID</th>
	<th>ID Number</th>
	<th>Student</th>
	<th> Bonus </th>
</tr>

<!------------------- data -------------------------------------------------------->

<?php for($i=0;$i<$num_rows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $bonuses[$i]['scid']; ?></td>
	<td><?php echo $bonuses[$i]['student_code']; ?></td>
	<td><?php echo $bonuses[$i]['student']; ?></td>
	<td>
		<?php echo $bonuses[$i]['q'.$qtr]; ?><br />
		<input class="vc50 center " type="text" name="data[Bonus][<?php echo $i; ?>][<?php echo $bqqtr; ?>]" value="<?php echo $bonuses[$i][$bqqtr]; ?>" />
		<input type="hidden" name="data[Bonus][<?php echo $i; ?>][id]" value="<?php echo $bonuses[$i]['grade_id']; ?>" />		
	</td>
</tr>
<?php endfor; ?>
</table>

<input type='hidden' name='bqqtr' value="<?php echo $bqqtr; ?>" >

<?php if(!$is_locked): ?>
	<p>
		<input type='submit' name='submit' value="Update" >
		<button><a class="no-underline" href="<?php echo URL.'teachers/bonuses/'.$crid.DS.$sy.DS.$qtr; ?>" />Cancel</a></button>
	</p>
<?php endif; ?>

</form>

<!------------------------------------------------------------>

<script>
	$(function(){ 
		// hd(); 
		nextViaEnter();
		selectFocused();
		
	})
</script>


