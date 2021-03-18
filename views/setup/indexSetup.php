

<h5>
	Setup Home | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'setup/gis'; ?>" >GIS Setup</a>
	| <a href="<?php echo URL.'records/dbtables'; ?>" >DB Tables</a>
	
	
</h5>





<div>

<table class="setup accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('setup');" >Setup</th></tr>
	<tr><th class="vc200" >INIT / Setup Table</th></tr>	
	<tr><td>
		  <a href="<?php echo URL.'legends/descriptions?ctype=1'; ?>" >DG</a>
		| <a href="<?php echo URL.'legends/equivalents?ctype=1'; ?>" >Equiv</a>	
	</td></tr>
	<tr><td><a href="<?php echo URL.'setup/loading/4'; ?>" >Loading (Level)</a></td></tr>
	<tr><td><a href="<?php echo URL.'misc/defvals'; ?>" >Default Values</a></td></tr>
	<tr><td><a href="<?php echo URL.'purge/gis'; ?>" >*Purge GIS (Exe)</a></td></tr>

	<tr><th class="" >--- Misc ---</th></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncAll'; ?>" >Sync All</a></td></tr>
	<tr><td>
		<a href="<?php echo URL.'synclist/crid/1'; ?>" >Crid</a>
		| <a href="<?php echo URL.'synclist/lvl/4'; ?>" >Lvl</a>	
	</td></tr>
	
</table>
</div>