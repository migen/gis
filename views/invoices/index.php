

<h5>
	Invoices 
		<span class="hd" >HD</span>
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."invoices/add"; ?>' >Add</a>
	| <a class="u" href='<?php echo URL."invoices"; ?>' >Filter</a> 	
<?php if(isset($_POST['filter'])): ?>	
	| <a class="u" id="btnExport" >Excel</a> 
<?php endif; ?>	
	<?php include_once('incs/last_orno.php'); ?>
		
</h5>




<?php if(isset($_GET['filter'])): ?>
	<?php include_once('incs/table_invoices.php'); ?>
<?php else: ?>
	<?php include_once('incs/filter_invoices.php'); ?>
<?php endif; ?>


<div class="hd" id="names" > </div>


<script>

	$(function(){
		hd();
		
	})


	
	
</script>
