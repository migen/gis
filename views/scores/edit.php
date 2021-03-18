
<style>

.clsData > div { float:left;border:1px solid fff; width:200px; }
div.label { background-color:red; }

#tblClassXxx{ width:100%;table-layout:auto; }
.tblClass{ float:left; border:1px solid; color:red;}

.header{
	display:grid;
	grid-template-columns:repeat(4,1fr);
	
}

</style>

<style>

#status{ color:brown;font-size:1.2em;font-weight:bold; }

</style>

<?php $count = count($data['scores']); ?>


<?php 
// pr($data);
// exit;
// pr($course);

$dbtable="{$dbg}.50_scores";
$is_ps=$course['is_ps'];
$is_k12=$course['is_k12'];
$is_k12=($is_k12 && !$is_ps);




?>

<h5>
	<a href="<?php echo URL.'teachers'; ?>">Home</a> |
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a>
	
| Edit Scores (<?php echo $count; ?>) - <?php echo $activity['activity']; ?> 
| <span onclick="tracehd();" >Smartboard</span>
	
</h5>


<form method="POST" >

<div class="header" >
	<div class="" >
	<table class='gis-table-bordered table-fx tbl1' >

	<tr>
		<th class='bg-blue2'>Class
			<?php if(isset($_GET['debug'])){ echo '#'.$course['crid']; } ?>			
		</th>
		<td><?php echo $course['level'].' - '.$course['section']; ?></td>
	</tr>
	<tr>
		<th class='bg-blue2'>Subject 
			<?php if(isset($_GET['debug'])){ 			
				echo '#'.$course['subject_id']; 
				echo ' | Crs#'.$course['course_id']; 
			} ?>				
		</th>			
		<td><?php echo $course['subject']; ?></td>
	</tr>


	<tr>
		<th class='bg-blue2'>Date</th>
		<td><input type='date' class='full juice' name='data[Activity][date]' value="<?php echo isset($activity['date'])? $activity['date'] : date('Y-m-d'); ?>" ></td>
	</tr>

	</table>
	</div>	<!-- left -->


	<div class="" >
	<table class='gis-table-bordered table-fx tbl2' >
	<tr>	
		<th class='bg-blue2'>Criteria
			<?php if(isset($_GET['debug'])){ echo '#'.$activity['criteria_id']; } ?>			
		</th>
		<td>
			<select class='full' type='text' name='data[Activity][component_id]'   >
					<?php if($course['is_acad'] || $course['is_elective']): ?>
						<option>Choose Criteria</option>
						<?php	foreach($data['selects']['criteria'] as $sel): ?><option value="<?php echo $sel['component_id']; ?>"  <?php echo ($sel['criteria_id'] == $activity['criteria_id'])? 'selected' : null; ?> ><?php echo $sel['criteria']; ?></option><?php	endforeach; ?>				
					<?php else: ?>
						<option value="<?php echo $activity['criteria_id']; ?>" ><?php echo $activity['criteria']; ?></option>
					<?php endif; ?>
			</select>		
		</td>
	</tr>

	<?php if($kpup): ?>
		<tr>	
			<th class='bg-blue2'>Subcriteria</th>
			<td>
				<select class='full' type='text' name='data[Activity][subcomponent_id]'  >
					<option>Choose Subcriteria</option>
					<?php	foreach($data['selects']['subcriteria'] as $sel): ?><option value="<?php echo $sel['subcriteria_id']; ?>"  <?php echo ($sel['subcriteria_id'] == $activity['subcriteria_id'])? 'selected' : null; ?>  ><?php echo $sel['subcriteria']; ?></option><?php	endforeach; ?>				
				</select>		
			</td>
		</tr>
	<?php endif; ?>


	<tr>
		<th class='bg-blue2'>Activity 
			<?php if(isset($_GET['debug'])){ echo '#'.$activity['activity_id']; } ?>		
		</th>
		<td>
				<input class="full pdl05" id='activity' type='text' name='data[Activity][name]' value="<?php echo $activity['activity']; ?>" >
				
		</td>
	</tr>


	<tr>
		<th class='bg-blue2'>Max Score</th>	
		<td>
			<input type="text" name="data[Activity][max_score]" maxlength='3' class="pdl05 full" value="<?php echo $activity['max_score']; ?>" />
		</td>
	</tr>
		<input type='hidden' name='data[Activity][activity_id]' value="<?php echo $activity['activity_id']; ?>" >
	</table>
	</div>	<!-- right -->
</div>	<!-- header grid -->


<div class="clear" >&nbsp;</div>

<div id="status" ></div>

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Score<br />
		<input class="vc50" type="text" id="iscore" placeholder="All" />
		<button onclick="populateColumn('score');return false;">All</button>			
	
	</th>
	<th colspan=3></th>
</tr>

<!------------------ data ------------------------------------------------------------------->

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $scores[$i]['student_code']; ?></td>
	<td><?php echo $scores[$i]['student']; ?></td>
	<td><input id="score<?php echo $i; ?>" class="score right vc70 pdr05" name='data[Score][<?php echo $i; ?>][score]' 
		value="<?php echo isset($data['scores'][$i]['score'])? $data['scores'][$i]['score'] : 0; ?>" ></td>

	<?php if($_SESSION['settings']['show_valid_radio'] == 1): ?>
		<td><input type='radio' name='data[Score][<?php echo $i; ?>][is_valid]' value='1' <?php echo ($scores[$i]['is_valid'] == 1)? 'checked' : null;  ?>  >Present</td>
		<td><input type='radio' name='data[Score][<?php echo $i; ?>][is_valid]' value='0' <?php echo ($scores[$i]['is_valid'] != 1)? 'checked' : null;  ?> 		  >Excused</td>		
	<?php endif; ?>
		
	<td><button onclick="xsaveRow(<?php echo $i; ?>);return false;" >Save</button></td>
		<input type="hidden" name="data[Score][<?php echo $i; ?>][student]" value="<?php echo $scores[$i]['student']; ?>" >
	
		<input type='hidden' name='data[Score][<?php echo $i; ?>][id]' value="<?php echo isset($scores[$i]['score'])? $scores[$i]['id'] : 0; ?>" >
</tr>


<?php endfor; ?>

</table>

<br />
<p>
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

var gurl = 'http://<?php echo GURL; ?>';	
var dbtable="<?php echo $dbtable; ?>";	
	
$(function(){	
	hd();
	nextViaEnter();		
	selectFocused();
	
});
	
	
function xsaveRow(i){
	var vurl=gurl+"/ajax/xdata.php";
	var task="xeditData";	
	var student=$('input[name="data[Score]['+i+'][student]"').val();
	var score=$('input[name="data[Score]['+i+'][score]"').val();
	var id=$('input[name="data[Score]['+i+'][id]"').val();
	var pdata="task="+task+"&id="+id+"&score="+score+"&dbtable="+dbtable;
	
	$.ajax({
		url:vurl,type:"POST",data:pdata,
		success:(function(){ $('#status').html(student+" Score changed to "+score+" - Success. "); })
		
	})
	
}	/* fxn */	
	
</script>


