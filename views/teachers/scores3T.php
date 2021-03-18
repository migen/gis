<style>

#content div { border:1px solid fff; }

.pageHalf{ width:42%;float:left;padding-right:5%;  }
.crsInfo{ width:45%;float:left; }
.crsInfo table { table-layout:auto; }

@media only screen {
	.printLabel{ visibility:collapse; }
	
}


</style>


<?php 

// pr($course);

$size=isset($_GET['size'])? $_GET['size']:1;
$fontwt=isset($_GET['bold'])? 'bold':'normal';
$interval=isset($_GET['interval'])? $_GET['interval']:10;

$ppct=($_SESSION['settings']['passing_pct']/100);
$raw_transmute = $_SESSION['settings']['raw_transmute'];
// * $algo = ($_SESSION['settings']['algo_pct']==1)? 'Pct':'Detailed';
$showcid = ($_SESSION['settings']['showcid']==1)? true : false;

$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];

$bonusgrade=false;$bonus=false;$bonustotal=false;
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



<form method="GET"  >
<h5 class="pagelinks screen" >
	<?php echo ucfirst($algo); ?> 	(<?=$num_students;?>)
	Class Record <?php echo ($_SESSION['settings']['eqvs'])? '(EQ)':NULL; ?>
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('notes');" >Notes</span>		
| <?php if($admin && $is_locked): ?>
	<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
<?php elseif($admin && !$is_locked): ?>
	<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a>			
<?php endif; ?>		

		| <a href='<?php echo URL."teachers/grades/".$course['id']."/$sy/$qtr";  ?>' >Grades</a>					
		| <a href='<?php echo URL."lookups/equivalents?ctype=$ctype";  ?>' >Equivalents</a>					
		| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>'   >Averages</a> 		
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a> 			
		
		<?php if($course['is_aggregate']): ?>
		<?php $par_agg = $course['crid'].DS.$course['course_id'].DS.$course['subject_id'].DS.$sy.DS.$qtr; ?>
		| <a href="<?php echo URL.'aggregates/tally/'.$par_agg; ?>" >Aggregate</a>
		<?php endif; ?>		
	</span>

   Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
   Interval <input class="center vc50" id="interval" name="interval" 
	value="<?php echo (isset($_GET['interval']))? $_GET['interval']:$interval; ?>"  />
<input type="submit" name="submit" value="Go" >	

<br /	><span class="brown" >*Behaviors Append &<span class="" > 1) bold, 2) size=n, 3) hidedg, 4) noteless, 5) interval=n </span>

	
</h5>
</form>		<!-- for size & interval-->
<span class="screen" ><?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?></span>
<script>
	
function redirCtype(){
	var url = gurl+"/teachers/scores/"+crs+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val();
	window.location = url;		
}	/* fxn */
	
</script>

<p class="screen" >
<?php $this->shovel('hdpdiv'); ?>

</p>


<div id='printable' >

<div class='pageHalf screen'>
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
		<td class="" >
			<?php echo ($_SESSION['settings']['is_cluster'])? $_SESSION['brcode']." - ":NULL; ?>
			<?php echo $course['level'].' - '.$course['section'].' - '.$course['label']; ?>
		</td></tr>
<?php if($admin): ?>		
	<tr><th class='white headrow'>Teacher <span class="" >(<?php echo $course['tcid']; ?>)</span></th>
		<td><?php echo $course['teacher'].'<br />'.$course['teacher_code']; ?></td></tr>
<?php endif; ?>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table>
</div>



<div class='pageHalf screen'>
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


<table id="tblExport"  class='clear gis-table-bordered table-fx table-scores' style="font-size:1em;" >


<?php 

require_once('private/scores_header2TDetailed.php');			
require_once("private/scores_data2T{$algo}.php");			



?>

</table>   <!--  scores  -->

</div> 	<!--  printable	-->



<p class="" >
<?php if($is_k12): ?>
	<input type='hidden' name='data[dgr]' value="<?php echo $dgr; ?>">
<?php endif; ?>
	
<input type='hidden' name='data[qtr]' value="<?php echo $data['qtr']; ?>">

<?php if($admin): ?>
	<input type='submit' name='finalize' value='Finalize On' onclick="return confirm('You sure?');" />
<?php endif; ?>

<?php if((!$is_locked) && ($num_crs_components == $num_acts_components)): ?>
	<h5 class="brown" >Please Finalize</h5>
	<input type='submit' name='finalize' value='Finalize'  />
<?php endif; ?>
</p>

<span class="notes hd" >
<?php 
if(!isset($_GET['noteless'])){ $incs = SITE."views/teachers/includes/note_scores.php";include_once($incs); }
?>
</span>

<div class="ht50"></div>


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

