<link type='text/css' rel='stylesheet' href="<?php echo URL.'public/css/style_long.css'; ?>" />    

<?php 
	$headspacer="0.0in";
	$vpl="0px";	/* vertical padding left table */
	$vpr="2px";	/* vertical padding right table */
	$ftw="4.4in"; 	/* full table width */
	$htw="2.1in"; 	/* half table width */
	$trw="2.6in"; 	/* traits width or cav indicator width */
	$subw="2.2in"; 	/* grades subjects width */
	$qw="0.4in"; 	/* grades subjects width */
	$frw="0.5in"; 	/* final rating width */
	

	
?>

<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';

$(function(){ })

</script>


<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/reports.css" />
<style>

.tbp-left th, .tbp-left td  { padding:<?php echo $vpl; ?> 0px; color:;}
.tbp-right th, .tbp-right td  { padding:<?php echo $vpr; ?> 0px; color:;}

/* custom */
div{border:1px solid white; }
#content{color:auto;margin:auto;border:1px solid white;}
div.divheader{margin:0 auto;border:none;}
div.divattd{ position:relative;top:0in; }
div.divleft,div.divright{float:left;width:4.7in;margin:auto;}
div.divleft{margin-right:0.2in;}
table{ table-layout: fixed; } 
@media print{@page{size:landscape} .screen{display:none;} body{font-size:8pt;} }

.gis-table-bordered-print th:first-child, .gis-table-bordered-print td:first-child { color:; padding-left:6px; }



</style>


<?php 

?>


<?php 


include('rptincs/menulinks.php');


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades  = $students[$i]['grades'];
	
	ob_start();	

?>

<div class="unbordered clear" style="min-height:<?php echo $headspacer; ?>;" ></div>

<div class="divheader center" >
	<?php include('rptincs/rptheader_logo.php'); ?>
</div>




<div class="divstudent clear" style="width:9.5in;" >
	<?php include('rptincs/studinfo.php'); ?>
</div>

<div class="divleft" >
	<?php include('rptincs/guardian.php'); ?>
	<?php include('rptincs/grades_attdqtr_hs.php'); ?>
	<div class="" ><br /><?php include('rptincs/legends_hs.php'); ?></div>
	<div class="clear" >&nbsp;</div>
	<div class="unbordered" ><?php include('rptincs/signature_parents_hs.php'); ?></div>
	<div class="" ><br /><?php include('rptincs/signed_adviser.php'); ?></div>	
	
</div>


<div class="divright" >
	<?php include('rptincs/rpttraitshs.php'); ?>
	<div class="clear" >&nbsp;</div>	
	<div class="" ><?php include('rptincs/eligibility_hs.php'); ?></div>
</div>

<div class='clear pagebreak'>&nbsp; </div>
<?php endfor; ?>

