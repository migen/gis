
<style>
div{ border:1px solid white;}

</style>

<script>
	
	$(function(){
		hd();
	})

</script>

<?php 

// pr($data);

$src_signature_principal = URL."views/customs/sjam/incs/signature_principal.png";
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


$semtext=($qtr>3)? "SECOND SEMESTER":"FIRST SEMESTER";


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


<?php if($srid!=RSTUD): ?>
	<?php if(!$is_locked): ?>
	<p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED !</p>
	<?php endif; ?>
<?php endif; ?>

<p class='pagebreak'>&nbsp; </p>


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
<?php  include('rptincs/header_ps.php'); ?>	
</div>

<div class="<?php echo $tblwidth; ?> clear" ><hr /></div>
<div class="center full" >
<?php 
	include('rptincs/studinfo.php'); 
	include('rptincs/grades_ps_attdsem.php');
	include('rptincs/trs_sem.php');
	?>
	
<div class="center clear" ><?php include('rptincs/legends_p2p3.php'); ?></div>

<?php
	
	include('rptincs/eligibility_ps.php');
	
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


