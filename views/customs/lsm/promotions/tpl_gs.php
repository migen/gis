
<script>
	$(function(){ 
		hd(); 
		excel();
	})
	
	
	
</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<h5 class="screen hd" >
Num Subjects: <?php echo $numsub; ?> <br />
Num Limits: <?php echo $numsub; ?> <br />
</h5>	<!-- screen -->


<?php 

/* CUSTOM */
	$limits = $numsub;


/* ETC */	
	$tblwidth = "960px";


?>

<link type='text/css' rel='stylesheet' href="prep_style.css" />

<style>

@media print{ .screen{display:none;} }

#pcont{ 
	width:<?php echo $tblwidth; ?>; border:1px solid white; 

}

	


#phead {color:; width:100%;}






</style>






<div id="pcont" class="portrait" >

<div id="phead" class="" ><?php include_once('phead_gs.php'); ?></div>	
<div id="pbody" class="" ><?php include_once('pbody_gs.php'); ?></div>	






</div>	<!-- pcont -->

<p class="pagebreak" >&nbsp;</p>



