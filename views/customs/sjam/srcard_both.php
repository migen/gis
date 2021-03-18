<?php 

// pr($both);

if($both==0){
	require_once('srcard.php');
	exit;
}

$is_free=$classroom['is_free'];
$deciave_shs=2;
$semOrdinal = ($sem==1)? 'First':'Second';

$intsq1 = filter_var($sq1, FILTER_SANITIZE_NUMBER_INT);
$intsq2 = filter_var($sq2, FILTER_SANITIZE_NUMBER_INT);

$grades=array_merge($students[0]['ones'],$students[0]['twos']);
$numones=count($students[0]['ones']);
$numtwos=count($students[0]['twos']);
$numgrades=count($grades);


$vpo="4px";	/* vertical padding */
$hpo="2px";	/* horizontal padding */
$color="black";


// exit;

?>






<script>
	
	$(function(){
		hd();
	})

</script>


<?php 

// $level_id = $classroom['level_id'];
// $vpo="4px";	/* vertical padding */
// $hpo="2px";	/* horizontal padding */
// $color="black";
// $paascu = ($classroom['department_id']==2)? "<span>PAASCU</span> <span class='i' >Accredited</span><br />":NULL;

// pr($students[0]['ones'][1]);
// pr($students[0]['twos'][1]);


?>

<style>



	
</style>



<?php 


$logo_src = URL."public/images/weblogo_{$sch}.png";
$nsy = $sy+1;




?>

<!-- sjsp rcard -->

<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />




<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	hd();

})

</script>


<?php 



$passing        = $_SESSION['settings']['passing_grade'];
$rcardteac      = $_SESSION['settings']['rcardteac'];
$deciatt    	= $_SESSION['settings']['deciatt'];
$decifg    	    = $_SESSION['settings']['decifg'];
$decicard       = $_SESSION['settings']['decicard'];
$deciranks      = $_SESSION['settings']['deciranks'];
$deciconducts   = $_SESSION['settings']['deciconducts'];
$decifconducts  = $_SESSION['settings']['decifconducts'];
$deciave     = $_SESSION['settings']['deciave'];
$decigenave     = $_SESSION['settings']['decigenave'];
$decifgenave    = $_SESSION['settings']['decifgenave'];





?>


<!------------------------------------------------------------------------------------->

<?php 	
	include_once('rptincs/rcardFxns.php');
	include_once('rptincs/css_vars.php');
	include_once('rptincs/menu.php');	
	
	$ordinalQtr=getOrdinalName($qtr);
	$txtqtr=getOrdinal($qtr);
	
	
?>

<?php if(!$is_locked): ?>
<p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED !</p>
<?php endif; ?>


<?php


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades=array_merge($student['ones'],$student['twos']);
	
	// pr($grades[1]);
	// echo '<hr />';pr($grades[11]);
	// exit;
	
	ob_start();	
	
	if($qtr>3){ include('rptincs/status.php'); }

?>


<?php $hd = ($student['is_active']!=1)? 'hd':NULL; ?>
<div class="page clear center card" > <!-- student start -->

<div class="vspacer" style="height:0.2in;"  >&nbsp;</div>
<div class="center" > 
<?php include('rptincs/header_shs.php'); ?>	
</div>

<div class="<?php echo $tblwidth; ?> clear" ><hr /></div>
<div class="center full" >
<?php 
	include('rptincs/studinfo_shs.php'); 
	include('rptincs/srgrades_attd_both.php');
	include('rptincs/eligibility.php');
	
?>

</div>	<!-- rcardhalfLeft-->
</div> 	<!-- per student wrapper -->


<p class='pagebreak'>&nbsp; </p>


<?php
	
	$ob = "ob$i";
	$$ob = ob_get_clean();
	ob_flush();

	endfor; 	/* loop students  */
 
	for($j=0;$j<$num_students;$j++){
		$ob = "ob$j";
		echo $$ob;

	}	
 

?>


