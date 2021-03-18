<h5>
	Refund Ledgers
	| <?php $this->shovel('homelinks'); ?>

</h5>

<h4 class="brown" >*Refund amount (No negative sign)</h4>

<form method="POST" >

<?php 
	$today=$_SESSION['today']; 
	$ecid=$_SESSION['ucid']; 
	$tfeeid=$_SESSION['tfeeid']; 
?>
<input type="hidden" name="ecid" value="<?php echo $ecid; ?>" />
<input type="hidden" name="feetype_id" value="<?php echo $tfeeid; ?>" />
<input type="hidden" name="pointer" value="1" />


<table class="gis-table-bordered table-altrow" >
<tr><th>Scid</th><td><?php echo $row['scid']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['student']; ?></td></tr>
<tr><th>Date</th><td><input type="date" name="date" value="<?php echo $today; ?>" ></td></tr>
<tr><th>OR No</th><td><input name="orno" value="" ></td></tr>
<tr><th>Amount</th><td><input name="amount" value="" ></td></tr>
<tr><th>Reference</th><td><input name="reference" value="" ></td></tr>
</table>

<p><input type="submit" name="submit" value="Submit" /></p>


</form>