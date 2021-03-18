<h3>
	JS | <?php $this->shovel('homelinks'); ?>


</h3>





<table class="finance accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('finance');" >Finance</th></tr>

	<tr><td class="vc250" >
		<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	</th></tr>


	<tr><td><a href='<?php echo URL."js/async"; ?>' >Async Await</a></td></tr>
	<tr><td><a href='<?php echo URL."js/promises"; ?>' >Promises</a></td></tr>
	

</table>	

