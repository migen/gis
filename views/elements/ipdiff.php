

<?php 

	// if(isset($library_setup) && ($library_setup==1)):
	if($data['dif']<1):
	
?>

<h5>IP Changed.</h5>


<h4>Option 1: Manual</h4>
<form method="POST" >
<select name="dif" >
	<option value="2">GS</option>
	<option value="3">HS</option>
	<option value="4">SHS</option>
	<option value="1">PS</option>
</select>
<input type="submit" name="set" value="Set"  />
</form>


<h4>Option 2: Auto</h4>
	
	<p>
		1. Get the new ip. cmd > ipconfig<br />
		2. Ask MIS to update <a href="<?php echo URL.'subdepts'; ?>" >Subdepts</a> IP. <br />
		3. Library <a href="<?php echo URL.'librarians/reset'; ?>" >Reset</a>.
	</p>

<?php exit; ?>
<?php endif; ?>	