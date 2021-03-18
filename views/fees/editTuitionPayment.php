<?php 


// pr($tpay);

?>

<script>

$(function(){

})


function refresh(){
	var oldamt 	  = parseFloat($('#oldamt').val());
	var amount 	  = parseFloat($('#amount').val().replace(',',''));
	var assessed  = parseFloat($('#assessed').val().replace(',',''));
	var paid  	  = parseFloat($('#paid').val().replace(',',''));
	var outstanding	  = parseFloat($('#outstanding').val().replace(',',''));
	
	paid 		= paid - oldamt + amount;
	outstanding = assessed - paid;

	$('#paid').val(paid);
	$('#outstanding').val(outstanding);
	
	// alert(amount);
	// alert(outstanding);
		
	
}

function submitForm(){
	refresh();
	return confirm('Are you sure?');

}

</script>



<!---------------------------------------------------------------------->

<h5> Edit Student Tuition Payment </h5>

<div >
<form method="POST" >

<table class="gis-table-bordered table-fx"  >
<tr><th class="bg-gray3" colspan="2" >Summary</th></tr>
<tr><th class="vc150" >ID Number</th><td class="vc300"  ><?php echo $summary['code']; ?></td></tr>
<tr><th >Student</th><td><?php echo $summary['student']; ?></td></tr>
<tr><th>Tuition</th><td class="" ><?php echo $summary['total']; ?></td></tr>
<tr><th>Assessed</th><td><input id="assessed" class="full pdl05" name="assessed" value="<?php echo number_format($summary['assessed'],2); ?>"  /></td></tr>
<tr><th>Paid</th><td><input id="paid" class="full pdl05" name="paid" value="<?php echo number_format($summary['paid'],2); ?>"  /></td></tr>
<tr><th>Outstanding</th><td><input id="outstanding" class="full pdl05" name="outstanding" value="<?php echo number_format($summary['outstanding'],2); ?>"  /></td></tr>

<tr><th>Status</th><td>
<select class="full" id="is_fullypaid" name="is_fullypaid" >
	<option value="1" <?php echo ($summary['is_fullypaid']=='1')? 'selected':NULL; ?> >Fully Paid</option>
	<option value="0" <?php echo ($summary['is_fullypaid']!='1')? 'selected':NULL; ?> >NOT Fully Paid</option>
</select>
</td></tr>

<tr><th>Employee</th><td>
<select class="full" id="ecid" name="ecid" >	
	<option value="0" >Choose One</option>
	<?php foreach($employees AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($tpay['ecid']==$sel['id'])? 'selected':NULL; ?> ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>


</table>


<div class="clear" > &nbsp; </div>

<table class="gis-table-bordered table-fx"  >
<tr><th class="bg-gray3" colspan="2" >Payment</th></tr>
<tr><th class="vc150" >Date</th><td class="vc300"  ><input type="date" class="full pdl05" name="date" value="<?php echo $tpay['date']; ?>" ></td></tr>
<tr><th>Amount</th><td><input id="amount" class="full pdl05" name="amount" value="<?php echo number_format($tpay['amount'],2); ?>"  /></td></tr>
<tr><th>Reference</th><td><input class="full pdl05" name="reference" value="<?php echo $tpay['reference']; ?>"  /></td></tr>

<input type="hidden" id="oldamt" value="<?php echo $tpay['amount']; ?>"  />


</table>


<p><input type="submit" name="submit" onclick="return submitForm();" value="Save"   />
<input type="submit" name="cancel" value="Cancel" >
</p>

</div>

<!---------------------------------------------------------------------->


