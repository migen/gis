<h5>
	
	<?php echo (isset($_GET['sy']))? "SY $sy ":NULL; ?>
	<span class="u" ondblclick="tracepass();" >Shrinkages</span>
	<span class="hd" >HD</span>
<span class="screen" >
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'shrinkages/filter'; ?>" >Filter</a>
	| <a href="<?php echo URL.'shrinkages/add'; ?>" >Add</a>
	
	<?php if(isset($_GET['filter'])): ?>
		| <a class="u" id="btnExport" >Excel</a>
	<?php endif; ?>	
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
	
</span> 	<!-- screen -->	

</h5>


<?php 
	if(isset($_GET['filter'])){
		include_once('incs/table_shrinkages.php');		
	} else {
		include_once('incs/filter_shrinkages.php');			
	}

?>


