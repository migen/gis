

<?php 




$deciave_shs=2;
$semOrdinal = ($sem==1)? 'First':'Second';

$intsq1 = filter_var($sq1, FILTER_SANITIZE_NUMBER_INT);
$intsq2 = filter_var($sq2, FILTER_SANITIZE_NUMBER_INT);


?>

<script>
	
	$(function(){
		hd();
	})

</script>


<?php 

$level_id = $classroom['level_id'];
$level_int=$classroom['level_id']-3;

$vpo="4px";	/* vertical padding */
$hpo="2px";	/* horizontal padding */
$color="black";
// $color="red";
$paascu = ($classroom['department_id']==2)? "<span>PAASCU</span> <span class='i' >Accredited</span><br />":NULL;



?>

<style>

	.utdh{
		border-bottom:1px solid black;
		
	}


	.rcard-head {
		display: flex;
		margin:auto;
	}
	.sch-logo {
		margin: 15px 30px 15px 560px;
		padding-right: 20px;
	}
	.sch-info {
		text-align: center;
	}
</style>

<style>


.gis-table-bordered-print th, .gis-table-bordered-print td { border:1px solid #000;}
.gis-table-bordered-attd th, .gis-table-bordered-attd td { border:1px solid #000;}

.tbp th, .tbp td  { padding:<?php echo $vpo.' '.$hpo; ?> ; color:<?php echo $color; ?>;}

.tbl-print { border: 1px solid #000; border-left: 0; border-top: 0; }
.tbl-print th, .tbl-print td  { border-left: 1px solid #000; 
	border-top: 1px solid #000; color:;}
.tbl-print th {color:#000; }
.tbl-print th:first-child, .tbl-print td:first-child { color:; padding-left:6px; }

@media print{@page {size: portrait;}}
table.vc700{width:600px;}
.vc180{width:180px;}
	
div.card{ margin-right:20px; }
table{ table-layout: fixed; } 
	
hr.broken{ background-color:#fff;border:#000 3px dotted;border-style: none none dotted;color:#fff;width:100%; }
div#cutout{}

	
</style>



<?php 

$num_subjects = ($_SESSION['settings']['num_subjects']+1);
$qtr_fg 	  = (4-1);

$tblwidth = "vc700";
$tblsubwidth = "vc500";
$subwidth = "vc200";
$subw = "vc200";
$subfont = "tf14";
$childfont = "tf16";
$blankfont = "tf16";
$legendfont = "tf14";
$attfont = "tf16";
$headrowfont = "tf16";
$attheadrowfont = "tf14";
$docfont = "tf14";
$headerfont = "tf18";
$headfont = "tf16";
$footfont = "tf12";



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
	include_once('rptincs/menu.php');
?>

<?php if(!$is_locked): ?>
<p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED !</p>
<?php endif; ?>


<?php


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades=$student['grades'];
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
	include('rptincs/studinfo.php'); 
	include('rptincs/srgrades.php');
	include('rptincs/attd.php');
	include('rptincs/eligibility_shs.php');
	
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


