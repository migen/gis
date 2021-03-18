<table class="gis-table-bordered table-fx" >
<tr>
<th>#</th>
<th>Date</th>
<th>Amount</th>
<th>Pay Type</th>
<th>Bank</th>
<th>Or No.</th>
<th>Action</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr id="trow<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $pays[$i]['date']; ?></td>
	<td><?php echo $pays[$i]['amount']; ?></td>
	<td><?php echo $pays[$i]['paytype']; ?></td>
	<td><?php echo $pays[$i]['bank']; ?></td>
	<td><?php echo $pays[$i]['orno']; ?></td>
	<?php $payid = $pays[$i]['payid']; ?>
	<td>
		<button><a href="<?php echo URL.'invoices/printorno/'.$pays[$i]['orno']; ?>" target="blank" >Print</a></button>	
		<a class="txt-blue u" onclick="xdeleteInvoicePayment(<?php echo $payid.','.$i; ?>);" >Delete</a>		
	</td>
</tr>
<?php endfor; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="vc100" id="date" value="<?php echo $_SESSION['today']; ?>"  /></td>
	<td><input class="vc80" id="amount" value="0"  /></td>
	<td>
		<select id="paytype_id" >
			<?php foreach($paytypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==1)? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>
	<td>
		<select id="bank_id" class="vc200" >
			<option value="0" >Choose</option>		
			<?php foreach($banks AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>
	<td><input class="vc80" id="orno" value="<?php echo $last_orno+1;?>"  /></td>
	<td><a class="txt-blue u" onclick="xaddInvoicePayment(<?php echo $i+1; ?>);return true;" >Pay</a></td>
	
	<input id="invid" value="<?php echo $invid; ?>" type="hidden" />
	<input id="scid" value="<?php echo $row['scid']; ?>" type="hidden" />
	<input id="feetype_id" value="<?php echo $row['feetype_id']; ?>" type="hidden" />
	<input id="ecid" value="<?php echo $_SESSION['user']['ucid']; ?>" type="hidden" />	
</tr>
</table>



<script>


function xdeleteInvoicePayment(payid,i){
	$('#trow'+i).remove();
	var vurl 	= gurl + '/ajax/xinvoices.php';	
	var task	= "xdeleteInvoicePayment";
		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&payid='+payid,						
		success: function() { }		  
	});				

	
}	/* fxn */


function xaddInvoicePayment(i){
	var date = $('#date').val();
	var invid = $('#invid').val();
	var amount = $('#amount').val();
	var feetype_id = $('#feetype_id').val();
	var paytype_id = $('#paytype_id').val();
	var bank_id = $('#bank_id').val();
	var orno = $('#orno').val();
	var scid = $('#scid').val();
	var ecid = $('#ecid').val();
	
	var vurl 	= gurl + '/ajax/xinvoices.php';	
	var task	= "xaddInvoicePayment";
	var pdata = 'task='+task+'&invoice_id='+invid+'&amount='+amount+'&paytype_id='+paytype_id+'&bank_id='+bank_id+'&orno='+orno;
		pdata+='&scid='+scid+'&ecid='+ecid+'&feetype_id='+feetype_id+'&date='+date;

$.ajax({
	url: vurl,dataType: "json",type: 'POST',async: true,
	data: pdata,success: function() { 	
		// $('#trow'+i).remove(); 
		location.reload();
	}		  
});				
	
}	/* fxn */




</script>
