<h3>

	Criteria | <?php $this->shovel('homelinks'); ?>
	<?php shovel('links_gset'); ?>

	


</h3>

<?php 

$dbo=PDBO;
$dbtable="{$dbo}.05_criteria";
	
?>



<table class="finance accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('finance');" >Finance</th></tr>

	<tr><td class="vc250" >
		<a href="<?php echo URL.'gset'; ?>" >Gset</a>
	</th></tr>

	<tr><td>
		<a href='<?php echo URL."batch/update/$dbtable"; ?>' >Batch</a>
		| <a href='<?php echo URL."batch/setfield/$dbtable/code?fields=code"; ?>' >Setfield</a>
	</td></tr>


	
	<tr><td>&nbsp;</td></tr>
	
</table>
