
<form method="POST" >

<table>
<tr><th>Date</th><th>Or No</th><th>Amount</th><th>Tender</th><th>Res/Tuition</th><th>Reference</th></tr>
<tr>
	<td><input class="vc150" type="date" name="date" value="<?php echo $_SESSION['today']; ?>"  /></td>
	<td><input class="vc80" name="orno" value="<?php echo ($last_orno+1); ?>"  /></td>
	<td><input class="vc80" name="amount" value=""  /></td>
	<td>
		<select name="paytype_id" class="vc120" >			
			<?php foreach($paytypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
 		</select>
	</td>
	<td>
		<select name="pointer" class="vc120" >
			<option value="0" >Reservation</option>
			<option value="1" >Tuition</option>
		</select>
	</td>
	<td><input type="text" name="reference" value=""  /></td>
	<td><input type="submit" name="submit" value="Pay" /></td>	
</tr>
</table>
</form>
