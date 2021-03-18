
<h5>
	Edit Student Scores 
	| <span class="u" onclick="pclass('hd');" >HD</span>
	| <?php 	$this->shovel('homelinks','Teachers'); ?>	
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr"; ?>' >Scores</a>
	| <a href='<?php echo URL."og/scores/$course_id/$scid/$sy/$qtr"; ?>' >One-Student</a>

</h5>

<?php 


// pr($_SESSION['q']);
$srid=$_SESSION['srid'];
$admin_roles=array(5,9);
$is_admin=in_array($srid,$admin_roles)? 1:0;

?>


<?php $this->shovel('hdpdiv'); ?>

<div class="half ht1000" >

<table class='gis-table-bordered table-fx'>

<tr><th class='bg-blue2'>Crs | SCID </th><td class="vc200" ><?php echo $course['id']." | ".$student['scid']; ?></td></tr>
<tr><th class='bg-blue2'>Label</th><td><?php echo $course['label']; ?></td></tr>
<tr><th class='bg-blue2'>ID</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th class='bg-blue2'>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class='bg-blue2'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>

</table>
<br />
<!---------------------------------------------------------------->


<form method="POST" >


<?php  // pr($scores[0]); ?>

<table class="gis-table-bordered table-fx" >

<tr class="headrow" >
	<th>#</th>
	<th>Date</th>
	<th>Activity</th>
	<th>Max</th>
	<th>Score</th>
</tr>

<?php for($i=0;$i<$num_scores;$i++): ?>
<tr id="row<?php echo $scores[$i]['score_id']; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo date('M-d',strtotime($scores[$i]['date'])); ?></td>
	<td id="<?php echo 'SCR:'.$scores[$i]['score_id'].' | AID:'.$scores[$i]['activity_id']; ?>" ondblclick="alert(this.id);"  ><?php echo $scores[$i]['activity']; ?></td>
	<td class="right" ><?php echo $scores[$i]['max_score']; ?></td>
	<td><input class="vc50 right" type="text" name="scores[<?php echo $i; ?>][score]" value="<?php echo $scores[$i]['score']; ?>"   /></td>

	<!-- if absent,0 score not included in the grade TNV computation -->
	<?php if($_SESSION['settings']['show_valid_radio'] == 1): ?>
		<td><input type='radio' name="scores[<?php echo $i; ?>][is_valid]" value='1' <?php echo ($scores[$i]['is_valid'] == 1)? 'checked' : null;  ?>  >Present</td>
		<td><input type='radio' name="scores[<?php echo $i; ?>][is_valid]" value='0' <?php echo ($scores[$i]['is_valid'] != 1)? 'checked' : null;  ?>  >Excused</td>		
	<?php endif; ?>
	
	
	<td class="hd" ><button id="<?php echo $scores[$i]['score_id']; ?>" onclick="xdelScore(this.id);return false;" >
		Delete</button></td>

	<!------------------------->
	<input type="hidden" name="scores[<?php echo $i; ?>][max_score]" value="<?php echo $scores[$i]['max_score']; ?>"   />
	<input type="hidden" name="scores[<?php echo $i; ?>][scrid]" value="<?php echo $scores[$i]['score_id']; ?>"   />

</tr>

<?php endfor; ?>

</table>
<br />
<?php if(!$is_locked): ?>
	<p>
		<input type="submit" name="save" value="Save" /> &nbsp;
		<button><a class="black no-underline" href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr"; ?>' > Class Record </a></button>	
	</p>
<?php endif; ?>


<?php if($is_locked && $is_admin): ?>
	<p>
		<input type="submit" name="save" value="Save On" /> &nbsp;
	</p>
<?php endif; ?>


</form>


<!-------------------------------------------------------------------->

<?php // echo "numscores - $num_scores <br />"; ?>
<?php // echo "num-acts: $num_activities <br />"; ?>

<?php if($num_scores != $num_activities): ?>	<!-- mismatch scores-activities -->


<h4>Activities</h4>

<?php // pr($activities[0]); ?>

<form method="POST" >

<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th class="" >AID</th>
	<th>Date</th>
	<th>Activity</th>
	<th>Max</th>
	<th>Score</th>
</tr>
<?php for($i=0;$i<$num_activities;$i++): ?>
<?php if(!in_array($activities[$i]['activity_id'],$saids)): ?> &nbsp;		
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="" ><?php echo $activities[$i]['activity_id']; ?></td>
	<td><?php echo $activities[$i]['activity_date']; ?></td>
	<td><?php echo $activities[$i]['activity']; ?></td>
	<td><?php echo $activities[$i]['max_score']; ?></td>
	<td> 
		<input class="center vc50" type="text" name="scores[<?php echo $i; ?>][score]" value="0" />
		<input type="hidden" name="scores[<?php echo $i; ?>][aid]" value="<?php echo $activities[$i]['activity_id']; ?>" />
	</td>
</tr>
<?php endif; ?>
<?php endfor; ?>
  
</table>


<input type="hidden" name="scid" value="<?php echo $student['scid']; ?>"  />
<input type="hidden" name="crsid" value="<?php echo $course['id']; ?>"  />
<input type="hidden" name="qtr" value="<?php echo $qtr; ?>"  />
<p><input type="submit" name="add" value="Add"  /></p>
</form>


<?php endif; ?>	<!-- mismatch scores-activities -->

</div>

<?php if(isset($_SESSION['boys'])): ?>
<div class="fifth"  >
<h5>Boys</h5>
<?php foreach($boys AS $row): ?>
<p><a href="<?php echo URL.'scores/editStudent/'.$course_id.DS.$row['scid'].DS.$sy.DS.$qtr; ?>" ><?php echo $row['student']; ?></a></p>
<?php endforeach; ?>
</div>

<div class="fifth"  >
<h5>Girls</h5>
<?php foreach($girls AS $row): ?>
<p><a href="<?php echo URL.'scores/editStudent/'.$course_id.DS.$row['scid'].DS.$sy.DS.$qtr; ?>" ><?php echo $row['student']; ?></a></p>
<?php endforeach; ?>
</div>
<?php endif; ?>	<!-- session-boys -->

<script>

var gurl 	= 'http://<?php echo GURL; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';
var sy		= '<?php echo $sy; ?>';



$(function(){
	$('#hdpdiv').hide();
	hd();
	nextViaEnter();
	selectFocused();

})



/* no json value returned here */
function xdelScore(scoreid){
	var vurl=gurl + '/ajax/xscores.php';	
	var task="xdelScore";		
	$.ajax({
		url:vurl,type:'POST',data:'scoreid='+scoreid+'&task='+task,				
		success:function(){ $("#row"+scoreid).remove(); } 
    });					
	
}	/* fxn */





</script>
