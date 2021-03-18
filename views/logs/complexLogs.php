<!-- from bills-index -->

<h5>
	<span class="u" ondblclick="tracehd();" >Logs (<?php echo (isset($count))? $count:NULL; ?>)</span>
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'logs'; ?>">Filter</a>
	| <a class="u" id="btnExport" >Excel</a> 	
	
</h5>


<?php 
	$get = isset($_GET)? sages($_GET):'';	 # echo "get : $get <br />";
	

	if(isset($_GET['filter'])){
		include_once('incs/table_logs.php');
	} else {
		include_once('incs/filter_logs.php');
	}
	
	
?>


<div class="hd" ><?php // pr($_SESSION['q']); ?></div>

