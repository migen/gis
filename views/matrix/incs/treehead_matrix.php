<?php 
	// $logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
	// pr($cr);
	
	$logo_src=$imgsrc;	
	$school_name=$_SESSION['settings']['branch_name_'.$brid];
	$school_address=$_SESSION['settings']['branch_address_'.$brid];
	

?>

<table class="" >
	<tr><th rowspan="6" ><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80"></th></tr>
	<tr><th class="center" ><?php echo $school_name; ?></th></tr>
	<tr><th class="center" ><?php echo $school_address; ?></th></tr>
	<tr><td class="center" ><?php echo $page; ?></td></tr>
	<tr><td class="center" >
		<span class="" ><?php echo $cr['level'].' - '.$cr['section']; ?></span>	
	</td></tr>			
	<tr><td class="center" >
		<span class="tf12" >Date printed: <?php echo date('Y-m-d H:i:s'); ?></span>
	</td></tr>	

</table>