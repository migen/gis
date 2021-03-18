<?php

	$payperiods = $_SESSION['hr']['payperiods'];


?>

<h5>
	Payroll
	| <?php $this->shovel('homelinks',"HR"); ?>	
	| <a href="<?php echo URL.'hr/reset'; ?>" >Reset HR</a>
	<?php if($payperiod_id>0): ?>	
		| <a href="<?php echo URL.'payroll/initPayroll/'.$payperiod_id; ?>" >Init</a>
	<?php endif; ?>
	
</h5>

<p>
	<form method="GET" >
		<table class="gis-table-bordered table-altrow" >
			<tr><th>Pay period</th>
				<td>
					<select name="payperiod_id" >
						<?php foreach($payperiods AS $k => $v): ?>
							<option value="<?php echo $k; ?>" 
									<?php echo (isset($_GET['payperiod']) && ($_GET['payperiod']==$k))? 'selected':NULL; ?>
							><?php echo $k.' - '.$v; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td><input type="submit" name="filter" value="Filter"  /></td>
			</tr>			
		</table>	
	</form>
</p>

<div style="float:left;width:70%;min-height:500px;" >
<?php if(isset($_GET['filter'])): ?>




<?php endif; ?>

</div>	<!-- left -->


<div style="float:left;width:22%;min-height:500px;" class="unbordered" >

<table class="gis-table-bordered" >
<tr><td><a href="<?php echo URL.'edtr'; ?>" >Employee DTR</a></td></tr>
<tr><td><a href="<?php echo URL.'hr/sessions'; ?>" >HR Sessions</a></td></tr>
<tr><td><a href="<?php echo URL.'hr'; ?>" >HR</a></td></tr>
<tr><td><a href="<?php echo URL.'paymaster/all'; ?>" >Paymaster All</a></td></tr>
<tr><td><a href="<?php echo URL.'hr/reset'; ?>" >Reset (HR Settings)</a></td></tr>

<tr><td>Select pay period</td></tr>
<?php if($payperiod_id>0): ?>	
	<tr><td><a href="<?php echo URL.'payroll/cir/'.$payperiod_id; ?>" >CIR (Index)</a></td></tr>
	<tr><td><a href="<?php echo URL.'hr/initPayroll/'.$payperiod_id; ?>" >Init / Sync Payroll</a></td></tr>
	<tr><td><a href="<?php echo URL.'payroll/report/'.$payperiod_id; ?>" >Payroll Report</a></td></tr>
	<?php if($_SESSION['hr']['settings']['has_dtr']==1): ?>	
		<tr><td><a href="<?php echo URL.'payroll/processDtr/'.$payperiod_id; ?>" >Process DTR (Has Dtr)</a></td></tr>
	<?php else: ?>		
		<tr><td><a href="<?php echo URL.'payroll/edit/'.$payperiod_id; ?>" >Edit Payroll (No Dtr)</a></td></tr>
	<?php endif; ?>		
	
<?php endif; ?>		<!-- has payperiod -->


	

</table>


</div>	<!-- right -->

