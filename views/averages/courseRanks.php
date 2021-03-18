



<?php 

// pr($course);

	$with_chinese = $_SESSION['settings']['with_chinese'];	
	$decigrades = $_SESSION['settings']['decigrades'];
	$deciranks  = $_SESSION['settings']['deciranks'];

	$rqqtr 	= 'rank_q'.$qtr; 	
	
	$has_ties = false;
	$ties	  = false; 	

	
?>

<!-------------- headlinks ------------------------->
<h5 class='darkgray'> 

	<a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'averages/courseRanks/'.$course['id'].DS.$sy; ?>">Ranking</a>		
	<?php if($course['is_aggregate']): ?>
		<?php $j = ($qtr<5)? $qtr:'4'; ?>
		| <a href='<?php echo URL."submissions/view/$crid/$sy/$j"; ?>' >Submissions</a>
	<?php endif; ?>
	
</h5>

<!------- course info ------->

<table class='gis-table-bordered table-fx'>
	<tr><th class='bg-blue2' >Classroom</th><td class="vc200" ><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
	<tr><th class='bg-blue2' >Subject</th><td><?php echo $course['label']; ?></td></tr>
	<tr><th class='bg-blue2'>Status</th><td><?php echo ucfirst($qf).' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?></td></tr> 
</table>

<br />

<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="hd" >CID</th>
	<th class="vc100" >ID Number</th>
	<th class="vc200" >Student</th>
	
<?php if($qtr < $intfqtr): ?>
	<th class="center" >Q<?php echo $qtr; ?> </th>
	<th class="center" > Rank 
		<?php if($qtr==$sqtr): ?>
			<br /><a href='<?php echo URL."averages/sortCourseRanks/".$course['course_id']."/$sy/$qtr"; ?>'>Sort</a>
		<?php endif; ?>			
	</th>
<?php else: ?>
	<?php for($a=1;$a<=$intfqtr;$a++): ?>
		<th class="center" >Q<?php echo $a; ?></th>
		<td class="center" >Rank<br />Q<?php echo $a; ?>
			<?php if($a==$sqtr): ?>			
				<br /><a href="<?php echo URL.'averages/sortCourseRanks/'.$course['course_id'].DS.$sy.DS.$a; ?>">Sort</a>
			<?php elseif($a==$intfqtr): ?>
				<br /><a href='<?php echo URL."averages/sortCourseRanks/".$course['course_id']."/$sy/$intfqtr"; ?>'>Sort</a>						
			<?php endif; ?>
		</td>
	<?php endfor; ?>
<?php endif; ?>

</tr>

<?php for($i=0;$i<$num_rows;$i++): ?> 	<!-- loop thru num_students-->
	<?php $j=$i+1; ?>
	<tr id="row<?php echo $i; ?>">
		<td><?php echo $i+1; ?></td>
		<!-- zero index since all records have repeated student name and code -->
		<td class="hd" ><?php echo $ranks[$i]['scid']; ?></td>
		<td><?php echo $ranks[$i]['student_code']; ?></td>
		<td><?php echo $ranks[$i]['student']; ?>
			<?php echo ($with_chinese==1)? '<br />'.$ranks[$i]['chinese_name']:NULL; ?>		
		</td>

	<?php if($qtr < $intfqtr): ?>
		<?php 
			$mine 	= $ranks[$i]['q'.$qtr]; 
			@$his 	= $ranks[$j]['q'.$qtr]; 
			$ties 	= ($mine == $his)? true : false;						
		?>
				
		<td class="center <?php echo ($ties)? 'blue b':NULL; ?>" ><?php echo number_format($ranks[$i]['q'.$qtr],$decigrades); ?> </td>				
		<?php $ties = false; ?>
		<td class="center" ><?php echo ($ranks[$i][$rqqtr] > 0)? ($ranks[$i][$rqqtr]+0) : '-'; ?> </td>	
	<?php else: ?>
		<?php for($k=1;$k<=$qtr;$k++): ?>
			<td class="center" ><?php echo number_format($ranks[$i]['q'.$k],$decigrades); ?> </td>
			<td class="center" ><?php echo ($ranks[$i]['rank_q'.$k] > 0)? number_format($ranks[$i]['rank_q'.$k],$deciranks) : '-'; ?></td>
		<?php endfor; ?>			
	<?php endif; ?>	

	
	</tr>
	
<?php endfor; ?>	<!-- iterate grades -->						
		
</table>



<script>

$(function(){
	hd();

})


</script>
