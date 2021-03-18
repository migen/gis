<h5>
	Edit GIS Manual
	| <a href='<?php echo URL.'mis/manualEdit'; ?>' >Edit</a>
</h5>


<form method="POST"  >
<textarea class="pdl05" name="manual" rows="20" cols="120"   >

<?php 

include_once('incs/manual.php');

?>

</textarea>

<p>
	<input type="submit" name="submit" value="Update"   />
	&nbsp; <input type="button" name="cancel" value="Cancel" onclick="document.location='manual';" /></p>		
	
</p>

</form>
