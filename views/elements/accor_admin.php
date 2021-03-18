<style>

.accordion thead tr th { font-size:1.4em;height:46px;vertical-align:middle; } 

</style>

<?php 

?>

<table class="accordion grading gis-table-bordered table-altrow" >
<thead>
	<tr><th class="btn-accordion vc250 headrow center" onclick="accordionTable('grading');" >Grading</th></tr>
</thead><tbody>	
	<tr><td class="vc250" ><a class="b" href="<?php echo URL.'cir/index'; ?>" >*CLASS INDEX REPORTS (CIR)</a></td></tr>
	<tr><td class="vc250" ><a class="b" href="<?php echo URL.'students/links'; ?>" >Find Student</a></td></tr>
</tbody></table><br />


<?php if($_SESSION['settings']['has_pos']): ?>
<table class="accordion invis gis-table-bordered table-altrow" >
<thead>
	<tr><th class="btn-accordion vc250 headrow center" onclick="accordionTable('invis');" >Sales & Inventory</th></tr>
</thead><tbody>	
	<tr><td class="vc250" > 
		Report - <a href="<?php echo URL.'pos/sales'; ?>" >Sales</a>
		| <a href="<?php echo URL.'pos/items'; ?>" >Inventory</a>	  
	</td></tr>
	<tr><td>
		<a href="<?php echo URL.'pos/dcr'; ?>" >Daily Collection Report (DCR)</a>
	</td></tr>
	<tr><th class="center" >-Products Setup-</th></tr>
	<tr><td class="vc250" > 
		<a href="<?php echo URL.'products'; ?>" >Products</a>
	</td></tr>
</tbody></table><br />
<?php endif; ?>

<?php if($_SESSION['settings']['has_axis']): ?>
<table class="accordion enrollment gis-table-bordered table-altrow" >
<thead>
	<tr><th class="btn-accordion vc250 headrow center" onclick="accordionTable('enrollment');" >Enrollment</th></tr>
</thead><tbody>	
	<tr><td class="vc250" > 
		  <a href="<?php echo URL.'auxes/ad'; ?>" >Addons</a>
		| <a href="<?php echo URL.'collections/payments'; ?>" >Payments</a>
		| <a href="<?php echo URL.'balances/level'; ?>" >Balances</a>
	</td></tr>
</tbody></table><br />
<?php endif; ?>

<?php if($_SESSION['settings']['has_hris']): ?>
<table class="accordion hris gis-table-bordered table-altrow" >
<thead>
	<tr><th class="btn-accordion vc250 headrow center" onclick="accordionTable('hris');" >HRIS</th></tr>
</thead><tbody>	
	<tr><td class="vc250" > 
		  <a href="<?php echo URL.'employees'; ?>" >Employees</a>
		| <a href="<?php echo URL.'payroll'; ?>" >Payroll</a>
	</td></tr>
	<tr><td><a href="<?php echo URL.'payperiods'; ?>" >Pay Period</a></td></tr>	
</tbody></table><br />
<?php endif; ?>