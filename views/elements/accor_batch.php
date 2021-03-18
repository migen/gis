<?php 
	
	$dbo=PDBO; 
	$dbsubjects="{$dbo}.05_subjects";
	$dbcriteria="{$dbo}.05_criteria";
	$dblevels="{$dbo}.05_levels";
	$dbsections="{$dbo}.05_sections";
	$dbroles="{$dbo}.00_roles";
	

?>

<table class="faves accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('faves');" >Batch Update / Setfield</th></tr>
	<tr><td class="vc250" >
		<a href="<?php echo URL.'gset'; ?>" >Gset</a>
	</th></tr>
	<tr><td>
		<a href='<?php echo URL."batch/update/$dbsubjects"; ?>' >Subjects</a>
		| <a href='<?php echo URL."batch/setfield/$dbsubjects/subjtype_id?fields=code"; ?>' >Setfield</a>
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."batch/update/$dbcriteria"; ?>' >Criteria</a>
		| <a href='<?php echo URL."batch/setfield/$dbcriteria/is_active?fields=code"; ?>' >Setfield</a>
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."batch/update/$dblevels"; ?>' >Levels</a>
		| <a href='<?php echo URL."batch/setfield/$dblevels/code?fields=code"; ?>' >Setfield</a>
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."batch/update/$dbsections"; ?>' >Sections</a>
		| <a href='<?php echo URL."batch/setfield/$dbsections/code?fields=code"; ?>' >Setfield</a>
	</td></tr>


<tr><td>&nbsp;</td></tr>


</table>




