<?php 

// $count = count($data['scores']); 

?>


<?php 

// pr($data);
// pr($scores[0]);
// exit;





?>

<h5>
	
	Edit Scores (<?php echo $count; ?>) - <?php echo $activity['name']; ?> 
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uniscores/crs/'.$crs; ?>" >Scores</a>

	
</h5>

<div class="half" >

<form method='POST'>

<table class='gis-table-bordered table-fx'>

<tr>	
	<th class="" >Criteria <span class="shd" ><?php echo '#'.$activity['criteria_id']; ?></span></th>
	<td>
		<select class='full' type='text' name="activity[component_id]"   >
			<option>Select One</option>
			<?php	foreach($criteria AS $sel): ?><option value="<?php echo $sel['component_id']; ?>"  
				<?php echo ($sel['criteria_id']==$activity['criteria_id'])?'selected':null; ?> >
					<?php echo $sel['criteria'].' ('.($sel['weight']+0).'%)'; ?></option>
			<?php endforeach; ?>
		</select>		
	</td>
	<th>Date <input type="date" class="juice vc150" name="activity[date]" value="<?php echo $activity['date']; ?>" ></th>	
</tr>


<tr>
	<th class="" >Activity <span class="shd" ><?php echo '#'.$activity['aid'];  ?></span></th>
	<td><input class="full pdl05" name="activity[name]" value="<?php echo $activity['name']; ?>" ></td>
	<th>Max &nbsp; <input name="activity[max_score]" maxlength='3' class="pdl05 vc120" value="<?php echo $activity['max_score']+0; ?>" /></th>
</tr>


	
</table>

<hr />

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Score</th>
	<th>Change<br />
		<input class="vc50 center" type="text" id="iscore" placeholder="All" /><br />
		<button onclick="populateColumn('score');return false;">All</button>			
	
	</th>
</tr>

<!------------------ data ------------------------------------------------------------------->

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $scores[$i]['student_code']; ?></td>
	<td><?php echo $scores[$i]['student']; ?></td>
	<td class="center" ><?php echo $scores[$i]['score']+0; ?></td>
	<td><input id="score<?php echo $i; ?>" class="score center vc50 pdr05" name="scores[<?php echo $i; ?>][score]" 
		value="<?php echo $scores[$i]['score']+0; ?>" tabIndex=2 ></td>

	<?php if($_SESSION['settings']['show_valid_radio']==1): ?>	
		<td><input type='radio' name="scores[<?php echo $i; ?>][is_valid]" value=1 <?php echo ($scores[$i]['is_valid']==1)?'checked':null;  ?>  >Present</td>
		<td><input type='radio' name="scores[<?php echo $i; ?>][is_valid]" value=0 <?php echo ($scores[$i]['is_valid']!=1)?'checked':null;  ?> >Excused</td>		
	<?php endif; ?>
<input type='hidden' name="scores[<?php echo $i; ?>][id]" value="<?php echo $scores[$i]['score_id']; ?>" >		
	
		
</tr>


<?php endfor; ?>

</table>

<p>
	<input type="hidden" name="crs" value="<?php echo $activity['course_id']; ?>" > &nbsp; 	
	<input type='submit' name='submit' value='Submit'> &nbsp; 	
	<button><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="no-underline" >Cancel</a></button>
</p>	

</form> <!-- editScoresForm -->

</div> 	<!-- scores half -->


<!-------------------------------------------------------------------------------------------------------------->

<div class="hd" > 
	<button onclick="pasteFromExcel('scorebox','score');return false;"> Paste Value </button>
	<br /><br />
	<textarea id="scorebox" rows="30" cols="3"  ></textarea>

</div>	<!-- valuesFromExcel -->


<!------------------------------------------------------------------------------------------------->

<script>
	$(function(){	
		hd();
		nextViaEnter();		
		selectFocused();
		
	});
</script>


