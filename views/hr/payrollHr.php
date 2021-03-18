<style>
	#tbl_payroll tr > td,#tbl_payroll tr > th { text-align: center; }
	#tbl_payroll tr > td.leftx{ text-align:left;  }

</style>

<h5>
	Payroll
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'hr/reset'; ?>" >Reset HR</a>

</h5>

<p>
	<form method="GET" >
		<table class="gis-table-bordered table-altrow" >
			<tr><th>Pay period</th>
				<td>
					<select name="payperiod" >
						<?php foreach($_SESSION['hr']['payperiods'] AS $k => $v): ?>
							<option value="<?php echo $v; ?>" 
									<?php echo (isset($_GET['payperiod']) && ($_GET['payperiod']==$v))? 'selected':NULL; ?>
							><?php echo $k; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td><input type="submit" name="filter" value="Filter"  /></td>
			</tr>			
		</table>	
	</form>
</p>

<?php if(isset($_GET['filter'])): ?>
<table id="tbl_payroll" class="gis-table-bordered table-altrow" >
<tr>
	<th rowspan=2 >ID</th>
	<th rowspan=2 >Employee</th>
	<th colspan=2 >Hours - OT</th>	
	<th colspan=2 >Amount - OT</th>	
	<th colspan=2 >Total Amount<br />OT</th>	
</tr>
<tr>
	<th>Regular</th>
	<th>Special</th>
	<th>Regular</th>
	<th>Special</th>	
	<th>Regular</th>
	<th>Special</th>		
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td style="text-align:left;" ><?php echo $rows[$i]['employee']; ?></td>
	<td><?php echo $rows[$i]['total_hours_overtime']; ?></td>
	<td><?php echo $rows[$i]['hours_special']; ?></td>
	<?php 
		// $amt_regular=
	?>
	<td><?php echo 11; ?></td>
	<td><?php echo 22; ?></td>
	
</tr>
<?php endfor; ?>

</table>
<?php endif; ?>
