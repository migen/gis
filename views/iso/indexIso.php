<style>
li{margin-left:-20px;}


</style>

<h5>
	ISO
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

</h5>

<?php 

	$incs="incs/iso_tasks.php";include_once($incs); 
	$incs="incs/clients_info.php";include_once($incs); 
	
?>



