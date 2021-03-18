<?php

	$payperiods = $_SESSION['hr']['payperiods'];

?>



<h5>
	HR 
	| <?php $this->shovel('homelinks',"Payroll"); ?>
	| <a href="<?php echo URL.'hr/reset'; ?>" >Reset HR</a>
	<?php if($payperiod_id>0): ?>	
		| <a href="<?php echo URL.'payroll/initPayroll/'.$payperiod_id; ?>" >Init</a>
	<?php endif; ?>
	
</h5>




<div style="float:left;width:50%;min-height:500px;" class="unbordered" >

<table class="gis-table-bordered" >
<tr><td><a href="<?php echo URL.'hr/reset'; ?>" >HR Reset</a></td></tr>
<tr><td><a href="<?php echo URL.'hr/test'; ?>" >HR Test</a></td></tr>
<tr><td><a href="<?php echo URL.'paygroups'; ?>" >Pay Groups</a></td></tr>
<tr><td><a href="<?php echo URL.'payperiods'; ?>" >Pay Periods</a></td></tr>
<tr><td><a href="<?php echo URL.'edtr'; ?>" >Employee DTR</a></td></tr>
<tr><td><a href="<?php echo URL.'hr/sessions'; ?>" >HR Sessions</a></td></tr>
<tr><td><a href="<?php echo URL.'payroll'; ?>" >Payroll</a></td></tr>
<tr><td><a href="<?php echo URL.'holidays'; ?>" >Holidays</a></td></tr>
<tr><td><a href="<?php echo URL.'restdays'; ?>" >Restdays</a></td></tr>
<tr><td><a href="<?php echo URL.'restdays/setter'; ?>" >Restdays Setter</a></td></tr>
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

