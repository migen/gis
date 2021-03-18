<style>

@media print { 
 .print { display: none !important; } 
}

</style>




<?php 

function getRoot($db,$dbo){
	$q="SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE id=1 LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;	
}	/* fxn */


function getSac($db,$dbg,$dbo,$dept_id,$subject_id){
	$q="SELECT sc.hcid,c.name AS sac FROM {$dbo}.`00_contacts` AS c 
	INNER JOIN {$dbo}.`05_subjects`_coordinators AS sc ON sc.hcid=c.id 
	WHERE sc.department_id='$dept_id' AND sc.subject_id='$subject_id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;	
}	/* fxn */

/* signatures */
$sacrow=getSac($db,$dbg,$dbo,$dept_id,$subject_id);
$sac=$sacrow['sac'];
$teacher=$course['teacher'];
$vice_principal=$_SESSION['settings']['school_principal_'.$deptcode];
$principal=$_SESSION['settings']['school_principal'];

function is_free($db,$dbg,$course_id){
	$q="SELECT crs.id AS crs,crs.crid,cr.is_free FROM {$dbg}.05_courses AS crs INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid
		WHERE crs.id='$course_id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;	
}	/* fxn */

$ecrow=is_free($db,$dbg,$course_id);
$is_ec=($ecrow['is_free']==1)? 1:0;
if($is_ec){ $principal=$_SESSION['settings']['principal_ec']; }



$size=isset($_GET['size'])? $_GET['size']:1;
$interval=isset($_GET['interval'])? $_GET['interval']:10;

$ppct=($_SESSION['settings']['passing_pct']/100);
$raw_transmute = $_SESSION['settings']['raw_transmute'];
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



<h5 class="screen" >
	<?php echo ucfirst($algo); ?> 	
	SJAM Class Record <?php echo ($_SESSION['settings']['eqvs'])? '(EQ)':NULL; ?>
	<span class="screen" >
		| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
		<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	<span class="hd" ><a href="<?php echo URL.'purge/activitiesScores/'.$course_id.DS.$sy.DS.$qtr; ?>" >
		| PurgeActivitiesScores</a></span>		
| <?php if($admin && $is_locked): ?>
	<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
<?php elseif($admin && !$is_locked): ?>
	<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a>			
<?php endif; ?>		
			
		| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>'   >Averages</a> 		
		| <a href='<?php echo URL."teachers/grades/$course_id/$sy/$qtr"; ?>'   >Grades</a> 		
		| <a href='<?php echo URL."grades/dg/$course_id/$sy/$qtr"; ?>'   >DG Only</a> 		
		| <a href='<?php echo URL."etcscores/raw/$course_id/$sy/$qtr"; ?>' >Raw</a> 		
		
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a> 			
	| <a href='<?php echo URL."scores/sync/$course_id/$sy/$qtr"; ?>' >Sync</a> 			
	
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr?sort=c.position"; ?>' >Position</a> 		
<?php endif; ?>
		| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr"; ?>' >Single</a> 		
		| <span class="u" onclick="pclass('legends')" >Legends</span>
		<?php if($course['is_aggregate']): ?>
		<?php $par_agg = $course['crid'].DS.$course['course_id'].DS.$course['subject_id'].DS.$sy.DS.$qtr; ?>
		| <a href="<?php echo URL.'aggregates/tally/'.$par_agg; ?>" >Aggregate</a>
		<?php endif; ?>		
	</span>
	| <span class="u" id="btnExport"  >Excel</span> 

<form method="GET" style="display:inline;" >
	| Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
	<input type="submit" name="submit" value="Go" >	
</form>			
	
</h5>



<p><?php $this->shovel('hdpdiv'); ?></p>

<?php if($num_crs_components != $num_acts_components): ?>
	<h4 class="red" >Incomplete Components!</h4>
<?php endif; ?>	

<?php // pr($course); ?>
<?php $d['title']="Rating Sheet - Q$qtr<br />".$course['name']; ?>
<?php $this->shovel('letterhead',$d); ?>



<form method='post'>
<?php $num_diff = 0; ?>

<br />

<div class='clear'></div>



<p class="screen" >

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

require_once('private/scores_header2TDetailed_multiple.php');			
require_once("private/scores_data2T{$algo}_multiple.php");			


?>

</table>   <!--  scores  -->

</div> 	<!--  printable	-->



<p class="screen" >
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


<div class="ht50" ></div>
<?php $signatures="private/signatures.php";include_once($signatures); ?>
<div class="ht50 clear" ></div>
<div class="clear" style="padding-left:50px;"  ><?php include_once('private/scores_header.php'); ?></div>
<div class="ht100" ></div>


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
	$('.legends').hide();
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

