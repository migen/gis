<h5>
	Row Counter
	| <?php $this->shovel('homelinks'); ?>

</h5>

<form method="GET" >

<table class="gis-table-bordered" >
<?php $dbtbl=isset($_GET['dbtbl'])? $_GET['dbtbl']:"2017_dbgis_".VCFOLDER; ?>
<tr><th>DB Table</th><td><input class="vc300" name="dbtbl" value="<?php echo $dbtbl; ?>" ></td></tr>
<tr><th colspan=2><input type="submit" name="submit" ></th></tr>

</table>
</form>
