<h5 class="screen" >
	
	<span class="u" ondblclick="tracepass();" >Summary Transfer (<?php echo (isset($count))? $count:NULL; ?>) </span>
	<span class="hd" >HD</span>
<span class="screen" >
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'logistics/summaryTransfer'; ?>" >Summary</a>
	
	<?php if(isset($_GET['filter'])): ?>
		| <a class="u" id="btnExport" >Excel</a>
	<?php endif; ?>	
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
	
</span> 	<!-- screen -->	

</h5>




<?php if(isset($_GET['filter'])): ?>
	<div class="center clear" >
	<?php $page="Summary Transfer ($count)"; ?>
	<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
	</div>
<?php endif; ?>

<?php 

	if(isset($_GET['debug'])){ pr($q); }

	
	
	if(isset($_GET['filter'])){
		include_once('incs/table_summarytransfer.php');		
	} else {
		include_once('incs/filter_summarytransfer.php');			
	}

?>


