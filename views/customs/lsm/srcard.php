<link type='text/css' rel='stylesheet' href="<?php echo URL.'public/css/style_long.css'; ?>" />    

<?php 


// pr($data);

	$headspacer="0.1in";
	$vpl="0px";	/* vertical padding left table */
	$vpr="2px";	/* vertical padding right table */
	$ftw="4.4in"; 	/* full table width */
	$htw="2.1in"; 	/* half table width */
	$trw="2.6in"; 	/* traits width or cav indicator width */
	$subw="2.2in"; 	/* grades subjects width */
	$qw="0.4in"; 	/* grades subjects width */
	$frw="0.5in"; 	/* final rating width */


	
	
// pr($cola);
// pr($colb);



include('rptincs/css.php');
include('rptincs/menulinks.php');


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];	
	$ones  = isset($students[$i]['ones'])? $students[$i]['ones']:NULL;
	$twos  = isset($students[$i]['twos'])? $students[$i]['twos']:NULL;		
	ob_start();	

?>


<div class="unbordered clear" style="min-height:<?php echo $headspacer; ?>;" ></div>

<div class="divheader center" >
	<?php include('rptincs/rptheader_logo.php'); ?>
</div>




<div class="divstudent clear" style="width:9.5in;" >
	<?php include('rptincs/studinfo_shs.php'); ?>
</div>

<div class="divleft" >
	<?php include('rptincs/rptsrgrades.php'); ?>
	<?php include('rptincs/oave_shs.php'); ?>	

	
	<div class="divattd" ><?php include('rptincs/attdqtr.php'); ?></div>
	<div class="" ><br /><?php include('rptincs/legends_hs.php'); ?></div>	
</div>


<div class="divright" >
	<?php include('rptincs/rpttraits.php'); ?>
	<div class="" ><br /><?php include('rptincs/eligibility_shs.php'); ?></div>
	<div class="" ><br /><?php include('rptincs/signed_principal_shs.php'); ?></div>	
</div>


<p class='clear pagebreak'>&nbsp; </p>



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

