<h5>
	Snippets
	| <?php $this->shovel('homelinks'); ?>

</h5>

<div class="accordParent" >	
<button onclick="accorToggle('gset')" style="width:274px;" class="bg-blue2" > <p class="b f16" >GSET</p> </button>  	
<table id="gset" class="gis-table-bordered table-fx" >

	<tr><td style="width:250px;" ><a href="<?php echo URL.'cir'; ?>" >CIR</a></td></tr>
	<tr><td><a href="<?php echo URL.'randomizer'; ?>" >Randomizer</a></td></tr>
	<tr><td><a href="<?php echo URL.'excel'; ?>" >Excel Controller</a></td></tr>
	<tr><td><a href="<?php echo URL.'pivots'; ?>" >Pivot Controler</a></td></tr>

	
	<tr><td>&nbsp;</td></tr>	
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td><a href="<?php echo URL.'gset/truncateDummies'; ?>" >Truncate Grades Activities Scores</a></td></tr>
	<tr><td>Purge GIS (Trunc All)</td></tr>



</table>
</div>	<!-- accorParent -->