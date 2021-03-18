<h5>
	Edit Version 
	| <a href='<?php echo URL.'files/version'; ?>' >Cancel</a>
</h5>


<form method="POST"  >
<textarea class="pdl05" name="version" rows="20" cols="120"   >

<?php 

include_once('incs/version.php');

?>

</textarea>

<p>
	<input type="submit" name="submit" value="Update"   /> 
	<button> <a class="no-underline black" href='<?php echo URL.'files/version'; ?>' >Cancel</a> </button>
	
</p>

</form>
