<h5>
	
	<span class="u" ondblclick="tracepass();" >Filter Transfer</span>
	<span class="hd" >HD</span>
<span class="screen" >
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'logistics/filterTransfer'; ?>" >Filter</a>
	
	<?php if(isset($_GET['filter'])): ?>
		| <a class="u" id="btnExport" >Excel</a>
	<?php endif; ?>	
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
	
</span> 	<!-- screen -->	

</h5>

<?php if(isset($_GET['filter'])): ?>
<div class="center" >
	<?php 
		$page="Filter Transfer";
		$page.="<br /> ".date('M d, Y',strtotime($_GET['dateone']))." -- ".date('M d, Y',strtotime($_GET['datetwo']))."";		
		$inc = SITE.'views/customs/'.VCFOLDER.'/incs/letterhead.php';include($inc); 
	?>
</div>

<?php endif; ?>


<?php 

	if(isset($_GET['debug'])){ pr($q); }

	if(isset($_GET['filter'])){
		include_once('incs/table_transfer.php');		
	} else {
		include_once('incs/filter_transfer.php');			
	}

?>


