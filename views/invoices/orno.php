<?php 

// pr($data);

?>


<h5>
	OR No.
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."tfees/details/4"; ?>' ><?php echo "Tuition"; ?></a>
	| <a href='<?php echo URL."ledgers/filter"; ?>' ><?php echo "Report"; ?></a>
	| <a href='<?php echo URL."ledgers/student"; ?>' ><?php echo "Ledger"; ?></a>
	<?php spacer('3'); ?><input class="pdl05" id="orno" placeholder="OR No."  />
	<span class="u" onclick="jsredirect('invoices/printorno/'+$('#orno').val());" >Go</span>
	| <span class="u" onclick="ilabas('max');" >Max</span>
	| <a href="<?php echo URL.'invoices/orbooklets'; ?>">OR Booklets</a> 
</h5>


<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ECID</th><td><input class="pdl05" readonly value="<?php echo $ecid; ?>" /></td></tr>
<tr><th>Employee</th><td><input class="pdl05" readonly value="<?php echo $fullname; ?>" /></td></tr>
<tr><th>Last OR No.</th><td><input class="pdl05" name="orno" value="<?php echo $orno; ?>" /></td></tr>

<tr class="max" ><th>Last OR No.(Payments)</th><td><input class="pdl05" value="<?php echo $last_orno_payments; ?>" /></td></tr>

</table>

<p>
	<input type="submit" name="submit" value="Update"  />
	<button><a href='<?php echo URL.$_SESSION['home']; ?>' >Cancel</a></button>
</p>

</form>






<script>
	var gurl = "http://<?php echo GURL; ?>";
	
	$(function(){
		itago('max');
	})


</script>

