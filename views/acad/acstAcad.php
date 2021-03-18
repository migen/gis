
<h5>
	Accordion | <?php $this->shovel('homelinks'); ?>
	
	
</h5>


<table class="accordion menu gis-table-bordered table-altrow" >
	<tr><th style="height:50px;vertical-align:middle;" class="center headrow vc300" onclick="accordionTable('menu');" >Menu</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'cir/index'.DBYR; ?>" >C I R</a></td></tr>
	

</table>


<br />

<?php 

$incs = SITE.'views/customs/'.VCFOLDER.'/menu_acst.php';		
if(is_readable($incs)){
	include_once($incs);
	
}

?>




<script>


$(function(){
	
	// $('.accordion td').hide();
	
})



function accordionTable(cls){ $("."+cls+" td").toggle(); }

</script>
