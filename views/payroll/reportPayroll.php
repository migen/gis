<style>
	#tbl_payroll tr > td,#tbl_payroll tr > th { text-align: center; }
	#tbl_payroll tr > td.left{ text-align:left;  }
	#tbl_payroll tr > td.right{ text-align:right;  }

</style>

<h5>
	Payroll Report
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'paymaster/all'; ?>" >Paymaster</a>


</h5>

<?php 
	// pr($rows[0]);
?>



<?php if($payperiod_id>0): ?>
<table id="tbl_payroll" class="gis-table-bordered table-altrow" >
<tr>
	<th rowspan=2 >#</th>
	<th rowspan=2 >ECID</th>
	<th rowspan=2 >Employee</th>
	<th rowspan=2 >Starting<br />Salary<br />Semimonthly</th>
	<th colspan=2 >Hours - OT</th>	
	<th colspan=2 >Amount - OT</th>	
	<th rowspan=2 >Total<br />Amount<br />Overtime</th>	
	<th rowspan=2 >Total<br />Earnings</th>	
	<th colspan=2 >Tardiness</th>	
	<th colspan=2 >Absences</th>	
	<th class="screen" rowspan=2 ></th>	
	
</tr>

<!-- row2 -->
<tr>
	<th>Regular</th>
	<th>Special</th>
	<th>Regular</th>
	<th>Special</th>	
	
	<th>Hours</th>	
	<th>Amount</th>	
	<th>Hours</th>	
	<th>Amount</th>	

	
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td style="text-align:left;" ><?php echo $rows[$i]['ecid']; ?></td>
	<td style="text-align:left;" ><?php echo $rows[$i]['employee']; ?></td>
	<td style="text-align:right;" ><?php echo number_format($rows[$i]['starting_salary_semimonthly'],2); ?></td>
	<td><?php echo $rows[$i]['hours_overtime_regular']; ?></td>
	<td><?php echo $rows[$i]['hours_overtime_special']; ?></td>
	<?php $amount_overtime_regular=$rows[$i]['hours_overtime_regular']*$rows[$i]['regular_overtime_hourly']; ?>
	<td class="right" ><?php echo number_format($amount_overtime_regular,2); ?></td>
	<td></td>	
	<?php $total_overtime=&$amount_overtime_regular; ?>
	<td class="right" ><?php echo number_format($rows[$i]['amount_overtime_total'],2); // pr($total_overtime); ?></td>	

	<?php $total_earnings=$total_overtime+$rows[$i]['starting_salary_semimonthly']; ?>
	<td class="right" ><?php echo number_format($rows[$i]['total_earnings'],2); // pr($total_earnings); ?></td>	
	
	<td><?php echo $rows[$i]['hours_tardy']; ?></td>
	<td><?php echo $rows[$i]['amount_tardy']; ?></td>

	<td><?php echo $rows[$i]['hours_absence']; ?></td>
	<td><?php echo $rows[$i]['amount_absence']; ?></td>

	<td><span class="screen" ><a href=""#" >Edit</a></span></td>
	
</tr>
<?php endfor; ?>

</table>
<?php endif; ?>


