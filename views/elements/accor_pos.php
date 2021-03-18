<?php 
	$user = $_SESSION['user'];
	// pr($user); 
?>

<table class="invis accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('invis');" >Inventory</th></tr>	

<tr><td class="center" >-Sales | POS-</td></tr>
<tr><td class="" > 
	  <a href="<?php echo URL.'opos'; ?>" >POS</a>
	 | <a href="<?php echo URL.'pos/dsr'; ?>" >DSR</a>
	 | <a href="<?php echo URL.'stocks/dtr'; ?>" >DTR</a>		 
	 | <a href="<?php echo URL.'pos/orlist'; ?>" >OR List</a>		 
</td></tr>
<tr><td>
	  <a href="<?php echo URL.'cpos/add'; ?>" >POS (Credit)</a>
	| <a href="<?php echo URL.'fpos'; ?>" >Find Student</a>
</td></tr>

<?php if($user['privilege_id']>0): ?>	<!-- not invad -->
	<tr><td class="vc250" > 
		    <a href="<?php echo URL.'cash/denominations'; ?>" >Denominations</a>
		  | <a href="<?php echo URL.'npos/reprint'; ?>" >Reprint</a>
	</td></tr>	
	<tr><td class="" > 
		    <a href="<?php echo URL.'stocks/byTerminal&set'; ?>" >Stocks</a>
		| <a href="<?php echo URL.'stocks/display'; ?>" >Display</a>  						
		| <a href="<?php echo URL.'pos/returns'; ?>" >Returns</a>  						
	</td></tr>			
	
<?php else: ?>	<!-- invad -->
	<tr><td class="vc250" > 
		  <a href="<?php echo URL.'pos/terminals'; ?>" >Terminals</a>	  
		  | <a href="<?php echo URL.'invoices/orbooklets'; ?>" >OR Booklets</a>	  
	</td></tr>
	<tr><td class="" > 
		Report -
		  <a href="<?php echo URL.'pos/sales'; ?>" >Sales</a>
		 | <a href="<?php echo URL.'pos/items'; ?>" >Inventory</a>	  
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'inventory/master'; ?>" >Master Inventory Report (MIR)</a>
	</td></tr>
	
	<tr><td>
		Daily <a href="<?php echo URL.'pos/dsr'; ?>" >Sales</a>
		| <a href="<?php echo URL.'stocks/dtr'; ?>" >Inventory</a>
	</td></tr>
	
	<tr><td>
		<a href="<?php echo URL.'pos/dcr'; ?>" >Daily Collection Report (DCR)</a>
	</td></tr>
	
	<tr><td class="" > 
		    <a href="<?php echo URL.'cash/denominations'; ?>" >Denominations</a>
		  | <a href="<?php echo URL.'npos/reprint'; ?>" >Reprint</a>
	</td></tr>	
	<tr><td class="" > 
		    <a href="<?php echo URL.'stocks/byTerminal&set&terminal=1'; ?>" >Stocks</a>
		| <a href="<?php echo URL.'stocks/display'; ?>" >Display</a>  			
		| <a href="<?php echo URL.'pos/rxsummary'; ?>" >Returns</a>  			
	</td></tr>			
	<tr><td class="" > 
		    <a href="<?php echo URL.'pos/mgr'; ?>" >POS Manager</a>
		  | <a href="<?php echo URL.'pos/finder'; ?>" >Sold Item Finder</a>
	</td></tr>		
	
<tr><td class="center" >-Products Setup-</td></tr>
<tr><td> 
	<a href="<?php echo URL.'products/types'; ?>" >Types</a>
	| <a href="<?php echo URL.'products/subtypes'; ?>" >Group</a>
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
</td></tr>



<tr><td> 
	  <a href="<?php echo URL.'products/roster'; ?>" >Assignments</a>
	| <a href="<?php echo URL.'products/suppliers/'.RSUPP; ?>" >Suppliers</a>
</td></tr>

<tr><td class="center" >-Stocks-</td></tr>
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

<?php endif; ?>	<!-- not invad -->

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
