

<!------------------------------------------------------------------------------------------------------------------------------>


<div>

<?php 


$decigrades = $_SESSION['settings']['decigrades'];
$deciranks  = $_SESSION['settings']['deciranks'];
$rqqtr 		= 'rank_q'.$qtr; 		

// pr($ranks[0]);

?>



<h5>
	<span class="screen">
		<?php echo $course['level'].' - '.$course['section']; ?> Conduct Ranks | 	
		<a href="<?php echo URL; ?>teachers">Home</a>
		<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
		<?php $ctype = ($course['crstype_id']==5)? 'conducts':'traits'; ?>
		| <a href='<?php echo URL."$ctype/records/$course_id/$sy/$qtr"; ?>'>Class Record</a>
		| <a href='<?php echo URL."conducts/fg/$course_id/$sy/$qtr"; ?>'>AVE</a>

		
<?php if($continuous): ?>
		| <a href='<?php echo URL."conducts/sortRanks/$sy/$qtr/$crid/$course_id"; ?>'>Ties</a>
<?php else: ?>		
		| <a href='<?php echo URL."conducts/sortRanks/$sy/$qtr/$crid/$course_id?continuous"; ?>'>Continuous</a>
<?php endif; ?>		
		
		
	</span>
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>


<div>
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course['course_id'].DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course['course_id'].DS.$sy.DS.$qtr; ?>" > Lock </a>
			<?php endif; ?>		
	</td></tr>

	<tr class="hd" ><th class='bg-blue2' >Type</th><td><?php echo '1-2-3 Editable'; ?></td></tr>
	<tr><th class='bg-blue2' >Subject</th><td><?php echo $course['subject']; ?></td></tr>
	<tr><th class='bg-blue2'>Status</th><td><?php echo ucfirst($qf).' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr> 
</table>

<p class="screen" > Press <span class="underline" >SORT</span> and <span class="underline" >UPDATE</span> to Finalize / Lock the class record. </p>

<form method="POST">
<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="" >Scid</th>
	<th class="vc100" >ID Number</th>
	<th class="vc200" >Student</th>	
	<th class="center" ><?php echo ucfirst($qf); ?> </th>
	<th class="center" >Rank</th>
	<th class="sort center" >Sort</th>
	<th class="center" >Tie</th>
	<th class="hd" >SCID</th>
	<th class="hd" >GID</th>
	
</tr>


<?php $num_diff=0; ?>

<?php $rank=0; ?>
<?php for($i=0;$i<$num_rows;$i++): ?> 	<!-- loop thru num_students-->
<?php $j = $i+1; ?>
	<tr>
		<td><?php echo $j; ?></td>
		<!-- zero index since all records have repeated student name and code -->
		<td><?php echo $ranks[$i]['scid']; ?></td>
		<td><?php echo $ranks[$i]['student_code']; ?></td>
		<td><?php echo $ranks[$i]['student']; ?></td>

<!----------------------------------------------------------------------------------------------------------------------->
	<?php 
		 
		$h = $i-1;
		$prev  = @$ranks[$h]['grade'];
		$mine  = $ranks[$i]['grade'];
		$same  = ($mine == $prev)? true:false;					
		if($continuous){
			$rank++;				
		} else {
			if(!$same){ $rank++; }				
		}
	 
	 ?>					
		
<!----------------------------------------------------------------------------------------------------------------------->		
		
		<td class="center <?php echo ($same)? 'bg-blue2 b' : null; ?>" ><?php echo number_format($ranks[$i]['grade'],$decigrades); ?></td>							
		<td class="center vc50" ><?php echo number_format($ranks[$i]['rank'],$deciranks); ?></td>

		<td class="sort <?php echo ($same)? 'bg-blue2':NULL; ?>" > 		
			<input class="vc50 center" type="text" name="data[<?php echo $i; ?>][rank]" value="<?php echo $rank; ?>"  /> 
			<?php if($ranks[$i]['rank']!=$rank): ?>
				<input type="hidden" name="data[<?php echo $i; ?>][sumid]" value="<?php echo $ranks[$i]['sumid']; ?>" />
			<?php endif; ?>
		</td>		
		<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie':NULL; ?></td>
		
		<!-- num_diff for showing update button -->
		<?php if($rank != $ranks[$i]['rank']){ $num_diff++; } ?>

		<td class="hd" ><?php echo $ranks[$i]['scid']; ?></td>		
		<td class="hd" ><?php echo $ranks[$i]['sumid']; ?></td>
			
	</tr>
<?php endfor; ?>	<!-- iterate grades -->							
		
</table>

<br />


<?php if(($_SESSION['srid']==RMIS) || ($_SESSION['srid']==RREG)): ?>
	<input type="hidden" name="" value="<?php echo $course_id; ?>" />
	<button id="sortBtn" onclick="editRanks();return false;">Sort On</button>
	<input class="sort" onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Update On"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel On</button>
<?php endif; ?>

	
<?php // if(!$is_locked): ?>
	<input type="hidden" name="" value="<?php echo $course_id; ?>" />
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input class="sort" onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
<?php // endif; ?>
	

</div>
</div>

<div class="ht100" ></div>


<!------------------------------------------------------------------------------------------------------------------------------>

<script>

var hdpass = '<?php echo HDPASS; ?>';

	$(function(){	
		nextViaEnter();	
		selectFocused();		
		$('#hdpdiv').hide();
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

