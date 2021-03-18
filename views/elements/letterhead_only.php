<?php 
	$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
	$page=isset($page)? $page:NULL;
?>

<table class="no-gis-table-bordered" >

	<tr><th class="center" ><?php echo $_SESSION['settings']['school_name']; ?></th></tr>
	<tr><td class="center" ><?php echo $page; ?></td></tr>	
	
</table>