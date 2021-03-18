


<script> $(function(){ 
	// hides(); 
	columnHighlighting();	
}) 	</script>



<?php 


/* $data => ratings,qtr,current_qtr,is_locked,students,qg => q4,activities,scores,criteria,course */

$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];
$is_k12	= $is_k12;



/* initialization */
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


function getFloorGrade($course,$sgs){
	return $sgs['floor_grade'];

}
$flrgr = getFloorGrade($course,$_SESSION['settings']);

$this->shovel('ratings',$ratings);





?>

<!--	<a href="http://localhost:8080/Reports/frameset?__report=qcr.rptdesign">BIRT Report</a>		-->



<?php 


// pr($_SERVER); for home link,used by registrar and teacher
$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			

?>

<h5>
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>

<div id='printable' >

<div class='third'>
<table class='gis-table-bordered table-fx'>
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



<form method='post'>
<?php $num_diff = 0; ?>

<br />

<div class='clear'></div>

<br />
	<a href="<?php echo URL.'etcscores/sumscores/'.$course['id'].DS.$sy.DS.$qtr; ?>" class="button" style="font-size:14px;" >Summary </a> &nbsp; 
<?php if($is_locked): ?>
 
<?php else: ?>
	<a class="button" style="font-size:14px;" href="<?php echo URL.'scores/add/'.$_SESSION['course']['id'].DS.$data['qtr']; ?>"> Add Activity</a> 
	<a class="button" style="font-size:14px;" href="<?php echo URL.'sam/activities/'.$course['id'].DS.$data['qtr']; ?>" >Manage Activities</a>	
<?php endif; ?>	
	
	
<br />
<br />

<table class='clear gis-table-bordered table-fx table-scores'>

<!-- ====================== header ======================== -->

<?php 

require_once('private/scores_header2TDetailed.php');


?>

<!-- ====================== DATA[SCORES] BELOW  ======================== -->
	

<?php 

require_once('private/scores_data2TDetailed.php');

?>




</table>   <!--  scores  -->
</div> 	<!--  printable	-->


<!-- ==================== hidden params or form values =============================== -->


<?php if(!$course['is_ps']): ?>
	<input type='hidden' name='data[dgr]' value="<?php echo $dgr; ?>">
<?php endif; ?>
	
<input type='hidden' name='data[qtr]' value="<?php echo $data['qtr']; ?>">


<?php 
	// echo "num_diff: $num_diff <br />";
?>

<?php if($num_diff && !$is_locked): ?>
	<input type='submit' name='finalize' value='Finalize' onclick="return confirm('You sure?');" />

<?php endif; ?>




</form>

