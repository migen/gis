<script>
	
	$(function(){
		hd();
	})

</script>



<?php 

// pr($students[0]['attendance']);exit;

$level_id = $classroom['level_id'];
$vpo="4px";	/* vertical padding */
$hpo="2px";	/* horizontal padding */
$color="black";
$paascu = ($classroom['department_id']==2)? "<span>PAASCU</span> <span class='i' >Accredited</span><br />":NULL;



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
	include_once('rptincs/css_vars.php');
	include_once('rptincs/menu.php');
?>

<?php if(!$is_locked): ?>
<p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED !</p>
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


<div class="center" style="min-height:120px;"  > 
	<?php if(!isset($_GET['hdheader'])): ?><?php include('rptincs/header.php'); ?>
	<div class="<?php echo $tblwidth; ?> clear" ><hr /></div>	
	<?php endif; ?>
</div>


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


