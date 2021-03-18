<h3>
	Create New
	| <a href='<?php echo URL.'mis/infoEdit'; ?>' >Edit</a>
</h3>


<form method="POST"  >

<p>Note: Alias should be one word all lowercase. </p>

<p>Alias: <input class="pdl05" name="name" placeholder="alias" /></p>


<?php 

// include_once('includes/info.php');

?>

</textarea>

<p>
	<input type="submit" name="submit" value="Save"   />
	<button> <a class="no-underline black" href='<?php echo URL.'files/index'; ?>' >Cancel</a> </button>
	
</p>

</form>
