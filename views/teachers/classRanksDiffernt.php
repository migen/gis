<div>


<?php 

	// pr($data);
	$cr 	= $data['classroom'];
	$ranks 	= $data['ranks'];
	$qtr 	= $data['qtr'];
	$rqqtr 	= 'rank_classroom_q'.$qtr; 	
	$num_rows = $data['num_rows'];
	
	
?>



<h5>
	<a href="<?php echo URL; ?>teachers">Home</a> |
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a> |	
	<a href="<?php echo URL.'teachers/editRanks/'.$data['classroom']['id'].DS.$qtr; ?>" />Edit</a>	
</h5>

<h2 class='darkgray'> Ranks <?php if($qtr < 5): ?>- qtr <?php echo $data['qtr']; ?> <?php endif; ?></h2>

<div class='third'>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $cr['section']; ?></td></tr>
<?php if($qtr < 5): ?> <tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?></td></tr> <?php endif; ?>	
</table>

<br />

<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	
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
		<td><?php echo $ranks[0]['student_code']; ?></td>
		<td><?php echo $ranks[0]['student']; ?></td>

	<?php if($qtr < 5): ?>
		<td><?php echo ($ranks[$i][$rqqtr] > 0)? $ranks[$i][$rqqtr] : '-'; ?></td>	
	<?php else: ?>
		<td><?php echo ($ranks[$i]['rank_classroom_q1'] > 0)? $ranks[$i]['rank_classroom_q1'] : '-'; ?></td>
		<td><?php echo ($ranks[$i]['rank_classroom_q2'] > 0)? $ranks[$i]['rank_classroom_q2'] : '-'; ?></td>
		<td><?php echo ($ranks[$i]['rank_classroom_q3'] > 0)? $ranks[$i]['rank_classroom_q3'] : '-'; ?></td>
		<td><?php echo ($ranks[$i]['rank_classroom_q4'] > 0)? $ranks[$i]['rank_classroom_q4'] : '-'; ?></td>
	<?php endif; ?>	
	</tr>
<?php endfor; ?>								
		
</table>

</div>
</div>