<link type='text/css' rel='stylesheet' href="<?php echo URL.'public/css/style_long.css'; ?>" />    

<style>


</style>

<?php 
	// pr($data);

?>


<?php 
	$headspacer="0.1in";
	$vpl="2.4px";	/* vertical padding left table */
	$vpr="1px";	/* vertical padding right table */
	$ftw="4.4in"; 	/* full table width */
	$htw="2.1in"; 	/* half table width */
	$trw="2.6in"; 	/* traits width or cav indicator width */
	$subw="2.2in"; 	/* grades subjects width */
	$qw="0.4in"; 	/* grades subjects width */
	$frw="0.5in"; 	/* final rating width */
	


include('rptincs/css.php');
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

<div class="divleft unbordered" >
	<?php include('rptincs/grades_attdqtr.php'); ?>
	<div class="" ><br /><?php include('rptincs/legends_gs.php'); ?></div>
	<div class="" ><br /><?php include('rptincs/signed_adviser.php'); ?></div>	
	
</div>



<div class="divright unbordered" style="" >
	<?php include('rptincs/rpttraits.php'); ?>
	<div class="" ><br /><?php include('rptincs/legendctr_gs.php'); ?></div>
	<div class="" ><br /><?php include('rptincs/eligibility_gs.php'); ?></div>
</div>


<p class='clear pagebreak'>&nbsp;</p>

<?php
	
$ob = "ob$i";
$$ob = ob_get_clean();
ob_flush();
endfor; 	/* students */

 
for($j=0;$j<$num_students;$j++){
	$ob = "ob$j";
	echo $$ob;
	
}	
 

?>


