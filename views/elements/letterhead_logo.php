<?php 
	$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
	$page=$data['page'];
	
?>

<table class="no-gis-table-bordered" >
	<tr><th rowspan="3" ><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80"></th></tr>
	<tr><th class="center" ><?php echo $_SESSION['settings']['school_name']; ?></th></tr>
	<tr><td class="center" ><?php echo $page; ?></td></tr>
</table>