<?php 
	$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";

?>

<table class="no-gis-table-bordered" >
	<tr><th rowspan="5" ></th></tr>
	<tr><th class="center" ><?php echo $_SESSION['settings']['school_name']; ?></th>
		<th rowspan="4" ></th>			
	</tr>
	<tr><th class="center" ><?php echo $_SESSION['settings']['school_address']; ?></th></tr>
	<tr><td class="center" ><?php echo $page; ?></td></tr>
	<tr><td class="center" >
		<span class="tf12" >Date printed: <?php echo date('Y-m-d H:i:s'); ?></span>
	</td></tr>	
</table>