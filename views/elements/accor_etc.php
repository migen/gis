




<table class="mis accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('mis');" >MIS &nbsp;&nbsp;&nbsp;&nbsp; </th></tr>

<tr><td><a href="<?php echo URL.'db/box'; ?>" >GIS Data Backup (Gisbox)</a></td></tr>
<tr><td>
	<a href="<?php echo URL.'advisers/averager?qtr='.$_SESSION['qtr']; ?>" >Averager</a>
	| <a href="<?php echo URL.'duplicates/go'; ?>" >Duplicates</a>
	| <a href="<?php echo URL.'mgt/pass'; ?>" >Pass</a>
</td></tr>
	
<tr><td><a href="<?php echo URL.'dashboard/mis'; ?>" >Dashboard</a>
	| <a href="<?php echo URL.'dashboard/syncs'; ?>" >Syncs</a></td></tr>
<tr><td><a href="<?php echo URL.'scripts'; ?>" >Scripts</a> 
<tr><td><a href="<?php echo URL.'setup/grading'; ?>" >Setup1</a> 
| <a href="<?php echo URL.'setup'; ?>" >Setup2</a></td></tr>
<tr><td>
	<a href="<?php echo URL.'logs'; ?>" >Logs</a>
	| <a href="<?php echo URL.'tickets'; ?>" >Tickets</a>
</td></tr>
<tr><td><a href="<?php echo URL.'letters'; ?>" >Letter Grades Traits</a></td></tr>
<tr><td><a href="<?php echo URL.'cav/traitsByLevel'; ?>" >Traits By Level</a></td></tr>
<tr><td><a href="<?php echo URL.'gset/crs'; ?>" >Crs Mgr (Purge)</a></td></tr>
<tr><td><a href="<?php echo URL.'turnover'; ?>" >Turnover</a></td></tr>
<tr><td><a href="<?php echo URL.'misc/purgeIndex'; ?>" >Cls Crs (Purge)</a></td></tr>
<tr><td>
	  <a href="<?php echo URL.'mis/idf'; ?>" >ID Finder</a>
	| <a href="<?php echo URL.'data/rships'; ?>" >Relationships</a>
</td></tr>
<tr><td><a href="<?php echo URL.'employees/codelist'; ?>" >Employees Codelist</a></td></tr>
<tr><td><a href="<?php echo URL.'id/tracer'; ?>" >ID Tracer</a></td></tr>
<tr><td><a href="<?php echo URL.'tools/propagator'; ?>" >Propagator</a></td></tr>
<tr><td><a href="<?php echo URL.'acl'; ?>" >ACL</a></td></tr>
<tr><td><a href="<?php echo URL.'transitions'; ?>" >SY Transitions</a></td></tr>
<tr><td><a href="<?php echo URL.'dreams'; ?>" >Migrate (PO / dreams)</a></td></tr>
<tr><td><a href="<?php echo URL.'scripts/proma/'.$sy; ?>" >PromoteAll Qry</a></td></tr>

<tr><td class="bg-blue2" >POS | Invis | Axis</td></tr>

<tr><td><a href="<?php echo URL.'pos/mgr'; ?>" >POS Manager (Mgr)</a></td></tr>
<tr><td><a href="<?php echo URL.'prox/invis/products.php'; ?>" >Destroy Products</a></td></tr>
<tr><td><a href="<?php echo URL.'prox/invis/suppliers.php'; ?>" >Destroy Suppliers</a></td></tr>
<tr><td><a href="<?php echo URL.'costs/logs?prid=2005'; ?>" >Cost Logs</a></td></tr>
<tr><td><a href="<?php echo URL.'stocks/stats'; ?>" >Suppliers Stocks Stats</a></td></tr>
<tr><td> 
  <a onclick="return confirm('Sure?');" href="<?php echo URL.'invis/totalInventoryLevel?tmax=6'; ?>" >Sync / Total Inventory Level</a>
</td></tr>

<tr><td class="bg-blue2" >Enrollment</td></tr>
<tr><td><a href="<?php echo URL.'enrollment/manager'; ?>" >Enrollment Manager</a></td></tr>
<tr><td><a href="<?php echo URL.'balances/tsum/4/'.DBYR; ?>" >Balances Summary</a></td></tr>

<tr><td>&nbsp;</td></tr>
</table>


