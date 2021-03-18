<h5>
	
	<?php echo (isset($_GET['sy']))? "SY $sy ":NULL; ?>
	<span class="u" ondblclick="tracepass();" >PO</span>
	<span class="hd" >HD</span>
<span class="screen" >
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'purchases/filterPO'; ?>" >Filter</a>
	| <a href="<?php echo URL.'purchases/addPO'; ?>" >Add PO</a>
	
	<?php if(isset($_GET['filter'])): ?>
		| <a class="u" id="btnExport" >Excel</a>
	<?php endif; ?>	
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
	
</span> 	<!-- screen -->	

</h5>


<?php 
	// pr($_GET);
	if(isset($_GET['filter'])){
		include_once('incs/table_po.php');		
	} else {
		include_once('incs/filter_po.php');			
	}

?>


