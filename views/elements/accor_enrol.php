<?php 
	$user = $_SESSION['user'];

	
?>

<table class="enroll accordion gis-table-bordered table-altrow" >
	<tr><th style="widtd:250px;" class="accorHeadrow" onclick="accordionTable('enroll');" >Setup Enroll Accounts</th></tr>

<tr><td>
	  <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	| <a href="<?php echo URL.'id/tracer'; ?>" >ID Tracer</a></td></tr>
<tr><td><a href="<?php echo URL.'setaxis/paymodes'; ?>" >Paymodes</a></td></tr>
<tr><td><a href="<?php echo URL.'setaxis/auxes'; ?>" >Auxes</a></td></tr>
<tr><td><a href="<?php echo URL.'setaxis/payments'; ?>" >Payments</a></td></tr>
<tr><td>&nbsp;</td></tr>

</table>
