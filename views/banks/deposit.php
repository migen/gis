<h5>
	
	Daily Deposit 

</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Date</th><td><input class="vc200" name="post[date]" value="<?php echo $_SESSION['today']; ?>"  /></td></tr>
<tr><th>Bank</th><td>
<select name="post[bank_id]" class="vc200"  >
<option >Choose</option>
<?php foreach($banks AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Amount</th><td><input class="vc200" name="post[amount]" value="0.00"  /></td></tr>




</table>


<p><input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" /></p>



</form>