<h5>
	PHP | <?php $this->shovel('homelinks'); ?>
	
	
</h5>


<table class="menu gis-table-bordered table-altrow" >
	<tr><th class="headrow vc300" onclick="accordionTable('menu');" >Menu</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'php/info'; ?>" >Info</a></td></tr>
	<tr><td class="" ><a href="<?php echo URL.'php/keywords'; ?>" >Keywords / Reserved words</a></td></tr>

</table>

<table class="css gis-table-bordered table-altrow" >
	<tr><th class="headrow vc300" onclick="accordionTable('css');" >CSS</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'css/one'; ?>" >CSS 1</a></td></tr>
	<tr><td class="" ><a href="<?php echo URL.'css/two'; ?>" >CSS 2</a></td></tr>
</table>


<script>


function accordion(){
	$(".accordion tbody:not(:first)").hide();	
	$('.accordion th').click(
		function() {
			$('table.accordion').children('tbody').slideUp();						
			$(this).parents('table.accordion').children('tbody').toggle();			
		}
	)		
}	/* fxn */

function accorToggle(sxn){ $("#"+sxn).toggle(); }

function accordionTable(cls){
	// $("."+cls+":not(:first)").toggle();
	$("."+cls+" td").toggle();
	
}



</script>
