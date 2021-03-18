<script> $(function(){ 
	hd(); 
	columnHighlighting();	
}) 	</script>


<?php 

// $data[] = ratings,qtr,current_qtr,is_locked ,students,qg => q4,activities,scores,criteria,course

 // pr($data);
 
$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];

$is_bedk12 	= ($is_k12 && !$is_ps);
// echo ($is_bedk12)? 'yes bedk12' : 'not bedk12';
 
 
// initialization
$subcri_totalmax   =  0;

$activities     = $data['activities'];
$num_activities	= count($activities);
for($i=0;$i<$num_activities;$i++){
	$data['activities'][$i]['passed'] = 0;
	$data['activities'][$i]['failed'] = 0;
}

$sy = $_SESSION['sy'];
$qtr = $qtr = $data['qtr'];
$qqtr = 'q'.$data['qtr'];
$dgqtr = 'dg'.$qtr;

/* ===================== FORMULAS : transmute,rating ===================== */


$flrgr = $_SESSION['settings']['floor_grade_ftnv'];

/* ===================== letter equivalent from db-table descriptions ===================== */

$this->shovel('ratings',$ratings);

// ===================== FORMULAS =====================





?>

<!--	<a href="http://localhost:8080/Reports/frameset?__report=qcr.rptdesign">BIRT Report</a>		-->




<!---------------------------------------------------------------------------------------------------------------->

<?php 

// pr($_SERVER); for home link,used by registrar and teacher
$home = $_SESSION['home']; 			

?>

<h5>
	<?php $this->shovel('homelinks',$home); ?>
</h5>
<!---------------------------------------------------------------------------------------------------------------->

<div id='printable' >

<div class='third'>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>CrsID</th><td><?php echo $course['id']; ?></td></tr>
	<tr><th class='white headrow'>Level</th><td><?php echo $course['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $course['section']; ?></td></tr>
	<tr><th class='white headrow'>Subject</th><td><?php echo $course['subject']; ?></td></tr>	
</table>
</div>

<div class='half'>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>CrID</th><td><?php echo $course['crid']; ?></td></tr>
	<tr><th class='white headrow'>Course</th><td><?php echo $course['name']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table>
</div>


<br />

<div class='clear'></div>

<br />
	<a href="<?php echo URL.$home.'/raw/'.$course['id'].DS.$sy.DS.$qtr; ?>" class="button" style="font-size:14px;" > Raw </a> &nbsp; 
	<a href="<?php echo URL.$home.'/scores/'.$course['id'].DS.$sy.DS.$qtr; ?>" class="button" style="font-size:14px;" > Detailed </a> &nbsp; 
<?php if($is_locked): ?>
	<?php 	$printVars = 'dpi=96&__format=pdf&__pageflow=0&__overwrite=false';  ?>
	<a target = "_blank" class="button" style="font-size:14px;"  href="<?php echo REPORT.'class_record.rptdesign&level='.$course['level_id'].'&section='.$course['section_id'].'&course_id='.$course['course_id'].'&qtr='.$data['qtr'].'&sy='.$sy.'&__'.$printVars;  ?>"   > Print Detailed </a> &nbsp; 
	<a target = "_blank" class="button" style="font-size:14px;"  href="<?php echo REPORT.'class_summary.rptdesign&level='.$course['level_id'].'&section='.$course['section_id'].'&course_id='.$course['course_id'].'&qtr='.$data['qtr'].'&sy='.$sy.'&__'.$printVars;  ?>"   > Print Summary </a>
<?php else: ?>
	<a class="button" style="font-size:14px;" href="<?php echo URL.'scores/add/'.$_SESSION['course']['id'].DS.$data['qtr']; ?>"> Add Activity</a> 
	<a class="button" style="font-size:14px;" href="<?php echo URL.'sam/activities/'.$course['id'].DS.$data['qtr']; ?>" >Manage Activities</a>	
<?php endif; ?>	
	
	
<br />
<br />

<table class='clear gis-table-bordered table-fx table-scores'>

<!-- ====================== header ======================== -->

<?php 

require_once('private/scores_headerTier2Summary.php');


?>

<!-- ====================== DATA[SCORES] BELOW  ======================== -->
	

<?php 

require_once('private/scores_dataTier2Summary.php');

?>




</table>   <!--  scores  -->
</div> 	<!--  printable	-->


