<?php 
	// $user = $_SESSION['user'];
// pr($data);

$srid=$_SESSION['srid'];
$ucid=($srid==RSTUD)? $data['ucid']:false;

$sy=DBYR;	
$prevsy=(DBYR-1);	

$is_dual=$_SESSION['settings']['is_dual'];
$sy_enrollment=$_SESSION['settings']['sy_enrollment'];
$sy_grading=$_SESSION['settings']['sy_grading'];
	
?>



<table class="finance accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('finance');" >Finance</th></tr>

	<tr><td class="vc250" >
		<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
		<?php if($srid!=RSTUD): ?>
		
		<?php endif; ?>
	</th></tr>
	<tr><td>		
		<a href='<?php echo URL."students/balances"; ?>' >Balance</a>
		| <a href='<?php echo URL."finance/rar/$sy_enrollment"; ?>' >Report</a>
		<?php if($is_dual): ?>
			| <a href='<?php echo URL."finance/rar/$prevsy"; ?>' ><?php echo $prevsy; ?></a>		
		<?php endif; ?>
	</td></tr>	
	<tr><td>
		<a href='<?php echo URL."students"; ?>' >*Student</a>
		| <a href='<?php echo URL."enrollment/ledger"; ?>' >*Ledger</a>	
	</td></tr>
	<tr><td>
		<a href='<?php echo URL."students/bills"; ?>' >Bills / Other Services</a>
	</td></tr>
	
	<tr><td>
		<a href='<?php echo URL."tuitions/table"; ?>' >Tuitions</a>
		| <a href='<?php echo URL."feetypes/table"; ?>' >Fees</a>	
	</td></tr>
	<tr><td>
		Enrollment - <a href='<?php echo URL."enrollment/report"; ?>' >Payments</a>
		| <a href='<?php echo URL."enrollment/level"; ?>' >Level</a>
	</td></tr>
	<tr><td>
		<a href='<?php echo URL."booklists/table"; ?>' >Booklists</a>
	</td></tr>


	<tr><td>
		<a href='<?php echo URL."students/payments"; ?>' >View OR</a>
	</td></tr>


	<tr><td>
		<a href='<?php echo URL."families"; ?>' >Families</a>
		| <a href='<?php echo URL."families/table"; ?>' >All</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."enrollees/official"; ?>' >Enrollees</a>
	</td></tr>

	<tr><td><a href="<?php echo URL.'employeeChild/status'; ?>" >Employee Child Status</a></td></tr>

	<tr><td>
		Reports - <a href='<?php echo URL."payments/report"; ?>' >Payments</a>	
		| <a href='<?php echo URL."payables/report"; ?>' >Payables</a>	
	</td></tr>
		
	<tr><td>
		<a href='<?php echo URL."students/leveler"; ?>' >Leveler</a>	
		| <a href='<?php echo URL."students/register"; ?>' >Register Student</a>
	</td></tr>
	<tr><td>
		Password <a href='<?php echo URL."portals/pass"; ?>' >Change </a>
		| <a href='<?php echo URL."portals/pass"; ?>' >Reset</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."audit/trails"; ?>' >Audit Trails</a>
	</td></tr>



	<tr><td>&nbsp;</td></tr>
	
</table>
<br />
<?php if($srid==RMIS): ?>
<table class="misfinance accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('misfinance');" >MIS Finance</th></tr>

	<tr><td class="vc250" ><a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a></th></tr>
	<tr><td>
		<a href="<?php echo URL.'tuitions/table'; ?>" >Tuitions</a>
		| <a href="<?php echo URL.'tuitions/level/4?num=1'; ?>" >Level</a>
		| <a href="<?php echo URL.'feetypes/table'; ?>" >FeeTypes</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'paymodes/table'; ?>" >Paymodes</a>
	</td></tr>
	
	<tr><td>&nbsp;</td></tr>
	
</table>




<?php endif; ?>	<!-- mis -->