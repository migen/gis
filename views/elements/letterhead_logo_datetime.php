<?php 
	// pr($data);
	$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
	$page=isset($data['page'])? $data['page']:NULL;

	
?>

<table class="no-gis-table-bordered" >
	<tr><th rowspan="5" ><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80"></th></tr>
	<tr><th class="center" ><?php echo $_SESSION['settings']['school_name']; ?></th></tr>
	<tr><th class="center" ><?php echo $_SESSION['settings']['school_address']; ?></th></tr>
	<tr><td class="center" ><?php echo $page; ?></td></tr>
	<tr><td class="center" >
		<span class="tf12" >Date printed: <?php echo date('Y-m-d H:i:s'); ?></span>
	</td></tr>	
</table>



