<div>


<?php 

	// pr($data);
	$course = $data['course'];
	$ranks 	= $data['ranks'];
	$qtr 	= $data['qtr'];
	$rqqtr 	= 'rank_q'.$qtr; 	
	$num_rows = $data['num_rows'];
	
	// pr($ranks); exit;
	
?>



<h5>
	<a href="<?php echo URL; ?>teachers">Home</a> |
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a> |	
	<a href="<?php echo URL.'averages/courseRanks/'.$data['course']['course_id'].DS.$qtr; ?>" />Cancel</a>	
</h5>


<h2 class='darkgray'> Ranks <?php if($qtr < 5): ?>- qtr <?php echo $data['qtr']; ?> <?php endif; ?></h2>

<div>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Level</th><td><?php echo $course['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $course['section']; ?></td></tr>

<!--	
	<?php if($qtr < 5): ?> <tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?></td></tr> <?php endif; ?>	
-->	
</table>

<br />

<form method="POST">
<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="vc100" >ID Number</th>
	<th class="vc200" >Student</th>
	
<?php if($qtr < 5): ?>
	<th>Q<?php echo $data['qtr']; ?> Rank</th>
<?php else: ?>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>

<?php endif; ?>

</tr>

<?php for($i=0;$i<$num_rows;$i++): ?> 	<!-- loop thru num_students-->
	<tr>
		<td><?php echo $i+1; ?></td>
		<!-- zero index since all records have repeated student name and code -->
		<td><?php echo $ranks[$i]['student_code']; ?></td>
		<td><?php echo $ranks[$i]['student']; ?></td>

	<?php if($qtr < 5): ?>
		<td>	
			<?php echo $ranks[$i]['q'.$qtr]; ?>	<br />					
			<input class="vc50" type="text" name="data[<?php echo $i; ?>][rank_q<?php echo $qtr; ?>]" value="<?php echo $ranks[$i]['rank_q4']; ?>" />			
		</td>	
	<?php else: ?>
		<td>
			<?php echo $ranks[$i]['q1']; ?> <br />
			<input class="vc50" type="text" name="data[<?php echo $i; ?>][rank_q1]" value="<?php echo $ranks[$i]['rank_q4']; ?>" />			
		</td>
		<td>
			<?php echo $ranks[$i]['q2']; ?>	<br />	
			<input class="vc50" type="text" name="data[<?php echo $i; ?>][rank_q2]" value="<?php echo $ranks[$i]['rank_q4']; ?>" />			
		</td>
		<td>
			<?php echo $ranks[$i]['q3']; ?>	<br /> 
			<input class="vc50" type="text" name="data[<?php echo $i; ?>][rank_q3]" value="<?php echo $ranks[$i]['rank_q4']; ?>" />			
		</td>
		<td>
			<?php echo $ranks[$i]['q4']; ?>	<br />	
			<input class="vc50" type="text" name="data[<?php echo $i; ?>][rank_q4]" value="<?php echo $ranks[$i]['rank_q4']; ?>" />			
		</td>
	<?php endif; ?>	
	
	<td>
		<input type="hidden" name="data[<?php echo $i; ?>][gid]" value="<?php echo $ranks[$i]['gid']; ?>" />
	</td>
	
	
	</tr>
<?php endfor; ?>	<!-- iterate grades -->							
		
</table>


<input type="hidden" name="" value="<?php echo $data['course']['course_id']; ?>" />
<input type="submit" name="submit" value="Update"  >

</div>
</div>