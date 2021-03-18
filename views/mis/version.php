<h5>
	<span class="" ondblclick="tracehd();" > GIS Version</span> 
		
	<span class="hd" >
		| <a href='<?php echo URL.'files/versionEdit'; ?>' >Edit</a>	
	</span>
</h5>

<?php 
	echo html_entity_decode($version);

?>



<!------------------------------------------------------------------------------------------------------------------------>


<script>

var gurl = 'http://<?php echo GURL; ?>';
$(function(){
	hd();

	
})




</script>