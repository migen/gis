<?php 


?>


<h5>
	Datasheets | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students/filter'; ?>">Filter</a>
	
	
</h5>

<table class="datasheet accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('datasheet');" >Datasheet</th></tr>


	<tr><td style="width:250px;" ><a href="<?php echo URL.'students/datasheet'; ?>" >Datasheet</a></td></tr>
	<tr><td>
		<a href="<?php echo URL.'datasheets/lockAll'; ?>" >Lock All</a>
		| <a href="<?php echo URL.'datasheets/openAll'; ?>" >Open All</a>
	</td></tr>

</table>





<div class="clear ht50" ></div>





