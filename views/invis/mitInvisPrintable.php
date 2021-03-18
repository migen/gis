
<?php

$url=getUrl();
$url=rtrim($url,'&printable');



?>

<h5 class="screen" >
	Manage Inventory by Terminal (MIT) <?php echo "#T{$t} "; echo "({$count})"; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	| <a href="<?php echo URL.$url; ?>">Editable</a>
	| <a class="u" id="btnExport" >Excel</a> 
	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>

<?php $page.="<br />".$supplier." - Terminal #".$t; ?>	

</h5>


<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>

	
	
<?php	

if(isset($_GET['suppid'])){
	include_once('incs/products_supplierPrintable.php');				
}

	
	
?>



