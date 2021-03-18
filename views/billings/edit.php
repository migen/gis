<h5>
	Edit Billing
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'billings'; ?>">Billings</a>
	| <a href="<?php echo URL.'billings/view/'.$id; ?>">View</a>
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Type</th><td><?php echo $row['jobtype']; ?></td></tr>
<tr><th>SY</th><td><input type="text" name="post[sy]" value="<?php echo $row['sy']; ?>" /></td></tr>
<tr><th>Date</th><td><input type="date" name="post[date]" value="<?php echo $row['date']; ?>" /></td></tr>
<tr><th>Date Done</th><td><input type="date" name="post[date_done]" value="<?php echo $row['date_done']; ?>" /></td></tr>
<tr><th>Date Paid</th><td><input type="date" name="post[date_paid]" value="<?php echo $row['date_paid']; ?>" /></td></tr>
<tr><th>Amount</th><td><input type="text" name="post[amount]" value="<?php echo $row['amount']; ?>" /></td></tr>
<tr><th>Paid</th><td><input type="text" name="post[paid]" value="<?php echo $row['paid']; ?>" /></td></tr>
<tr><th>Reference</th><td><input type="text" name="post[reference]" value="<?php echo $row['reference']; ?>" /></td></tr>
<tr><th>Description</th><td><textarea name="post[description]" ><?php echo $row['reference']; ?></textarea></td></tr>

<tr><td colspan="2" ><input type="submit" value="Submit" name="submit" /></td></tr>

</table>
</form>
