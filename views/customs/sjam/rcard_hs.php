<style>
	.colQtr{ width:45px; }	
	.vcid{ width:26%;}
	div.left{ float:left; }
	
	
</style>



<script>
	
	$(function(){
		hd();
	})

</script>



<?php 


$is_ec=$classroom['is_free']? 1:0;
// require_once(SITE.'views/customs/sjam/rptincs/rcard_viewing_conditions_sjam.php');

// $allowed=true;
// if($is_ec){
	// $allowed=canViewRcardConditionsEC();
// }

// if(!$allowed){ flashRedirect('/','Not allowed'); }


require_once(SITE.'functions/rcardFxn.php');

$allowed=studentCanViewCurrentRcardOnly($sy);
if(!$allowed){ 
	$msg = "Denied - NOT current year.";
	flashRedirect('',$msg); 
}


$src_signature_principal = URL."views/customs/sjam/incs/signature_principal.png";
$signature_rcard=$_SESSION['settings']['signature_rcard'];

$is_free=$classroom['is_free'];


$level_id = $classroom['level_id'];
$vpo="4px";	/* vertical padding */
$hpo="2px";	/* horizontal padding */
$color="black";
$paascu = ($classroom['department_id']==2)? "<span>PAASCU</span> <span class='i' >Accredited</span><br />":NULL;

include_once('rptincs/rcardFxns.php');
include_once('rptincs/css_vars.php');
include_once('rptincs/menu.php');

$ordinalQtr=getOrdinalName($qtr);
$txtqtr=getOrdinal($qtr);




?>

<!-- sjam rcard -->
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />


<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	hd();

})

</script>




<?php if(!$is_finalized): ?>
<p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED!</p>
<?php endif; ?>


<?php


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades  = $students[$i]['grades'];
	ob_start();	

	if($qtr>3){ include('rptincs/status.php'); }
	
?>


<?php $hd = ($student['is_active']!=1)? 'hd':NULL; ?>
<div class="page clear center card" > <!-- student start -->

<div class="vspacer" style="height:0.2in;"  >&nbsp;</div>
<div class="center" > 
	<?php 

/* 		
		if($is_free){		
			include('rptincs/header_hs_free.php');	
		} else {
			include('rptincs/header_hs.php'); 						
		} 
*/

		if($is_ec){		
			include('rptincs/header_hs_ec.php');	
		} else {
			include('rptincs/header_hs.php'); 						
		} 

	?>	
</div>

<div class="<?php echo $tblwidth; ?> clear" ><hr /></div>
<div class="center full" >
<?php 
	include('rptincs/studinfo.php'); 
	include('rptincs/grades_attdqtr.php');
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


