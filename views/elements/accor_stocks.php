<?php 
	$user = $_SESSION['user'];
	// pr($user); 
?>

<table class="stocks accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('stocks');" >Stocks</th></tr>


<tr><td> 
	  <a href="<?php echo URL.'apos'; ?>" >Apos</a>
	  | <a href="<?php echo URL.'apos/add'; ?>" >Add</a>
</td></tr>


<tr><td> 
	  <span class="b" >PO - </span> 
	  <a href="<?php echo URL.'purchases/filterPO'; ?>" >Filter</a>
	  | <a href="<?php echo URL.'purchases/addPO'; ?>" >Add</a>
	  | <a href="<?php echo URL.'purchases/posumm'; ?>" >Summary</a>
</td></tr>

<tr><td> 
	  <span class="b" >Stocks - </span> 
	  <a href="<?php echo URL.'logistics/move'; ?>" >Move</a>
	  | <a href="<?php echo URL.'logistics/summary'; ?>" >Summary</a>
</td></tr>

<tr><td> 
	  <a href="<?php echo URL.'suppliers/payments'; ?>" >Suppliers Payments</a>
</td></tr>

<tr><td> 
	  Transfer - 
	  <a href="<?php echo URL.'logistics/filterTransfer'; ?>" >Filter</a>
	  | <a href="<?php echo URL.'logistics/summaryTransfer'; ?>" >Summary</a>
</td></tr>


<tr><td> 
	  <a href="<?php echo URL.'invis/mit'; ?>" >Manage Inventory Terminal (MIT)</a>
</td></tr>


<tr><td> 
	  <span class="b" >Shrinkages - </span>
	  <a href="<?php echo URL.'shrinkages/filter'; ?>" >Filter</a>
	  | <a href="<?php echo URL.'shrinkages/batch'; ?>" >Batch</a>
</td></tr>


<tr><td class="center" >-Misc-</td></tr>
<tr><td><a href="<?php echo URL.'invis/invlogs'; ?>" >Inventory Logs (MIT)</a></td></tr>
<?php if($_SESSION['user']['privilege_id']==0): ?>	
	<tr><td><a href="<?php echo URL.'db/box'; ?>" >GIS Data Backup</a></td></tr>
<?php endif; ?>
<tr><td>&nbsp;</td></tr>

</table>



