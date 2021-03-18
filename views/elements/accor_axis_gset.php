<table class="syncaxis accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('syncaxis');" >Sync Axis</th></tr>


	<tr><td> <a href="<?php echo URL.'syncPayables'; ?>" >Update / Sync Payables</a></td></tr>



<?php 
	$year=isset($sy)? $sy:$_SESSION['year'];
?>
<tr><td> <a href="<?php echo URL.'syncaxis/showTfeedetails'.$year; ?>" >Show tfeedetails<?php echo $year; ?></a></td></tr>



<tr><td> <a href="<?php echo URL.'files/read/transition'; ?>" >New SY</a></td></tr>

<tr><td>&nbsp;</td></tr>
</table>


