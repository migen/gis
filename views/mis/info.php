<h5>
	<span class="" ondblclick="tracehd();" > GIS Information</span> 
		
	<span class="hd" >
		| <a href='<?php echo URL.'files/infoEdit'; ?>' >Edit</a>	
	</span>
</h5>

<?php 
	echo html_entity_decode($info);

?>



<!------------------------------------------------------------------------------------------------------------------------>


<script>

var gurl = 'http://<?php echo GURL; ?>';
$(function(){
	hd();

	
})




</script>