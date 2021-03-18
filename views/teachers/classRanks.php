

<?php 

	// pr($_SESSION['q']);

$cr		= $data['classroom'];
$qtr 	= $qtr  = $data['qtr'];
$rqqtr 	= 'rank_q'.$qtr; 	

// pr($cr);

// ================= DEFINE VARS ====================================

// $num_rows = $data['num_rows'];
// $ranks 	= $data['ranks'];
// $is_locked = $data['is_locked'];

// ================= DEBUG ==========================================

// pr($data);	
// pr($ranks); exit;

// ================= TRACE ==========================================	
// echo " <br /><button onclick='summary();' > Trace </button><br />	";

	
?>



<h5>
	<a href="<?php echo URL; ?>teachers">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
</h5>

<h2 class='darkgray'> Ranks <?php if($qtr < 5): ?>- qtr <?php echo $data['qtr']; ?> <?php endif; ?></h2>

<form method="POST" >

<table class='gis-table-bordered table-fx'>
	<tr><th class='bg-blue2' >Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='bg-blue2' >Section</th><td><?php echo $cr['section']; ?></td></tr>
	
<?php if($qtr < 5): ?> <tr><th class='bg-blue2'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr> <?php endif; ?>	
</table>

<br />

<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="vc50 hd" >CID</th>
	<th class="vc100" >ID Number</th>
	<th class="vc200" >Student</th>
	
	<th class="center" >Q<?php echo $data['qtr']; ?> </th>
	<th class="center" >RQ<?php echo $qtr; ?> <br />		
	</th>
<!--
	<th>Action</th>
-->
</tr>

<?php for($i=0;$i<$num_rows;$i++): ?> 	<!-- loop thru num_students-->
	<tr id="row<?php echo $i; ?>">
		<td><?php echo $i+1; ?></td>
		<!-- zero index since all records have repeated student name and code -->
		<td class="vc50 hd" ><?php echo $ranks[$i]['scid']; ?></td>
		<td><?php echo $ranks[$i]['student_code']; ?></td>
		<td><?php echo $ranks[$i]['student']; ?></td>

	<?php if($qtr < 5): ?>
		<td class="center" ><?php echo $ranks[$i]['q'.$qtr]; ?></td>					
		<td class="center" >
			<input class="vc50 center" type="text" name="data[<?php echo $i; ?>][rank_q<?php echo $qtr; ?>]" value="<?php echo $i+1; ?>"  />						
			<input type="hidden" name="data[<?php echo $i; ?>][sumid]" value="<?php echo $ranks[$i]['sumid']; ?>"  />						
		</td>	
	<?php else: ?>
		<?php for($a=1;$a<$qtr;$a++): ?>
			<td class="center" ><?php echo $ranks[$i]['q'.$a]; ?> </td>
			<td class="center" ><?php echo ($ranks[$i]['rank_q'.$a] > 0)? $ranks[$i]['rank_q'.$a] : '-'; ?></td>
		<?php endfor; ?>		
	<?php endif; ?>	

	</tr>
	
<?php endfor; ?>	<!-- iterate grades -->						
		
</table>


<?php if($is_locked): ?>
<?php else: ?>
	<br /><input onclick="return confirm('Reminder: Bonuses & Attendance must be accomplished first.');" type="submit" name="finalize" value="Submit Ranking" />
<?php endif; ?>


</form>

<script>

$(function(){
	hd();

})



</script>
