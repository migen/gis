<?php 
	$user = $_SESSION['user'];
	// pr($user); 
?>

<table class="purger accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('purger');" >Purger</th></tr>


<tr><td><a href="<?php echo URL.'purgestudents/one'; ?>" >PurgeStudent</a></td></tr>

<tr><td><a href="<?php echo URL.'mis/purger'; ?>" >Contacts</a></td></tr>
<tr><td><a href="<?php echo URL.'purge/logbooks'; ?>" >Logbook <?php echo (DBYR-2); ?></a></td></tr>

<tr><td>
	<a href="<?php echo URL.'purge/cir'; ?>" >Purge CIR</a>
	| <a href="<?php echo URL.'purge/one'; ?>" >Purge One</a>
</td></tr>
<tr><td>
	<a href="<?php echo URL.'purge/purger'; ?>" >Purger</a>
	| <a href="<?php echo URL.'purge/doRange'; ?>" >Range</a>
</td></tr>
<tr><td><a href="<?php echo URL.'misc/cleanScores'; ?>" >Clean Scores</a></td></tr>
<tr><td><a onclick="return confirm('Sure?');" href="<?php echo URL.'axis/purgeEmptyAuxes'; ?>" >Purge Empty Auxes/Discounts</a>
</td></tr>

<tr><td class="center" >-Reports-</td></tr>



<tr><td>&nbsp;</td></tr>

</table>


<script>

$(function(){
	$('#purger').hide();
})

</script>

