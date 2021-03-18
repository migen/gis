<h5>
	Inventory logs
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'invis/invlogs'; ?>" >Filter</a>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a class="u txt-blue" onclick="window.print();" >Print</a>

</h5>

<?php 

	if(isset($_GET['filter'])){
		include_once('incs/table_invlogs.php');
	} else {
		include_once('incs/filter_invlogs.php');		
	}

?>

