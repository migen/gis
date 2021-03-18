<div class="accordParent" >	
<button onclick="accorToggle('cluster')" style="width:262px;" class="bg-blue2" > <p class="b f16" >Cluster Setup</button>  	
<table id="cluster" class="gis-table-bordered table-fx" >

	<tr><td style="width:250px;" ><a href="<?php echo URL.'cir'; ?>" >Cluster (CIR)</a></td></tr>
	
	<tr><td>
		<a href="<?php echo URL.'syncs/syncCQ'; ?>" >Crs-Qtrs</a>
	 |	<a href="<?php echo URL.'syncs/syncAQ'; ?>" >Adv-Qtrs</a>	
	</td></tr>	


<?php if(1==1): ?>
	
<?php endif; ?>		<!-- qtr>3-->
	
	<tr><td>&nbsp;</td></tr>
	<tr><td>---Customs---</td></tr>
	<tr><td><a href="<?php echo URL.'syncoffenses/all'; ?>" >Link</a></td></tr>	

	<tr><td>&nbsp;</td></tr>


</table>
</div>	<!-- accorParent -->