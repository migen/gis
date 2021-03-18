<h5>
	View Billing
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'billings'; ?>">Billings</a>
	| <a href="<?php echo URL.'billings/edit/'.$id; ?>">Edit</a>
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Type</th><td><?php echo $row['jobtype']; ?></td></tr>
<tr><th>SY</th><td><?php echo $row['sy']; ?></td></tr>
<tr><th>Date</th><td><?php echo $row['date']; ?></td></tr>
<tr><th>Date Done</th><td><?php echo $row['date_done']; ?></td></tr>
<tr><th>Date Paid</th><td><?php echo $row['date_paid']; ?></td></tr>
<tr><th>Amount</th><td><?php echo number_format($row['amount'],2); ?></td></tr>
<tr><th>Paid</th><td><?php echo number_format($row['paid'],2); ?></td></tr>
<tr><th>Balance</th><td><?php echo number_format($row['balance'],2); ?></td></tr>
<tr><th>Reference</th><td><?php echo $row['reference']; ?></td></tr>
<tr><th>Description</th><td class="vc200" ><?php echo $row['description']; ?></td></tr>


</table>
</form>
