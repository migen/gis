<h5>
	Accordion | <?php $this->shovel('homelinks'); ?>
	
	
</h5>


<table class="accordion menu gis-table-bordered table-altrow" >
	<tr><th style="height:50px;vertical-align:middle;" class="center headrow vc300" onclick="accordionTable('menu');" >Menu 1 </th></tr>
	<tr><td class="" ><a href="<?php echo URL.'php/info'; ?>" >Info 1</a></td></tr>
	<tr><td class="" ><a href="<?php echo URL.'php/keywords'; ?>" >Keywords / Reserved words</a></td></tr>

</table>
<br />
<table class="accordion css gis-table-bordered table-altrow" >
	<tr><th class="headrow vc300" onclick="accordionTable('css');" >CSS</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'css/one'; ?>" >CSS 1</a></td></tr>
	<tr><td class="" ><a href="<?php echo URL.'css/two'; ?>" >CSS 2</a></td></tr>
</table>


<script>


$(function(){
	
	// $('.accordion td').hide();
	
})



function accordionTable(cls){ $("."+cls+" td").toggle(); }

</script>