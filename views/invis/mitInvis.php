<?php 

$url=getUrl();
$url.='&printable';

?>

<h5 class="screen" >
	Manage Inventory by Terminal (MIT) <?php echo "#T{$t} "; echo "({$count})"; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.$url.'&printable'; ?>">Printable</a>

<?php $page.="<br />".$supplier." - Terminal #".$t; ?>	

</h5>

<div class="screen" ><?php include_once('incs/mit_filter.php'); ?></div>

<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>

	
	
<?php	

if(isset($_GET['suppid'])){
	include_once('incs/products_supplier.php');				
}

	
	
?>



