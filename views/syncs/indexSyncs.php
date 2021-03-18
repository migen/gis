<h5>
	Syncs | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'syncs/tables'; ?>" >Sync Tables</a>
	
</h5>



<?php 
	$incs=SITE."views/elements/accor_syncboard.php";include_once($incs); 
?>


<script>



$(function(){
	hd();
	
})




</script>

