<?php 
	$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
	
	// pr($_SESSION['levels']);
	$levels=$_SESSION['levels'];


?>

<!-- <table class="center bo-gis-table-bordered" >
	<tr><th class="center" ><?php echo $_SESSION['settings']['school_name']; ?></th></tr>
	<tr><th class="center" ><?php echo $page; ?></th></tr>
	
	<?php if(isset($_GET['start']) && isset($_GET['end'])): ?>	
		<tr><td class="center" ><?php echo "From ".$_GET['start']." To ".$_GET['end']; ?></td></tr>
	<?php endif; ?>
	
	<?php if(isset($_GET['lvlid'])): ?>	
		<?php 
			$lvlrow=searchFromArray($levels,'id', $_GET['lvlid']);
			$lvlname=$lvlrow['name'];
		?>
	
		<tr><td class="center" ><?php echo $lvlname; ?></td></tr>
	<?php endif; ?>
	



	<tr><td class="center" >
		<span class="tf12" >Date printed: <?php echo date('Y-m-d H:i:s'); ?></span>
	</td></tr>	

</table> -->