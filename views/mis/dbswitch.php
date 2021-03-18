<h5>
	<span class="" ondblclick="tracehd();" > GIS DB Switcher </span> 
		
	<span class="hd" >
		| <a href='<?php echo URL.'mis/PathsEdit'; ?>' >Edit</a>	
	</span>
</h5>

<?php 
	echo html_entity_decode($paths);

?>



<!------------------------------------------------------------------------------------------------------------------------>


<script>

var gurl = 'http://<?php echo GURL; ?>';
$(function(){
	hd();

	
})




</script>