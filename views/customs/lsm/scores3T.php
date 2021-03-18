<style>

.scores-gis-table-bordered { border: 1px solid #dddddd; border-left: 0; border-top: 0; }
.scores-gis-table-bordered th, .scores-gis-table-bordered td  
{ border-left: 1px solid #dddddd;  border-top: 1px solid #dddddd; padding:1px 1px; }
.scores-gis-table-bordered th {color:#181818; }



</style>

<?php 

$tblcls=(isset($_GET['printout']))? 'scores-gis-table-bordered':'gis-table-bordered';

$size=isset($_GET['size'])? $_GET['size']:1;
$interval=isset($_GET['interval'])? $_GET['interval']:10;

$ppct=($_SESSION['settings']['passing_pct']/100);
$raw_transmute = $_SESSION['settings']['raw_transmute'];
// $algo = ($_SESSION['settings']['algo_pct']==1)? 'Pct':'Detailed';
$algo="Detailed";
$showcid = ($_SESSION['settings']['showcid']==1)? true : false;

$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];

$bonusgrade = false;
$bonus 		= false;
$bonustotal = false;
 
$subcri_totalmax   =  0;

$num_activities	= count($activities);
for($i=0;$i<$num_activities;$i++){
	$data['activities'][$i]['passed'] = 0;
	$data['activities'][$i]['failed'] = 0;
}

$qqtr = 'q'.$data['qtr'];
$dgr = 'dg'.$qtr;

/* -------------------------- FORMULAS : transmute,rating -------------------------- */


$flrgr = $_SESSION['settings']['floor_grade_ftnv'];
$scores_tnv = $_SESSION['settings']['scores_tnv'];
$scores_pnv = $_SESSION['settings']['scores_pnv'];
$scores_trns = $_SESSION['settings']['scores_trns'];
$scores_raw = $_SESSION['settings']['scores_raw'];
$scores_equiv = $_SESSION['settings']['scores_equiv'];






?>


<?php if($num_students != $num_scores): ?>
<p><?php 
	echo "Number of Grades: $num_scores <br />";
	echo "Number of Students: $num_students <br />";
?>
<a onclick="return confirm('Confirm?');" class="button" href='<?php echo URL."utils/cleanCourseGrades/$crid/$course_id/$sy"; ?>' >Sync Grades</a>
<a class="button" href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>' >Manage</a>

</p>	

<?php endif; ?>




<?php include_once('private/scores_links.php'); ?>

<span class="screen" >
<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
	
?>
</span>
<script>
	
function redirCtype(){
	var url = gurl+"/teachers/scores/"+crs+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val();
	window.location = url;		
}	/* fxn */
	
</script>




<!------ tracelogin --------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<div id='printable' >

<?php include_once('private/scores_head_lsm.php'); ?>



<form method='post'>
<?php $num_diff = 0; ?>

<br />

<div class='clear'></div>



<p class="screen" >
<span class="hd" >Locking: 
<?php if($is_locked): ?>
	<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
<?php else: ?>
	<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a>			
<?php endif; ?>		
	<span class="hd" > | <?php echo $course['teacher_code']; ?></span>
</span>
</p>

<div class="miscDiv" >
	<span class="screen" >
		<a class="button" id="btnExport" style="font-size:14px;" >Excel</a> &nbsp; 
	<?php if(!$is_locked): ?>
		<?php if(empty($students)): ?>
				<a class="button" style="font-size:14px;" href="<?php echo URL.'teachers/bonuses/'.$course['crid'].DS.$sy.DS.$qtr; ?>"> Get Student List </a> 						
		<?php else: ?>	
		<span style="font-size:14px;" >
		<a class="button" href='<?php echo URL."scores/add/$course_id/$qtr"; ?>'> Add Activity</a> 	
		<a class="button" href='<?php echo URL."sam/activities/$course_id/$sy/$qtr"; ?>' >Manage Activities</a>
		</span>
		<?php endif; ?>		
	<?php endif; ?>	
	</span>
	<span style="width:50px;" >&nbsp;</span>
	<span class="red" >
		<?php if($num_crs_components != $num_acts_components): ?>
			Incomplete Components!
		<?php else: ?>	
			<?php if(!$is_locked): ?>
				Please Finalize!
			<?php endif; ?>	
		<?php endif; ?>	
	</span>
	<span style="width:50px;" >&nbsp;</span>	
	<span class="printLabel" ><?php echo 'Course: '.$course['name'].' Teacher:'.$qtr.' Qtr:'.$qtr; ?></span>

</div>	<!-- miscDiv -->
<br />




<table id="tblExport"  class='clear <?php echo $tblcls; ?> table-fx table-scores' >
<?php 
	require_once('private/scores_header2TDetailed.php');			
	require_once("private/scores_data2T{$algo}.php");			
?>
</table>   <!--  scores  -->



</div> 	<!--  printable	-->



<p class="screen ht50" >
<?php if($is_k12): ?>
	<input type='hidden' name='data[dgr]' value="<?php echo $dgr; ?>">
<?php endif; ?>
	
<input type='hidden' name='data[qtr]' value="<?php echo $data['qtr']; ?>">

<?php if($admin): ?>
	<input type='submit' name='finalize' value='Finalize On' onclick="return confirm('You sure?');" />
<?php endif; ?>

<?php if((!$is_locked) && ($num_crs_components == $num_acts_components)): ?>
	<input type='submit' name='finalize' value='Finalize'  />
<?php endif; ?>



</p>

<?php if(!$is_expired): ?>
<?php if(!isset($_GET['noteless'])): ?>
	<div class="screen" >
		<?php $incs = SITE."views/teachers/includes/note_scores.php"; include_once($incs); ?>
	</div>
<?php endif; ?>
<?php endif; ?>	<!-- !expired -->


</form>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<!---------------------------------------------------------------------------------------------->


<script> 

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';
var crs 	= '<?php echo $course_id; ?>';
var sy	 	= '<?php echo $sy; ?>';
var qtr 	= '<?php echo $qtr; ?>';
var ds 		= '/';


$(function(){ 
	$('#hdpdiv').hide();
	$('#uhdp').focus();
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



</script>

