<h5>
	Diff DB
	| <?php $this->shovel('homelinks'); ?>

</h5>

<form method="GET" >

<table class="gis-table-bordered" >
<tr><th>Schema 1</th><td><input name="db1" value="2017_dbgis_<?php echo VCFOLDER; ?>" ></td></tr>
<tr><th>Table 1</th><td><input name="table1" value="05_levels" ></td></tr>
<tr><th>Schema 2</th><td><input name="db2" value="2018_dbgis_<?php echo VCFOLDER; ?>" ></td></tr>
<tr><th>Table 2</th><td><input name="table2" value="05_levels" ></td></tr>
<tr><th colspan=2><input type="submit" name="submit" ></th></tr>

</table>
</form>
