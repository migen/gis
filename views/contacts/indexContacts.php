<h5>
	Contacts | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'profiles'; ?>" >Profile</a>
	
</h5>


<table class="accordion menu gis-table-bordered table-altrow" >
	<tr><th style="height:50px;vertical-align:middle;" class="center headrow vc300" onclick="accordionTable('menu');" >Contacts</th></tr>
	
	<tr><td class="" >
		<a href="<?php echo URL.'profiles'; ?>" >Profile</a>
	</td></tr>	
	
	

</table>


<script>


$(function(){
	
	// $('.accordion td').hide();
	
})



function accordionTable(cls){ $("."+cls+" td").toggle(); }

</script>