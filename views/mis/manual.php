<h5>
	<span class="" ondblclick="tracehd();" > GIS Manual </span> 
		
	<span class="hd" >
		| <a href='<?php echo URL.'files/manualEdit'; ?>' >Edit</a>	
	</span>
</h5>

<?php 
	echo html_entity_decode($manual);

?>



<!------------------------------------------------------------------------------------------------------------------------>


<script>

var gurl = 'http://<?php echo GURL; ?>';
$(function(){
	hd();

	
})




</script>