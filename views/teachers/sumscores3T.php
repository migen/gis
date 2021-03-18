<?php 

// $data[] = ratings,qtr,current_qtr,is_locked ,students,qg => q4,activities,scores,criteria,course
 // pr($data);
 // pr($students[0]);

$showcid = ($_SESSION['settings']['showcid']==1)? true : false;

 
$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];
$is_k12 	= ($is_k12 && !$is_ps);

$bonusgrade = (BGRADE==1)? true : false;
$bonus 		= (BONUS==1)? true : false;
$bonustotal = (BONUSTOTAL==1)? true : false;
 
// initialization
$subcri_totalmax   =  0;

$activities     = $data['activities'];
$num_activities	= count($activities);
for($i=0;$i<$num_activities;$i++){
	$data['activities'][$i]['passed'] = 0;
	$data['activities'][$i]['failed'] = 0;
}

$qtr = $qtr = $data['qtr'];
$qqtr = 'q'.$data['qtr'];
$dgqtr = 'dg'.$qtr;

/* ===================== FORMULAS : transmute,rating ===================== */



$flrgr = $_SESSION['settings']['floor_grade_ftnv'];








?>




<?php 


// pr($_SERVER); for home link,used by registrar and teacher
$home = $_SESSION['home'];


?>

<h5>
	Summary Class Record
<span class="screen" >	
	| <?php $this->shovel('homelinks',$home); ?>
</span>
</h5>

<div id='printable' >


<!--------------------------------------------------------------------------------------------------------------------------------->


<div class='third'>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Classroom</th><td class="vc200" ><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
	<tr><th class='white headrow'>Subject</th><td><?php echo $course['subject']; ?></td></tr>
	<tr><th class='white headrow'>Teacher</th><td><?php echo $course['teacher']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table>
</div>

<div class="fourth"></div>

<div class='half'>
<table class='gis-table-bordered table-fx f12'>
	
	<tr><th colspan="2" class=''>Legends:</th></tr>
	<tr><th class=''>PNV</th><td>Partial Numerical Value</td></tr>
	<tr><th class=''>Pct</th><td>Percentage Type NOT Raw Score</td></tr>
	<tr><th class=''>Trans (%)</th><td>Actual Percentage NOT Raw Transmuted</td></tr>
	<tr><th class=''>Green box</th><td>Incomplete Record</td></tr>

</table>
</div>

<!--------------------------------------------------------------------------------------------------------------------------------->

<br />

<div class='clear'></div>

<p class="screen"  >
	<a class="button" id="btnExport" style="font-size:14px;" >Excel</a> &nbsp; 
	<a href="<?php echo URL.$home.'/raw/'.$course['id'].DS.$sy.DS.$qtr; ?>" class="button" style="font-size:14px;" > Raw </a> &nbsp; 
	<a href="<?php echo URL.$home.'/scores/'.$course['id'].DS.$sy.DS.$qtr; ?>" class="button" style="font-size:14px;" > Detailed </a> &nbsp; 


	
	<?php if($_SESSION['settings']['with_criteria_ranks']): ?>
	<?php if($kpup): ?>
		<select onchange="subcriteriaRanks(<?php echo $course_id; ?>,this.value,<?php echo $sy.','.$qtr; ?>);"  >
			<option value="0" >Criteria Ranking</option>
			<?php foreach($selects['subcriteria'] AS $sel): ?>
				<option value="<?php echo $sel['subcriteria_id']; ?>" ><?php echo $sel['subcriteria']; ?></option>
			<?php endforeach; ?>
		</select>	
	<?php else: ?>
		<select onchange="criteriaRanks(<?php echo $course_id; ?>,this.value,<?php echo $sy.','.$qtr; ?>);"  >
			<option value="0" >Criteria Ranking</option>
			<?php foreach($selects['criteria'] AS $sel): ?>
				<option value="<?php echo $sel['criteria_id']; ?>" ><?php echo $sel['criteria']; ?></option>
			<?php endforeach; ?>
		</select>	
	<?php endif; ?>		
		&nbsp; Go!
	<?php endif; ?>		
	
	
</p>	
	
<br />

<table id="tblExport"  class='clear gis-table-bordered table-fx table-scores'>

<!-- ====================== header ======================== -->

<?php 

if($_SESSION['settings']['tier_adapter'] != 3){
	require_once('private/scores_header2TSummary.php');
} else {
	if($kpup){
		require_once('private/scores_header3TSummary.php');		
	} else {
		require_once('private/scores_header2TSummary.php');			
	}
}




?>


<!-- ====================== DATA[SCORES] BELOW  ======================== -->
	

<?php 

if($_SESSION['settings']['tier_adapter'] != 3){
	require_once('private/scores_data2TSummary.php');
} else {
	if($kpup){
		require_once('private/scores_data3TSummary.php');		
	} else {
		require_once('private/scores_data2TSummary.php');			
	}
}

?>





</table>   <!--  scores  -->
</div> 	<!--  printable	-->


<!---------------------------------------------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<!---------------------------------------------------------------------------------------------->



<script> 
var gurl = 'http://<?php echo GURL; ?>';
$(function(){ 
	hd(); 
	columnHighlighting();	
	excel();
	
	
}) 	

function excel(){
	$("#btnExport").click(function () {
		$("#tblExport").btechco_excelexport({
			containerid: "tblExport"
		   ,datatype: $datatype.Table
		});
	});

}


function criteriaRanks(crs,cri,sy,qtr){
	var rurl 	= gurl + '/teachers/criteriaRanks/'+crs+'/'+cri+'/'+sy+'/'+qtr;		// redirect url	
	// alert(rurl);
	window.location = rurl;		
}
	
function subcriteriaRanks(crs,cri,sy,qtr){
	var rurl 	= gurl + '/teachers/criteriaRanks/'+crs+'/'+cri+'/'+sy+'/'+qtr;		// redirect url	
	// alert(rurl);
	window.location = rurl;		
}


</script>

