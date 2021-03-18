<h5>
	Paymaster (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks','HR'); ?>	
	<?php if($_SESSION['user']['role_id']==RMIS): ?>
		| <a href="<?php echo URL.'paymaster/sync'; ?>" >Sync</a>
	<?php endif; ?>
	| <a href="<?php echo URL.'payroll/employees?all'; ?>" >Paygroup</a>
	
	
</h5>

<?php 
	// pr($rows[0]);
?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ECID</th>
	<th>Employee<br />ID</th>
	<th>Employee</th>
	<th>Salary<br />Monthly</th>
	<th>Salary <br />Semi-<br />Monthly</th>
	<th>Basic<br />Daily</th>
	<th>Ecola<br />Daily</th>
	<th>Basic<br />Hourly</th>
	<th>Ecola<br />Hourly</th>

	<th>Regular<br />Overtime<br />Hourly</th>
	<th>Special<br />Overtime<br />Hourly</th>
	
	<th>Special<br />Restday<br />Overtime<br />Hourly</th>
	<th>Holiday<br />Overtime<br />Hourly</th>
	
	<th>Loan<br />Semi-<br />Monthly</th>
	<th>Cash<br />Advance<br />Semi-<br />Monthly</th>
	
	<th>Loan<br />Deadline</th>
	<th>Cash<br />Advance<br />Deadline</th>
	
	<th>SSS<br />Semi-<br />Monthly</th>
	<th>Philhealth<br />Semi-<br />Monthly</th>
	<th>Pagibig<br />Semi-<br />Monthly</th>
	
	<th>SSS<br />No</th>
	<th>Philhealth<br />No</th>
	<th>Pagibig<br />No</th>
	<th>Edit</th>

	
	
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ecid']; ?></td>
	<td><?php echo $rows[$i]['emplcode']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['starting_salary_semimonthly']*2,2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['starting_salary_semimonthly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['basic_daily'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['ecola_daily'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['basic_hourly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['ecola_hourly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['regular_overtime_hourly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['special_overtime_hourly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['special_restday_overtime_hourly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['holiday_overtime_hourly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['loan_semimonthly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['cashadvance_semimonthly'],2); ?></td>
	<td class="right" ><?php echo $rows[$i]['loan_deadline']; ?></td>
	<td class="right" ><?php echo $rows[$i]['cashadvance_deadline']; ?></td>
	
	<td class="right" ><?php echo number_format($rows[$i]['sss_semimonthly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['philhealth_semimonthly'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['pagibig_semimonthly'],2); ?></td>

	<td class="right" ><?php echo $rows[$i]['sssno']; ?></td>
	<td class="right" ><?php echo $rows[$i]['philhealthno']; ?></td>
	<td class="right" ><?php echo $rows[$i]['pagibigno']; ?></td>
	<td><a href="<?php echo URL.'paymaster/edit/'.$rows[$i]['pcid']; ?>" >Edit</a></td>

	
</tr>
<?php endfor; ?>
</table>

