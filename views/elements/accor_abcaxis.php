<?php 
	$user = $_SESSION['user'];
	// pr($user); 
?>



<table class="axis accordion gis-table-bordered table-altrow" >
<tr><th class="accorHeadrow" onclick="accordionTable('axis');" >AXIS</th></tr>


<tr><td>
	<a href="<?php echo URL.'bills/add'; ?>" >Cashier</a>
	| <a href="<?php echo URL.'bills/index'; ?>" >Filter</a>  
</td></tr>

<tr><td class="" >
	  <a target="_blank" href="<?php echo URL.'ledgers/pay'; ?>" >Ledger</a>
	| <a href="<?php echo URL.'soas/soa'; ?>" >SOA</a>
</td></tr>

<tr><th class="center" >-Reports-</th></tr>

<tr><td>
  	  <a href="<?php echo URL.'auxes/ad/'.DBYR; ?>" >Addons</a>
	| <a href="<?php echo URL.'balances'; ?>" >Balances</a>
	| <a href="<?php echo URL.'cash/tally'; ?>" >Cash Tally</a>
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'collections/payments'; ?>" >Payments</a>
	| <a href="<?php echo URL.'payments/mgr'; ?>" >Manager</a>
	| <a href="<?php echo URL.'advances/report'; ?>" >Advances</a>
	
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'enrollment/report'; ?>" >Enrollment</a>
	 | <a href="<?php echo URL.'clearance/one'; ?>" >Status</a>	 
</td></tr>

<tr><th class="center" >-Accounts Setup-</th></tr>
<tr><td>
	  <a href="<?php echo URL.'tfees/details/4?num=1'; ?>" >Table</a>
	| <a href="<?php echo URL.'tfeetypes/table'; ?>" >Fees</a>
	| <a href="<?php echo URL.'tfees/table'; ?>" >Tuitions</a>
</td></tr>

<tr><td class="vc250" >
	  <a href="<?php echo URL.'paymodes/index'; ?>" >Pay Modes</a>	
	| <a href="<?php echo URL.'invoices/orno/'.$_SESSION['pcid']; ?>" >OR No.</a>	
	| <a href="<?php echo URL.'ornos?date='.$_SESSION['today']; ?>" >Voids</a>	
</td></tr>

<?php if($_SESSION['srid']==RMIS): ?>
<tr><td class="vc250" >
	  <a href="<?php echo URL.'setaxis/initialize'; ?>" >Ledgers Setup</a>
	  <?php echo ($_SESSION['settings']['ledger_setup']==1)? '(Locked)':'(Open)'; ?>
</td></tr>
<?php endif; ?>

<tr><td class="" >
	  <a href="<?php echo URL.'axis/batchFees'; ?>" >Batch Fees</a>
	| <a href="<?php echo URL.'axis/batchRemarks'; ?>" >Batch Remarks</a>
</td></tr>

<tr><th class="center" >-MISC-</th></tr>
<tr><td><a href="<?php echo URL.'db/box'; ?>" >GIS Data Backup</a></td></tr>
<tr><td class="" >
	  <a onclick="return confirm('Sure?');" href="<?php echo URL.'axis/purgeEmptyAuxes'; ?>" >Purge Empty Addons/Discounts</a>
</td></tr>


<tr><td>&nbsp;</td></tr>

</table>
