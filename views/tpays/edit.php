<?php 
	
	// pr($data);

?>

<h5>
	Edit Ledgers Payment
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><input class="pdl05" value="<?php echo $row['id']; ?>" readonly /></td></tr>
<tr><th>Date</th><td><input name="date" value="<?php echo $row['date']; ?>" /></td></tr>
<tr><th>Pointer</th><td><input name="pointer" value="<?php echo $row['pointer']; ?>" /></td></tr>

<tr><th>Fee</th><td>
<select name="feetype_id" class="vc200" >
	<?php foreach($feetypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['feetype_id'])?'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Tender</th><td>
<select name="paytype_id" class="vc150" >
	<?php foreach($paytypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['paytype_id'])?'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Bank</th><td>
<select name="bank_id" class="vc150" >
	<option value="0" >Choose</option>
	<?php foreach($banks AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['bank_id'])?'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Amount</th><td><input name="amount" value="<?php echo $row['amount']; ?>" /></td></tr>
<tr><th>OR Number</th><td><input name="orno" value="<?php echo $row['orno']; ?>" /></td></tr>
<tr><th>Payer</th><td><input name="payer" value="<?php echo $row['payer']; ?>" /></td></tr>
<tr><th>Reference</th><td><input name="details" value="<?php echo $row['reference']; ?>" /></td></tr>

<tr><th colspan="2" >
	<input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');"  />
	<button><a class="no-underline txt-black" href='<?php echo URL."ledgers/student/".$row['scid']; ?>' >Cancel</a></button>
</th></tr>

</table>
</form>


