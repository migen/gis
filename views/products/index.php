<?php 

// pr($_SESSION['q']);


?>


<h5>
	Products Manager <?php echo (isset($count))? '('.$count.')':NULL; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."products"; ?>' >Filter</a> 
	| <a href='<?php echo URL."products/add"; ?>' >Add</a> 
	| <a href='<?php echo URL."products/view/1"; ?>' >View</a> 
	| <a class="u" onclick="ilabas('tqty');" >TQ</a>
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	

</h5>



<?php 

$incs = SITE.'views/products/incs/products_filter.php';
include_once($incs);

if(isset($_POST['filter'])){
	$incs = SITE.'views/products/incs/products_table.php';
	include_once($incs);
}


