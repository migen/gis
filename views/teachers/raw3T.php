<?php 


// data=>ratings,qtr,curr_qtr,is_locked,students,qg => q4,activities,scores,criteria,course
// pr($data);

$showcid = ($_SESSION['settings']['showcid']==1)? true : false;


$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];

$is_k12 	= $is_k12;


$bonusgrade = (BGRADE==1)? true : false;
$bonus 		= (BONUS==1)? true : false;
$bonustotal = (BONUSTOTAL==1)? true : false;



// initialization
$subcri_totalmax   =  0;

$num_activities	= count($activities);
for($i=0;$i<$num_activities;$i++){
	$data['activities'][$i]['passed'] = 0;
	$data['activities'][$i]['failed'] = 0;
}

$qtr = $qtr = $data['qtr'];
$qqtr = 'q'.$data['qtr'];
$dgr = 'dg'.$qtr;

/* ===================== FORMULAS : transmute,rating ===================== */


$flrgr = $_SESSION['settings']['floor_grade_ftnv'];

/* ===================== letter equivalent from db-table descriptions ===================== */

$this->shovel('ratings',$ratings);



?>



<h5>
	Raw Class Record
	<span class="screen" >
		| <?php $this->shovel('homelinks',$home); ?>

	| <a href="<?php echo URL.'teachers/scores/'.$course['id'].DS.$sy.DS.$qtr; ?>"   >Detailed</a> 
	| <a href="<?php echo URL.'etcscores/sumscores/'.$course['id'].DS.$sy.DS.$qtr; ?>"   >Summary</a> 

		
		<?php if($course['is_aggregate']): ?>
		<?php $par_agg = $course['crid'].DS.$course['course_id'].DS.$course['subject_id'].DS.$sy.DS.$qtr; ?>
		| <a href="<?php echo URL.$home.'/tallyAggregates/'.$par_agg; ?>" >Aggregate</a>
		<?php endif; ?>		
	</span>
	
</h5>


<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<div id='printable' >

<!---------------------------------------------------------------------------------->
<div class='third'>
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>		
	</td></tr>
	<tr><th class='white headrow'>Classroom</th><td class="vc200" ><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
	<tr><th class='white headrow'>Subject</th><td><?php echo $course['label']; ?></td></tr>
	<tr><th class='white headrow'>Teacher</th><td><?php echo $course['teacher']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table>
</div>

<div class="fourth"></div>

<div class='half'>
<table class='gis-table-bordered table-fx f12'>
	
	<tr><th colspan="2" class=''>Legends:</th></tr>
	<tr><th class=''>PNV</th><td>Partial Numerical Value</td></tr>
	<tr><th class=''>TNV</th><td>Total Numerical Value</td></tr>
	<tr><th class=''>FTNV</th><td>Final Total Numerical Value</td></tr>
	<tr><th class=''>Trans (%)</th><td>Actual Percentage NOT Raw Transmuted</td></tr>

</table>
</div>
<!---------------------------------------------------------------------------------->


<form method='post'>
<?php $num_diff = 0; ?>

<br />

<div class='clear'></div>



<p class="screen" >


<?php if($is_locked): ?>
	<a href="<?php echo URL.$home.'/sumscores/'.$course['id'].DS.$sy.DS.$qtr; ?>" class="button" style="font-size:14px;" >Summary </a> &nbsp; 
<?php endif; ?>

<?php if($is_locked): ?>
	<?php 	$printVars = 'dpi=96&__format=pdf&__pageflow=0&__overwrite=false';  ?>	
<?php else: ?>
	<?php if(empty($students)): ?>
			<a class="button" style="font-size:14px;" href="<?php echo URL.'teachers/bonuses/'.$course['crid'].DS.$sy.DS.$qtr; ?>"> Get Student List </a> 						
	<?php else: ?>	
		<?php if($editable): ?>
			<a class="button" style="font-size:14px;" href="<?php echo URL.'scores/add/'.$course_id.DS.$qtr; ?>"> Add Activity</a> 	
			<a class="button" style="font-size:14px;" href="<?php echo URL.'sam/activities/'.$course['id'].DS.$sy.DS.$data['qtr']; ?>" >Manage Activities</a>	
		<?php endif; ?>
	<?php endif; ?>		
<?php endif; ?>	

<?php $this->shovel('export');  ?>

</p>



<table class='clear gis-table-bordered table-fx table-scores'>

<!-- ====================== header ======================== -->

<?php 

if($_SESSION['settings']['tier_adapter'] != 3){
	require_once('private/scores_header2TDetailed.php');
} else {
	if($kpup){
		require_once('private/scores_header3TRaw.php');		
	} else {
		require_once('private/scores_header2TRaw.php');			
	}
}

?>


<!-- ====================== DATA[SCORES] BELOW  ======================== -->
	

<?php 

if($kpup){
	require_once('private/scores_data3TRaw.php');		
} else {
	require_once('private/scores_data2TRaw.php');			
}


?>




</table>   <!--  scores  -->
</div> 	<!--  printable	-->


<!-- ==================== hidden params or form values =============================== -->


<?php if($is_k12): ?>
	<input type='hidden' name='data[dgr]' value="<?php echo $dgr; ?>">
<?php endif; ?>
	
<input type='hidden' name='data[qtr]' value="<?php echo $data['qtr']; ?>">




</form>




<!--------------------------------------------------------------------->

<script> 

var gurl = 'http://<?php echo GURL; ?>';var hdpass = '<?php echo HDPASS; ?>';


$(function(){ 
	$('#hdpdiv').hide();
	hd();
	columnHighlighting();	
}) 	



</script>

