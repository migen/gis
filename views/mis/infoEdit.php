<h5>
	Edit GIS Information
	| <a href='<?php echo URL.'mis/infoEdit'; ?>' >Edit</a>
</h5>


<form method="POST"  >
<textarea class="pdl05" name="info" rows="20" cols="120"   >

<?php 

include_once('incs/info.php');

?>

</textarea>

<p>
	<input type="submit" name="submit" value="Update"   />
	<button> <a class="no-underline black" href='<?php echo URL.'files/info'; ?>' >Cancel</a> </button>
	
</p>

</form>
