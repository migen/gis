<h5>
	Edit <?php echo $ortype; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Type</th><td><?php echo $ortype; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['student']; ?></td></tr>
<tr><th>OR No</th><td><input name="post[orno]" value="<?php echo $row['orno']; ?>" class="vc120"  /></td></tr>
<tr><th>Date</th><td><input name="post[date]" value="<?php echo $row['date']; ?>" class="vc120"  /></td></tr>
<tr><th>Amount</th><td><input name="post[amount]" value="<?php echo $row['amount']; ?>" class="vc120"  /></td></tr>
<tr><th>Fee | Num</th><td>
<select class="vc120" name="post[feetype_id]" >
	<option value="0" >Choose</option>
	<?php foreach($feetypes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['feetype_id'])? 'selected':NULL; ?> >
		<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
<input class="vc50" name="post[pointer]" value="<?php echo $row['pointer']; ?>" />
</td></tr>
<tr><th>Pay Type</th><td>
<select class="vc120" name="post[paytype_id]" >
	<option value="0" >Choose</option>
	<?php foreach($paytypes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['paytype_id'])? 'selected':NULL; ?> >
		<?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Bank</th><td>
<select class="vc120" name="post[bank_id]" >
	<option value="0" >Choose</option>
	<?php foreach($banks AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['bank_id'])? 'selected':NULL; ?> >
		<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Reference</th><td><input name="post[reference]" value="<?php echo $row['reference']; ?>" class="vc120"  /></td></tr>
<tr><th>Payer</th><td><input name="post[payer]" value="<?php echo $row['payer']; ?>" class="vc120"  /></td></tr>
</table>

<p><input type="submit" name="submit" value="Submit"  /></p>
</form>



