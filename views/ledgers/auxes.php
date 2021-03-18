

<h5>
	Students' Addons 
		<span class="hd" >HD</span>
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a class="u" href='<?php echo URL."ledgers/auxes"; ?>' >Auxes</a> 	
<?php if(isset($_GET['filter'])): ?>	
	| <a class="u" id="btnExport" >Excel</a> 
<?php endif; ?>	
		
</h5>




<?php if(isset($_GET['filter'])): ?>
	<?php include_once('incs/table_auxes.php'); ?>
<?php else: ?>
	<?php include_once('incs/filter_auxes.php'); ?>
<?php endif; ?>


<div class="hd" id="names" > </div>


<script>

	$(function(){
		hd();
		
	})

	
	
</script>
