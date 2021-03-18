<?php // pr($data);?>

<h5>
	<a href="<?php echo URL; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			| <a onclick="doubleConfirm('Are you sure?');return false;" href="<?php echo URL.'webpages/delete/'.$wp['id']; ?>">Delete</a> 	
</h5>


<!---------------------------------------------------------------------------------->
<form method='post' >
<?php include('forms/webpage.php'); ?>		
<p><input type='submit' name='submit' value='Submit'><input type="button" name="cancel" value="Cancel" onclick="document.location='index';" /></p>		
</form> 

<script></script>