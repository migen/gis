<?php 
	$user = $_SESSION['user'];

	
?>

<table class="transitions accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('transitions');" >Transitions</th></tr>



<tr><td class="vc250" ><a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a></td></tr>
<tr><th><a href="<?php echo URL.'cir/index'; ?>" >Class Index Reports (CIR)</a></th></tr>
<tr><th><a href="<?php echo URL.'scripts/proma/'.DBYR; ?>" >1) Promote All</a></th></tr>
<tr><th><a href="<?php echo URL.'transitions/promcrid/'.DBYR; ?>" >2) Promcrid Sql</a></th></tr>
<tr><th><a href="<?php echo URL.'syncs/syncTuitionSummaries/'.DBYR; ?>" >3) Sync Tsum</a></th></tr>


</table>




