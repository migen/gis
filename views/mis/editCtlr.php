<h5>
	Edit GIS Information
	| <a href='<?php echo URL.'mis/infoEdit'; ?>' >Edit</a>
</h5>


<form method="POST"  >
<textarea class="pdl05" name="info" rows="20" cols="120"   >

<?php 

// include_once('incs/info.php');

?>

<?php 
	echo html_entity_decode($ctlr);

?>



</textarea>

<p>
	<input type="submit" name="submit" value="Update"   />
	&nbsp; <input type="button" name="cancel" value="Cancel" onclick="document.location='index';" /></p>		
	
</p>

</form>
