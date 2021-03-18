<h5>
	Edit Paymaster 
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
<tr><th>Starting Salary Semi-Monthly</th><td><input class="pdl05" name="post[starting_salary_semimonthly]" 
		value="<?php echo number_format($row['starting_salary_semimonthly'],2); ?>" /></td></tr>
		
<tr><th>Basic Salary Semi-Monthly</th><td><input class="pdl05" name="post[basic_salary_semimonthly]" 
		value="<?php echo number_format($row['basic_salary_semimonthly'],2); ?>" /></td></tr>		

<tr><th>Ecola Semi-Monthly</th><td><input class="pdl05" name="post[ecola_semimonthly]" 
		value="<?php echo number_format($row['ecola_semimonthly'],2); ?>" /></td></tr>		
		

<tr><th>Basic Daily</th><td><input class="pdl05" name="post[basic_daily]" 
		value="<?php echo number_format($row['basic_daily'],2); ?>" /></td></tr>		
		
<tr><th>Basic Hourly</th><td><input class="pdl05" name="post[basic_hourly]" 
		value="<?php echo number_format($row['basic_hourly'],2); ?>" /></td></tr>		

<tr><th>Ecola Hourly</th><td><input class="pdl05" name="post[ecola_hourly]" 
		value="<?php echo number_format($row['ecola_hourly'],2); ?>" /></td></tr>		

<tr><th>Regular Overtime Hourly</th><td><input class="pdl05" name="post[regular_overtime_hourly]" 
		value="<?php echo number_format($row['regular_overtime_hourly'],2); ?>" /></td></tr>		
		
<tr><th>Special Overtime Hourly</th><td><input class="pdl05" name="post[special_overtime_hourly]" 
		value="<?php echo number_format($row['special_overtime_hourly'],2); ?>" /></td></tr>		

<tr><th>Special Restday Overtime Hourly</th><td><input class="pdl05" name="post[special_restday_overtime_hourly]" 
		value="<?php echo number_format($row['special_restday_overtime_hourly'],2); ?>" /></td></tr>		

<tr><th>Holiday Overtime Hourly</th><td><input class="pdl05" name="post[holiday_overtime_hourly]" 
		value="<?php echo number_format($row['holiday_overtime_hourly'],2); ?>" /></td></tr>		
		
<tr><th>Loan Semi-Monthly</th><td><input class="pdl05" name="post[loan_semimonthly]" 
		value="<?php echo number_format($row['loan_semimonthly'],2); ?>" /></td></tr>		

<tr><th>Cash Advance Semi-Monthly</th><td><input class="pdl05" name="post[cashadvance_semimonthly]" 
		value="<?php echo number_format($row['cashadvance_semimonthly'],2); ?>" /></td></tr>		


<tr><th>Loan Deadline</th><td><input class="pdl05" name="post[loan_deadline]" 
		value="<?php echo $row['loan_deadline']; ?>" /></td></tr>		

<tr><th>Cash Advance Deadline</th><td><input class="pdl05" name="post[cashadvance_deadline]" 
		value="<?php echo $row['cashadvance_deadline']; ?>" /></td></tr>		


<tr><th>SSS No.</th><td><input class="pdl05" name="post[sssno]" 
		value="<?php echo $row['sssno']; ?>" /></td></tr>		
		
<tr><th>Philhealth No.</th><td><input class="pdl05" name="post[philhealthno]" 
		value="<?php echo $row['philhealthno']; ?>" /></td></tr>				

<tr><th>Pagibig No.</th><td><input class="pdl05" name="post[pagibigno]" 
		value="<?php echo $row['pagibigno']; ?>" /></td></tr>						
		
		
<tr><td colspan=2 ><input type="submit" name="submit" value="Update" /></td></tr>	
		
		
</table>
</form>
<?php endif; ?>
