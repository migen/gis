<h5>
	Bills (<?php echo (isset($_GET['filter']))? $count:0; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."bills/add"; ?>'>Cashier</a>			
	| <a class="u" id="btnExport" >Excel</a> 

	| Print Orno <input class="vc80" id="orno" value="<?php  ?> " />
	<input type="submit" value="Print" onclick="printOrno();return false;"  />
	
</h5>

<?php 
	include_once('incs/bills_filter.php');
	
	
	if(isset($_GET['filter'])){
		include_once('incs/bills_table.php');		
	}
	
?>

