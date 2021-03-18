<h5>
	Edit POS Cheque
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
	
</h5>

<form method="POST" >
<input type="hidden" name="url" value="<?php echo $url; ?>" />
<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Bank</th><td>
<select name="post[bank_id]" >
	<?php foreach($banks AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo ($sel['id']==$row['bank_id'])? 'selected':NULL; ?> ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Amount</th><td><input name="post[tenderetc]" value="<?php echo $row['tenderetc']; ?>" /></td></tr>
<tr><th>Reference</th><td><input name="post[etcno]" value="<?php echo $row['etcno']; ?>" /></td></tr>
<tr><th colspan="2" ><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>
