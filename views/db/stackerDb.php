<h5>
	Stacker
	| <?php $this->shovel('homelinks'); ?>

</h5>

<form method="GET" >

<table class="gis-table-bordered" >
<tr><th>DB Src</th><td><input name="db_src" value="2017_dbgis_<?php echo VCFOLDER; ?>" ></td></tr>
<tr><th>DB Dest</th><td><input name="db_dest" value="dbone_<?php echo VCFOLDER; ?>" ></td></tr>
<tr><th>Table Array (CSV)</th><td><input name="sources_str" value="" ></td></tr>
<tr><th colspan=2><input type="submit" name="submit" ></th></tr>

</table>
</form>
