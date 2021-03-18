<?php 

?>

<h5>
	Stocks on Display SD (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href="<?php echo URL.'stocks/byTerminal&set'; ?>">Stocks by Terminal</a>


</h5>

<p class="brown b" >*Manages "Stocks" by Terminal module.</p>

<?php 

if(isset($_GET['debug'])){ pr($q); }

	include_once('incs/sd_filter.php');		
	
	if(isset($suppid)){
		include_once('incs/sd_table.php');				
	}
	
	
	
?>



