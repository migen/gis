<?php 
extract($row);
$dbtable=PDBO.".30_payments";
// pr($row);

// $_SESSION['q']='';
// $_SESSION['q1']='';

 // pr($_SESSION['q']);
 // pr($_SESSION['q1']);

?>


<h3>
	Edit Payment | <?php $this->shovel('homelinks');  ?>
 	| <a href='<?php echo URL."students/bills/$scid/$sy"; ?>' >Bills</a>
 	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>
 	| <a href='<?php echo URL."ornos/view/$orno"; ?>' >O R </a>
<?php if($row['amount']>0): ?>
	| <span onclick="cancelOrno();" >Cancel OR</span>
<?php endif; ?>

</h3>



<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>ID No.</th>
	<td><?php echo $studcode; ?></td>
</tr>
<tr>
	<th>Student</th>
	<td><?php echo $studname; ?></td>
</tr>
<tr>
	<th>Cashier</th>
	<td><?php echo $emplname; ?></td>
</tr>

<tr>
	<th>SY</th>
	<td><input type="number" name="post[sy]" value="<?php echo $sy; ?>" ></td>
</tr>

<tr>
	<th>Payer</th>
	<td><input name="post[payer]" value="<?php echo $payer; ?>" ></td>
</tr>

<tr>
	<th>Fee</th>
	<td>
		<select name="post[feetype_id]" >
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$feetype_id)? 'selected':null; ?> >
					<?php echo $sel['name']; ?></option>		
			<?php endforeach; ?>
		</select>	
	</td>
</tr>

<tr>
	<th>Paytype</th>
	<td>
		<select name="post[paytype_id]" >
			<?php foreach($paytypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$paytype_id)? 'selected':null; ?> >
					<?php echo $sel['name']; ?></option>		
			<?php endforeach; ?>
		</select>	
	</td>
</tr>

<tr>
	<th>Ptr (Pointer) </th>
	<td><input name="post[ptr]" value="<?php echo $ptr; ?>" ></td>
</tr>
<tr>
	<th>In Tuition</th>
	<td>
		<input type="radio" name="post[in_tuition]" <?php echo ($in_tuition==1) ?  "checked" : "" ;  ?> value="1">
		<label for="yes">Yes</label>
		<input type="radio" name="post[in_tuition]" <?php echo ($in_tuition==0) ?  "checked" : "" ;  ?> value="0">
		<label for="no">No</label>
	</td>
</tr>
<tr>
	<th>Date</th>
	<td><input type="date" id="date" name="post[date]" value="<?php echo $date; ?>" ></td>
</tr>

<tr>
	<th>Amount</th>
	<td><input id="amount" name="post[amount]" value="<?php echo $amount; ?>" 
		onchange="getChange();return false;" ></td>
</tr>

<tr>
	<th>Received</th>
	<td><input id="received" name="post[received]" value="<?php echo $received; ?>" 
		onchange="getChange();return false;" ></td>
</tr>

<tr>
	<th>Change</th>
	<td><input id="change" name="post[change]" value="<?php echo $change; ?>" ></td>
</tr>


<tr>
	<th>Reference</th>
	<td><input name="post[reference]" value="<?php echo $reference; ?>" ></td>
</tr>
<tr class="<?php echo ($amount>0)? null:'bg-red'; ?>" >
	<th>OR No.</th>
	<td><input name="post[orno]" value="<?php echo $orno; ?>" ></td>
</tr>
<tr>
	<th>Notes</th>
	<td><textarea cols=50 rows=3 name="post[notes]"  ><?php echo $notes; ?></textarea></td>
</tr>

<tr><td colspan=2 ><input type="submit" name="submit" value="Save" ></td></tr>


</table>


	<input type="hidden" name="feetype" value="<?php echo $row['feetype']; ?>" >
</form>

<div class="ht50" ></div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy	 = "<?php echo $sy; ?>";
var dbtable	 = "<?php echo $dbtable; ?>";
var pkid	 = "<?php echo $pkid; ?>";


$(function(){
	// alert('on load');
	// alert(`${gurl} - ${sy}`);
	selectFocused();
	nextViaEnter();
	
})


function getChange(){
	var received=$('#received').val();
	var amount=$('#amount').val();
	received=received.replace(",", "");		
	amount=amount.replace(",", "");			
	received=parseFloat(received).toFixed(2);
	amount=parseFloat(amount).toFixed(2);
	var change = received - amount;
	$('#change').val(change.toFixed(2));
}	/* fxn */


function cancelOrno(){
	const r = confirm('Are u sure?');
	if(r){
		var vurl 	= gurl + '/ajax/xorno.php';	
		var task	= "cancelOrno";		
		var pdata	= "task="+task+"&dbtable="+dbtable+"&pkid="+pkid;		
		$.ajax({
			url: vurl,dataType: "json",type: 'POST',async: true,
			data: pdata,				
			success: function() { 			
				alert(`Cancelled OR`);
				location.reload();
			}		  
		});				

	} else {
		alert('Abort cancel OR');
	}


}



</script>
