<h5>
	Add Billing
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'billings'; ?>">Billings</a>
	
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
<th>Type</th>
<td>
	<select name="post[jobtype_id]" >
		<?php foreach($jobtypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>
<tr><th>SY</th><td><input type="number" name="post[sy]" value="<?php echo DBYR; ?>" /></td></tr>
<tr><th>Date</th><td><input type="date" name="post[date]" value="<?php echo $_SESSION['today']; ?>" /></td></tr>
<tr><th>Date Done</th><td><input type="date" name="post[date_done]" value="<?php echo $_SESSION['today']; ?>" /></td></tr>
<tr><th>Date Paid</th><td><input type="date" name="post[date_paid]" value="<?php ?>" /></td></tr>
<tr><th>Amount</th><td><input name="post[amount]" value="<?php echo '0.00'; ?>" /></td></tr>
<tr><th>Paid</th><td><input name="post[paid]" value="<?php echo '0.00'; ?>" /></td></tr>
<tr><th>Reference</th><td><input name="post[reference]" /></td></tr>
<tr><th>Description</th><td><textarea name="post[description]" ></textarea></td></tr>

<tr><td colspan="2" ><input type="submit" value="Submit" name="submit" /></td></tr>

</table>
</form>
