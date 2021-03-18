
<?php 
	$letters=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
?>

<select id="letsel" name="letsel" >
<?php foreach($letters AS $letter): ?>
	<option><?php echo $letter; ?></option>
<?php endforeach; ?>
</select>
