<h5>
	View Paymaster 
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'paymaster/all'; ?>" >All</a>
	
	
</h5>

<?php if($pcid): ?>

<?php 
// pr($row);
?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>PCID</th><td><?php echo $row['pcid']; ?></td></tr>
<tr><th>Employee</th><td><?php echo $row['employee']; ?></td></tr>
<tr><th>Starting Salary Semi-Monthly</th><td><?php echo number_format($row['starting_salary_semimonthly'],2); ?></td></tr>
		
<tr><th>Basic Salary Semi-Monthly</th><td><?php echo number_format($row['basic_salary_semimonthly'],2); ?></td></tr>		
<tr><th>Ecola Semi-Monthly</th><td><?php echo number_format($row['ecola_semimonthly'],2); ?></td></tr>		
<tr><th>Basic Daily</th><td><?php echo number_format($row['basic_daily'],2); ?></td></tr>		

		
<tr><th>Basic Hourly</th><td><?php echo number_format($row['basic_hourly'],2); ?></td></tr>		

<tr><th>Ecola Hourly</th><td><?php echo number_format($row['ecola_hourly'],2); ?></td></tr>		

<tr><th>Regular Overtime Hourly</th><td><?php echo number_format($row['regular_overtime_hourly'],2); ?></td></tr>		
		
<tr><th>Special Overtime Hourly</th><td><?php echo number_format($row['special_overtime_hourly'],2); ?></td></tr>		

<tr><th>Special Restday Overtime Hourly</th><td><?php echo number_format($row['special_restday_overtime_hourly'],2); ?></td></tr>		

<tr><th>Holiday Overtime Hourly</th><td><?php echo number_format($row['holiday_overtime_hourly'],2); ?></td></tr>		
		
<tr><th>Loan Semi-Monthly</th><td><?php echo number_format($row['loan_semimonthly'],2); ?></td></tr>		

<tr><th>Cash Advance Semi-Monthly</th><td><?php echo number_format($row['cashadvance_semimonthly'],2); ?></td></tr>		


<tr><th>Loan Deadline</th><td><?php echo $row['loan_deadline']; ?></td></tr>		

<tr><th>Cash Advance Deadline</th><td><?php echo $row['cashadvance_deadline']; ?></td></tr>		


<tr><th>SSS No.</th><td><?php echo $row['sssno']; ?></td></tr>		
		
<tr><th>Philhealth No.</th><td><?php echo $row['philhealthno']; ?></td></tr>				

<tr><th>Pagibig No.</th><td><?php echo $row['pagibigno']; ?></td></tr>						
		
		
<tr><td colspan=2 ><a href="<?php echo URL.'paymaster/edit/'.$row['pcid']; ?>" >Edit</a></td></tr>	
		
		
</table>
</form>
<?php endif; ?>
