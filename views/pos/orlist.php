<h5>
	OR List
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

</h5>

<p><?php include_once('incs/orlist_filter.php'); ?></p>


<?php 
	if(isset($_GET['submit'])){
		include_once('incs/orlist_table.php');
	}


?>
