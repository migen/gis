<style>
	div{border:1px solid white;}

</style>

<h5>
	Lookups
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uni'; ?>" >Uni</a>
	
</h5>

<div style="float:left;width:35%" >
<table class="accordion college gis-table-bordered table-altrow" >
	<tr><th class="vc300 headrow center" onclick="accordionTable('college');" >College</th></tr>
	
	<tr><td>
		  <a href="<?php echo URL.'lookups/descriptions'; ?>" >Descriptions</a>
		| <a href="<?php echo URL.'lookups/equivalents'; ?>" >Equivalents</a>
	</td></tr>	

	
	
</table>
<br />

</div>	<!-- menus -->




<div style="float:left;width:30%" >
<h5>Tasks</h5>
<ol>
	<li>custom profile for transcript</li>
	<li>ok - prof home</li>
	<li>stats</li>
	<li>ok - test prom k12-uni</li>
</ol>
</div>	<!-- tasks -->


<div class="full ht100" ></div>


<script>

$(function(){
	
	// $('.accordion td').hide();
	
})

</script>
