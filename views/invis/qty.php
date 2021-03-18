<h5>

Manage Inventory by Terminal (MIT) <?php echo "#T{$t} "; ?>

</h5>


<?php 
	if(isset($_GET['all'])){
		include_once('incs/products_all.php');
	} else {
		include_once('incs/products_sold.php');	
	}
	
	
	
?>