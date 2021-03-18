<!--


ranking - decimal 1.5-1.5-3
anne	- 92	- 1.5
beth	- 92	- 1.5
cath	- 91	- 3


path: views/averages/sortCourseRanks.php

-->

<!------------------------------------------------------------------------------------------------------------------------------>


<div>

<?php 

$decigrades = $_SESSION['settings']['decigrades'];
$deciranks  = $_SESSION['settings']['deciranks'];


$rqqtr 		= 'rank_q'.$qtr; 	
$is_tied 	= false;

// pr($ranks[0]);
	
?>



<h5>
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	| 	
	<a href="<?php echo URL.'averages/courseRanks/'.$data['course']['course_id'].DS.$sy.DS.$qtr; ?>" />Cancel</a>	
</h5>


<h5 class='darkgray'> Course Ranking <?php if($qtr < 5): ?>- Quarter <?php echo $data['qtr']; ?> <?php endif; ?></h5>



<div>
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='bg-blue2' >Type</th><td><?php echo '1-1-2 Readonly'; ?></td></tr>
	<tr><th class='bg-blue2' >Level</th><td><?php echo $course['level']; ?></td></tr>
	<tr><th class='bg-blue2' >Section</th><td><?php echo $course['section']; ?></td></tr>
	<tr><th class='bg-blue2' >Subject</th><td><?php echo $course['subject']; ?></td></tr>
	<?php if($qtr < 5): ?> <tr><th class='bg-blue2'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr> <?php endif; ?>	
</table>

<br />

<form method="POST">
<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="vc100" >ID Number</th>
	<th class="vc200" >Student</th>	
	<th class="center" ><?php echo ucfirst($qf); ?> </th>
	<th class="center" >Rank</th>
	<th class="sort center" >Sort</th>
	<th class="hd" >SCID</th>
	<th class="hd" >GID</th>
	
</tr>


<?php $num_diff=0; ?>

<?php $rank=1; ?>
<?php for($i=0;$i<$num_rows;$i++): ?> 	<!-- loop thru num_students-->
<?php $j = $i+1; ?>
	<tr>
		<td><?php echo $j; ?></td>
		<!-- zero index since all records have repeated student name and code -->
		<td><?php echo $ranks[$i]['student_code']; ?></td>
		<td><?php echo $ranks[$i]['student']; ?></td>

<!----------------------------------------------------------------------------------------------------------------------->
	<?php 
		$mine 	= $ranks[$i]['grade'];				
		@$his 	= $ranks[$j]['grade'];	
		$val	= $rank;				
		if($mine == $his){ $is_tied = true; } else { $rank++; } 
	?>					
		
<!----------------------------------------------------------------------------------------------------------------------->		
		
		<td class="center <?php echo ($is_tied)? 'bg-blue2 b' : null; ?>" ><?php echo number_format($ranks[$i]['grade'],$decigrades); ?></td>					
		
		
		<td class="center vc50" ><?php echo number_format($ranks[$i]['rank'],$deciranks); ?></td>

		<td class="sort <?php echo ($is_tied)? 'bg-red' : null; ?>" > 		
			<input class="vc50 center" type="text" name="data[<?php echo $i; ?>][qqtr]" value="<?php echo $val; ?>" readonly  /> 
			<input type="hidden" name="data[<?php echo $i; ?>][gid]" value="<?php echo $ranks[$i]['gid']; ?>" />			
			<?php $is_tied = false; ?>
		</td>		
		
		<!-- num_diff for showing update button -->
		<?php if($rank != $ranks[$i]['rank']){ $num_diff++; } ?>

		<td class="hd" ><?php echo $ranks[$i]['scid']; ?></td>		
		<td class="hd" ><?php echo $ranks[$i]['gid']; ?></td>
			
	</tr>
<?php endfor; ?>	<!-- iterate grades -->							
		
</table>

<br />


<?php if($qtr<5 && !$is_locked): ?>
	<input type="hidden" name="" value="<?php echo $data['course']['course_id']; ?>" />
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input class="sort" onclick="return confirm('Are you sure?');"  type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
<?php endif; ?>
	

</div>
</div>


<!------------------------------------------------------------------------------------------------------------------------------>

<script>
	$(function(){	
		nextViaEnter();	
		hd();
		$('.sort').hide();
		$('#cancelBtn').hide();	
		
		
	});
	
	function editRanks(){
		$('#sortBtn').toggle();	
		$('#cancelBtn').toggle();	
		$('.sort').toggle();	
	}
	
	
</script>

