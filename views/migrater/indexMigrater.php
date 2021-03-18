<h5>
	Migrater
	| <?php $this->shovel('homelinks'); ?>
	
	
</h5>


<form method="GET" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Table</th><td><input name="dbtable" value="30_po" /></td></tr>
<tr><th>ID From</th><td><input name="idbeg"  /></td></tr>
<tr><th>ID To</th><td><input name="idend"  /></td></tr>

<tr><td colspan="2" ><input type="submit" name="submit" value="Migrate"  /></td></tr>
</table>
</form>

