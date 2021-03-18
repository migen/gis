<style>

@media print { 
 .print { display: none !important; } 
}

</style>




<?php 

// pr($_SESSION['q1']);
// pr($students[0]);
// pr($scores[0][0]);
// pr($ratings);

$dbg=PDBG;
$dbtable="{$dbg}.10_grades";
$gender_colspan=($num_activities+13);
$showucid=0;
$editable=1;


$size=isset($_GET['size'])? $_GET['size']:1;
$interval=isset($_GET['interval'])? $_GET['interval']:10;
$pg=$_SESSION['college']['passing_grade'];
$flrgr=$_SESSION['college']['floor_grade'];
$deciscores=$_SESSION['college']['deciscores'];
$decicard=$_SESSION['college']['decicard'];
$decipnv=$_SESSION['college']['decipnv'];
$ppct=($_SESSION['college']['passing_pct']/100);
$raw_transmute=$_SESSION['college']['raw_transmute'];
$numcols=($showucid)? 10 : 9;  $rank=1; 


for($i=0;$i<$num_activities;$i++){
	$data['activities'][$i]['passed']=0;
	$data['activities'][$i]['failed']=0;
}

/* ------  FORMULAS : transmute,rating ------- */







?>



<h5 class="screen" >		
	LSM <?php echo ucfirst($algo); ?> Scores <?php echo (!$is_numeric)? '| *DG':NULL; ?>
	| <a href="<?php echo URL.'professors'; ?>" >Professor</a>	
	| <?php echo ($is_locked)? 'Closed':'Open'; ?>
	| <?php $this->shovel('homelinks'); ?>	
	| <a href="<?php echo URL.'uniscores/crs/'.$crs.'&tpl=crs'; ?>" >Crs</a>
	| <a href="<?php echo URL.'uniscores/crs/'.$crs.'&tpl=std'; ?>" >Std</a>
	| <a href="<?php echo URL.'unigrades/crs/'.$crs; ?>" >Grades</a>
	| <a href="<?php echo URL.'uniscores/add/'.$crs; ?>" >+Scores</a>
	| <span class="u" id="btnExport"  >Excel</span> 

	<span class="hd" >| <a href="<?php echo URL.'unicourses/view/'.$crs; ?>" >Course</a></span>

	<span class="hd" ><?php if($is_locked): ?>
		| <a href="<?php echo URL.'unilocks/unlockCrs/'.$crs; ?>" >Unlock</a>
	<?php else: ?>
		| <a href="<?php echo URL.'unilocks/lockCrs/'.$crs; ?>" >Lock</a>
	<?php endif; ?></span>
	
</h5>


<!--- tracelogin ----> <p><?php $this->shovel('hdpdiv'); ?></p>


<?php if($crs_num_components!=$acty_num_components): ?><h4 class="red" >Incomplete Components!</h4><?php endif; ?>	




<form method='post'>
<table id="tblExport"  class="clear gis-table-bordered table-fx table-scores" style="font-size:<?php echo $size; ?>em;" >
<?php 
	require_once('uniscores_header.php');
	require_once('uniscores_body.php');
?>

</table>   <!--  scores  -->

<p class="screen" >
<?php if((!$is_locked) && ($crs_num_components == $acty_num_components)): ?>
	<input type="submit" name="submit" value="Save"  />
	<input type="submit" name="finalize" value="Finalize"  />
<?php endif; ?>
</p>

</form>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



<script> 

var gurl="http://<?php echo GURL; ?>";
var hdpass="<?php echo HDPASS; ?>";
var crs="<?php echo $crs; ?>";
var sy="<?php echo $sy; ?>";
var ds="/";
var dbtable="<?php echo $dbtable; ?>";

$(function(){ 
	$('#hdpdiv').hide();
	$('.legends').hide();
	$('#uhdp').focus();
	hd();
	columnHighlighting();	
	excel();
	
}) 	


function xeditData(i){
	var id=$('input[name="grades['+i+'][gid]"]').val();
	var bonus=$('input[name="grades['+i+'][bonus]"]').val();
	var vurl=gurl+'/ajax/xsaveData.php';	
	var task="xeditData";	
	
	$.ajax({
		url:vurl,type:"POST",data:"task="+task+"&dbtable="+dbtable+"&bonus="+bonus+"&id="+id,
		success: function() { location.reload(); }		  
    });				
	
}	/* fxn */




</script>

