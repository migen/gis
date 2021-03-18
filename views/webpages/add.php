
<h5>
	Add
	| <a href="<?php echo URL.'webpages'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			

</h5>


<!----------------------------------------------------------------------------------------------------------------------------------->

<form method='post' >

<?php $i=0; ?>
<?php unset($row);
include('forms/webpage.php'); ?>

<p><input type='submit' name='submit' value='Submit'>
&nbsp; <input type="button" name="cancel" value="Cancel" onclick="document.location='index';" /></p>		


</form> 

<!----------------------------------------------------------------------------------------------------------------------------------->

<script>

$(function(){

	nextViaEnter();

})


</script>