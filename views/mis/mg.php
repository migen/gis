<h5>
	GIS Profile |
	<?php  $this->shovel('homelinks','mis'); ?>
</h5>





<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th>&nbsp;</th><th class="vc200 white" > Features </th></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc300" > Web based </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc300" > Smart Computing </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc300" > Multi-Users </td></tr>



</table>


<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';var x;

$(function(){
	rc('rc');

	
})


function rc(cls){
	var x;
	$('.'+cls).each(function(){
		x = this.rowIndex;
		$(this).find("td:first").text(x);
	});
}
	
	
</script>