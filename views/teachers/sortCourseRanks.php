<!--

ranking - decimal 1.5-1.5-3
anne	- 92	- 1.5
beth	- 92	- 1.5
cath	- 91	- 3

path: views/averages/sortCourseRanks.php

-->

<!------------------------------------------>


<div>

<?php 

$qtr = $qtr = $data['qtr'];
$rqqtr 	= 'rank_q'.$qtr; 	
	
	

$has_ties = false;
$ties	  = false; 	

	
?>



<h5>
	<a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	| 	
	<a href="<?php echo URL.'averages/courseRanks/'.$data['course']['course_id'].DS.$sy.DS.$qtr; ?>" />Cancel</a>	
	<a href="<?php echo URL.'averages/course/'.$course['course_id'].DS.$sy.DS.$qtr; ?>" />Grades</a>	
	<a href="<?php echo URL.'etcscores/raw/'.$course['course_id'].DS.$sy.DS.$curr_qtr; ?>" />Class Record</a>	
</h5>


<h5 class='darkgray'> Course Ranking <?php if($qtr < 5): ?>- Quarter <?php echo $data['qtr']; ?> <?php endif; ?></h5>



<div>
<table class='gis-table-bordered table-fx'>
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
		$ties = ($mine == $his)? true : false;				
		$val	= $rank;				
		$rank++;												
	?>					
		
<!----------------------------------------------------------------------------------------------------------------------->		
		
		<td class="center <?php echo ($ties)? 'bg-blue2 b' : null; ?>" ><?php echo $ranks[$i]['grade']; ?></td>					
		
		
		<td class="center vc50" ><?php echo $ranks[$i]['rank']; ?></td>

		<td class="sort <?php echo ($ties)? 'bg-red' : null; ?>" > 		
			<input class="vc50 center" type="text" name="data[<?php echo $i; ?>][qqtr]" value="<?php echo $val; ?>"  /> 
			<input type="hidden" name="data[<?php echo $i; ?>][gid]" value="<?php echo $ranks[$i]['gid']; ?>" />			
		</td>		
		
		<!-- num_diff for showing update button -->
		<?php if($rank != $ranks[$i]['rank']){ $num_diff++; } ?>

		<td class="hd" ><?php echo $ranks[$i]['scid']; ?></td>		
		<td class="hd" ><?php echo $ranks[$i]['gid']; ?></td>
			
	</tr>
<?php endfor; ?>	<!-- iterate grades -->							
		
</table>

<br />

<!--
<?php // if($num_diff): ?>	
	<input type="hidden" name="" value="<?php echo $data['course']['course_id']; ?>" />
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input class="sort" type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
<?php // else: ?>
	<button><a class="no-underline" href="<?php echo URL.'averages/courseRanks/'.$course['course_id'].DS.$sy.'/5'; ?>">  Ranks  </a></button>
<?php // endif; ?>	

-->
	<input type="hidden" name="" value="<?php echo $data['course']['course_id']; ?>" />
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input class="sort" type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
	

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

