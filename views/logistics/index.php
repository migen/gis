<h5>
	Stocks Movements
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'logistics/index'; ?>">Filter</a>	
	| <a href="<?php echo URL.'logistics/move'; ?>">Move / Request Stocks</a>
	
	<?php if(isset($_GET['submit'])): ?>	
		<?php $_GET['sort']='pr.name';$_GET['order']='ASC';	?>		
		| <a href="<?php echo URL.'logistics/summary'.sages($_GET); ?>" >Summary</a>			
	<?php endif; ?>
	
	
</h5>


<?php 

	if(isset($_GET['debug'])){ pr($q); }


	include_once('incs/smv_filter.php');
	
	if(isset($_GET['submit'])){
		include_once('incs/smv_table.php');
	}
	
?>



