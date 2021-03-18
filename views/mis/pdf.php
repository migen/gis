
<h5>
	PDF Quick Guides
	
	
</h5>


<div class="accordParent" >	
<button onclick="accorToggle('grading')" style="width:274px;" class="bg-blue2" > <p class="b f16" >Grading</p></button>  	
<table id="grading" class="gis-table-bordered table-fx" >
<tr><td class="vc250" ><a href="<?php echo URL.'mis'; ?>" >Home</a></td></tr>
<tr><td><a target='blank' href="<?php echo '../public/documents/scsc.pdf'; ?>" >SCSC</a></td></tr>
<tr><td><a target='blank' href="<?php echo WURL.'gisdata/gis_quick_guide.pdf'; ?>" >GIS Quick Guide</a></td></tr>

<tr><td>&nbsp;</td></tr>

</table>
</div>	<!-- faves -->



<script>

var gurl = 'http://<?php echo GURL; ?>';
			
$(function(){
	hd();
	
})
	
		





function accorToggle(sxn){ $("#"+sxn).toggle(); }
function accorHd(){ $(".accordParent table:not(:first)").hide(); }
function expandAccordions(){ $(".accordParent table").show(); }
function collapseAccordions(){ $(".accordParent table").hide(); }
		
		
</script>
