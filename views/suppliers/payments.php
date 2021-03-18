<h5>
	


<span class="screen" >
	PO Payments
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'suppliers/payments'; ?>" >Filter</a>
	
	<?php if(isset($_GET['filter'])): ?>
		| <a class="u" id="btnExport" >Excel</a>
	<?php endif; ?>	
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
	
</span> 	<!-- screen -->	

</h5>

<div class="center" >
<?php 

// $inc = 'incs/sales_letterhead.php';include($inc); 
$page="Suppliers PO Payments Summary Report";
$inc = SITE.'views/customs/'.VCFOLDER.'/incs/letterhead.php';include($inc); 

?>

</div>



<?php 

	if(isset($_GET['filter'])){
		include_once('incs/table_payments.php');		
	} else {
		include_once('incs/filter_payments.php');			
	}

?>


