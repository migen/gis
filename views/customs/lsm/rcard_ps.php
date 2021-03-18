<link type='text/css' rel='stylesheet' href="<?php echo URL.'public/css/style_long.css'; ?>" />    

<?php 
	$headspacer="0.1in";
	$vpl="3px";	/* vertical padding left table */
	$vpr="0px";	/* vertical padding right table for traits */
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
div.divleft,div.divright{float:left;width:4.7in;height:5.8in;margin:auto;}
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
	<?php include('rptincs/rptstudent.php'); ?>
</div>

<div class="divleft" >
	<?php include('rptincs/grades_attdqtr_ps.php'); ?>
	<div class="" ><br /><?php include('rptincs/legends_ps.php'); ?></div>
</div>


<div class="divright" >
	<div class="" style="padding:0;margin:0;" ><br /><?php include('rptincs/traits_ps.php'); ?></div>
</div>

<p class='clear pagebreak'>&nbsp; </p>
<?php endfor; ?>

