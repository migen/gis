<script>
	$(function(){
		$('.mingo').hide();
	})
</script>

<?php // pr($data['selects']); ?>


<div id='searchTxn' class='mingo' >


<h2 class='indigo center'>Advanced</h2>

<form method='get' >

<table>
<tr><td>Date From</td><td><input type='text' class='juice' name='from' /></td></tr>
<tr><td>Date To</td><td><input type='text' class='juice' name='to' /></td></tr>
<?php if($_SESSION['user_id'] == 1) : ?>
	<tr><td>User</td><td><select name='user'><option value=''>Choose one</option><?php	foreach($data['selects']['users'] as $row): ?>
	<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
	<?php	endforeach; ?></select></td></tr>
<?php endif; ?>
	
<tr><td>Status</td><td><select name='status'><option value=''>Choose one</option><?php	foreach($data['selects']['statuses'] as $row): ?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php	endforeach; ?></select></td></tr>	

<tr><td>Type</td><td><select name='txntype'><option value=''>Choose one</option><?php	foreach($data['selects']['txntypes'] as $row): ?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php	endforeach; ?></select></td></tr>	

<tr><td>Entity From</td><td><select name='fren'><option value=''>Choose one</option><?php	foreach($data['selects']['entitys'] as $row): ?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php	endforeach; ?></select></td></tr>

<tr><td>Entity To</td><td><select name='tent'><option value=''>Choose one</option><?php	foreach($data['selects']['entitys'] as $row): ?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php	endforeach; ?></select></td></tr>	
	
<tr><td>Transaction</td><td><input type='text' name='name' /></td></tr>

<tr><td>Share</td><td><select name='share'><option value=''>Choose one</option><?php	foreach($data['selects']['groups'] as $row): ?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php	endforeach; ?></select></td></tr>

<tr><td>&nbsp;</td><td><input type='submit' name='submit' value='Search'></td></tr>
</table>
</form>
</div>
