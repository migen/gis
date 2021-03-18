	<?php 
// pr($_SESSION['q']);
// pr($data);
// exit;
?>


<h5 class="screen" >
	PO | <?php echo "Supp#".$row['suppid'];?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
	| <a href="<?php echo URL.'purchases/editPO/'.$poid; ?>" >Edit</a>	
	| <a href="<?php echo URL.'purchases/addPO'; ?>" >Add PO</a>
	| <a href="<?php echo URL.'purchases/filterPO'; ?>" >Filter PO</a>
	| <a href='<?php echo URL."purchases/movePO/$poid"; ?>' >PO Transfer</a>
	| <a href='<?php echo URL."delivery/view/$poid"; ?>' >Delivery</a>
	| <a href='<?php echo URL."suppliers/edit/".$row['suppid']; ?>' >Supplier</a>
	| Poid <input class="vc50" id="poid" value=""  /><button onclick="redirPo();" >Go</button>
	
	
</h5>

<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>


<?php 

	if($poid){
		include_once('incs/body_po.php');
	} else {
		include_once('incs/filter_po.php');		
	}

?>


<script>
var gurl = "http://<?php echo GURL; ?>";
var sy="<?php echo DBYR; ?>";

$(function(){

})


</script>


<script type='text/javascript' src="<?php echo URL; ?>views/js/po.js"></script>
