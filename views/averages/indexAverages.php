<h5>
	Averages
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'averages/bed'; ?>" >BED</a>
	| <a href="<?php echo URL.'averages/shs'; ?>" >SHS</a>
	
</h5>

<div class="accordParent" >	
<button onclick="accorToggle('genpage')" style="width:274px;" class="bg-blue2" > <p class="b f16" >Averages</p> </button>  	
<table id="genpage" class="gis-table-bordered table-fx" >

<tr><td class="vc250" >
	<tr><th><a href="<?php echo URL.'averages'; ?>" >Averages</a></th></tr>
</td></tr>

<tr><th><a href="<?php echo URL.'averages/bed'; ?>" >BED</a></th></tr>
<tr><th><a href="<?php echo URL.'averages/shs'; ?>" >SHS</a></th></tr>

<tr><th class="center" >---</th></tr>



<tr><td>&nbsp;</td></tr>

</table>
</div>	<!-- accorParent -->
