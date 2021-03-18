<?php 
	$user = $_SESSION['user'];
	// pr($user); 
?>

<table class="stats accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('stats');" >Statistics</th></tr>


<tr><td class="vc250" >
	<a href="<?php echo URL.'stats/popn/'.$_SESSION['sy']; ?>" >Enrollees</a>
</td></tr>

<tr><td>
	<a href="<?php echo URL.'logs/scores/3'; ?>" >Scores</a>
</td></tr>


<tr><td>&nbsp;</td></tr>

</table>
