<?php 
	// pr($data);
	$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
	$page=isset($data['title'])? $data['title']:false;	

?>

<div class="clear center" >
<table class="no-gis-table-bordered" >
	<tr><th rowspan="5" ><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="76"></th></tr>
	<tr><th class="center" ><?php echo $_SESSION['settings']['school_name']; ?></th>
		<th rowspan="4" >
			<?php if(VCFOLDER=='lsm'): ?>
			<img src="<?php echo URL."public/images/weblogo_sf.png"; ?>" 
							alt="logo" height="88" width="76">
			<?php endif; ?>
		</th>			
	</tr>
	<tr><th class="center" ><?php echo $_SESSION['settings']['school_address']; ?></th></tr>
	<?php if($page): ?>
		<tr><td class="center" ><?php echo $page; ?></td></tr>	
	<?php endif; ?>
	<tr><td class="center" >
		<span class="tf12" >Date printed: <?php echo date('Y-m-d H:i:s'); ?></span>
	</td></tr>	
</table>
</div>