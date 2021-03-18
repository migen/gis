<?php 

	// pr($_SESSION['q']);


?>


<h5 class="screen" >
	PO Transfer
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
	| <a href="<?php echo URL.'purchases/viewPO/'.$poid; ?>" >View</a>	
	| <a href="<?php echo URL.'purchases/editPO/'.$poid; ?>" >Edit</a>	
	| <a href="<?php echo URL.'purchases/filterPO'; ?>" >Filter PO</a>
	| <a class="u" onclick="location.reload();" >Refresh</a>	
	
</h5>

<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>


<?php 

	if($poid){
		include_once('incs/move_po.php');
	} else {
		include_once('incs/filter_po.php');		
	}

?>



