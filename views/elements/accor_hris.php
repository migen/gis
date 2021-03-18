<?php 
	$user = $_SESSION['user'];
	// pr($user); 
?>

<table class="hris accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('hris');" >HRIS</th></tr>



<tr><th class="center" >Admin</th></tr>
<tr><td><a href="<?php echo URL.'payroll/employees?all'; ?>" >Employees</a></td></tr>

<tr><td>
	<a href="<?php echo URL.'edtr'; ?>" >EDTR</a>
	| <a href="<?php echo URL.'hr'; ?>" >HR</a>
</td></tr>
<tr><td>
	<a href="<?php echo URL.'payroll'; ?>" >Payroll</a>
	| <a href="<?php echo URL.'paymaster/all'; ?>" >Paymaster</a>
</td></tr>

<tr><td>
	<a href="<?php echo URL.'payperiods'; ?>" >Pay Periods</a>
	| <a href="<?php echo URL.'paygroups'; ?>" >Pay Groups</a>
</td></tr>


<tr><td>&nbsp;</td></tr>

</table>
