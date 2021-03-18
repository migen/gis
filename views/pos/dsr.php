<h5 class="screen" >
	Daily Sales Report (DSR)
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
		
</h5>


<?php 
	if(isset($_GET['debug'])){ pr($q); }

?>


<div class="screen" >
	<?php $incs = SITE."views/pos/incs/dsr_filter.php"; include_once($incs); ?>
</div>

<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>


<table class="gis-table-bordered table-fx" >
	<tr><th>Date Range</th><td class="vc200" ><?php echo $start.' to '.$end; ?></td></tr>
<?php if($ecid): ?>	
	<tr><th>Terminal - ECID</th><td><?php echo $employee['terminal'].' - '.$ecid; ?></td></tr>
	<tr><th>Employee</th><td><?php echo $employee['employee'].' | '.$employee['code']; ?></td></tr>
<?php endif; ?>
	<tr><th>Inventory Sold Total</th><th><?php echo number_format($inventory_total,2); ?></th></tr>
	<tr><th>POS OR Total</th><th><?php echo number_format($pos_total,2); ?></th></tr>
</table>
