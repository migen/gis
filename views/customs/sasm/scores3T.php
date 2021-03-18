<?php 

$size=isset($_GET['size'])? $_GET['size']:1;
$interval=isset($_GET['interval'])? $_GET['interval']:10;

$ppct=($_SESSION['settings']['passing_pct']/100);
$raw_transmute = $_SESSION['settings']['raw_transmute'];
// $algo = ($_SESSION['settings']['algo_pct']==1)? 'Pct':'Detailed';
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




<h5>
	<?php echo ucfirst($algo); ?> 	
	SASM Class Record <?php echo ($_SESSION['settings']['eqvs'])? '(EQ)':NULL; ?>
	<span class="screen" >
		| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
		<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
| <?php if($admin && $is_locked): ?>
	<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
<?php elseif($admin && !$is_locked): ?>
	<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a>			
<?php endif; ?>		
		
		| <a href='<?php echo URL."lookups/equivalents?ctype=$ctype";  ?>' >Equivalents</a>					
		| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>'   >Averages</a> 		
		| <a href='<?php echo URL."teachers/grades/$course_id/$sy/$qtr"; ?>'   >Grades</a> 		
		| <a href='<?php echo URL."grades/dg/$course_id/$sy/$qtr"; ?>'   >DG Only</a> 		
		| <a href='<?php echo URL."etcscores/raw/$course_id/$sy/$qtr"; ?>' >Raw</a> 		
	
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr?order=c.position"; ?>' >Position</a> 		
<?php endif; ?>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a> 			
	| <a href='<?php echo URL."scores/sync/$course_id/$sy/$qtr"; ?>' >Sync</a> 			
		
		<?php if($course['is_aggregate']): ?>
		<?php $par_agg = $course['crid'].DS.$course['course_id'].DS.$course['subject_id'].DS.$sy.DS.$qtr; ?>
		| <a href="<?php echo URL.'aggregates/tally/'.$par_agg; ?>" >Aggregate</a>
		<?php endif; ?>		
	</span>

	
</h5>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>
<script>
	
function redirCtype(){
	var url = gurl+"/teachers/scores/"+crs+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val();
	window.location = url;		
}	/* fxn */
	
</script>


<p><?php $this->shovel('hdpdiv'); ?></p>


<div id='printable' >

<div class='third'>
<table class='gis-table-bordered table-fx' width="100%" >
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a>			
			<?php endif; ?>		
			<span class="hd" > | <?php echo $course['teacher_code']; ?></span>
	</td></tr>
	<tr><th class='vc100 white headrow'>Course<span class="screen hd" >(<?php echo '&nbsp;'.$crid; ?>)</span></th>
		<td class="" ><?php echo $course['level'].' - '.$course['section'].' - '.$course['label']; ?></td></tr>
<?php if($admin): ?>		
	<tr><th class='white headrow'>Teacher <span class="" >(<?php echo $course['tcid']; ?>)</span></th>
		<td><?php echo $course['teacher'].'<br />'.$course['teacher_code']; ?></td></tr>
<?php endif; ?>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table>

<?php if($num_crs_components != $num_acts_components): ?>
	<h4 class="red" >Incomplete Components!</h4>
<?php endif; ?>	

<?php if(!$is_locked): ?>
	<h4 class="red" >Average > Finalize</h4>
<?php endif; ?>	

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


<form method='post'>
<?php $num_diff = 0; ?>

<br />

<div class='clear'></div>



<p class="screen" >
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



</p>


<table id="tblExport"  class='clear gis-table-bordered table-fx table-scores' style="font-size:1em;" >


<?php 
// pr($algo);
require_once('private/scores_header2TDetailed.php');			
require_once("private/scores_data2T{$algo}.php");			


?>

</table>   <!--  scores  -->

</div> 	<!--  printable	-->



<p>
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


<?php 

$incs = SITE."views/teachers/includes/note_scores.php";
include_once($incs);

?>


</form>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



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

