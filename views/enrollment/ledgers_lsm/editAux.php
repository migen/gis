<h5>
	Edit Aux

</h5>


<form method="POST" >
<table class="gis-table-bordered table-altrow"  >
<tr>
	<th>Student</th>
	<td><?php echo $row['student']; ?></td>
</tr>

<tr>
	<th>Fee</th>
	<td>
		<select name="aux[feetype_id]" >
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['feetype_id'])? 'selected':NULL; ?>  >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
</tr>

<tr>
	<th>Amount</th>
	<td><input name="aux[amount]" value="<?php echo $row['amount']; ?>"  /></td>
</tr>

<tr>
	<th>Due</th>
	<td><input name="aux[due]" value="<?php echo $row['due']; ?>"  /></td>
</tr>

<tr>
	<th>Number</th>
	<td><input name="aux[num]" value="<?php echo $row['num']; ?>"  /></td>
</tr>


</table>


<p>
	<input type="submit" name="submit" value="Update" onclick="return confirm('Proceed?');" />
</p>

</form>