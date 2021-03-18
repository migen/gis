

<h5>
	Students List (<?= isset($count)? $count:0;?>)
		<span class="hd" >HD</span>
	| <a href="<?php echo URL.$home; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a class="u" href='<?php echo URL."registrars/filter"; ?>' >Filter</a> 	
<?php if(isset($_GET['filter'])): ?>	
	| <a class="u" id="btnExport" >Excel</a> 
<?php endif; ?>	
		
</h5>




<?php if(isset($_GET['filter'])): ?>
	<?php include_once('incs/table_students.php'); ?>
<?php else: ?>
	<?php include_once('incs/filter_students.php'); ?>
<?php endif; ?>




<script>

	$(function(){
		hd();
		
	})


	
	
</script>
