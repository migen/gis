<h5>
	New Invoice <span class="hd" >HD</span>
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."invoices"; ?>' >Invoices</a>
	| <a href='<?php echo URL."invoices/delete/$invid"; ?>' onclick="return confirm('Cannot Undo! Sure?');" >Delete</a>
	| <a href='<?php echo URL."invoices/add"; ?>' >Add</a>
	<?php include_once('incs/last_orno.php'); ?>
	
	
</h5>




<?php if($row): ?>
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Date</th><td><input class="pdl05" type="date" name="date" value="<?php echo $row['date']; ?>"  /></td></tr>
<tr><th>E|C</th><td>
	<input class="vc50 pdl05" type="text" name="ecid" value="<?php echo $row['ecid']; ?>" readonly />
	<input class="vc50 pdl05" type="text" value="<?php echo $row['scid']; ?>" readonly />
</td></tr>
<tr><th>Customer</th><td><?php echo $row['customer']; ?></td></tr>
<tr><th>Fee</th><td>
	<select name="feetype_id" class="full" onchange="xgetFee(this.value,'0');return false;" >
		<option value="0" >Select</option>
		<?php foreach($feetypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['feetype_id'])? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr><th>Amount</th><td>
	<input class="pdl05" name="amount" id="amount0" value="<?php echo $row['amount']; ?>" /></td></tr>
<tr><th>Paid</th><td>
	<input class="pdl05" value="<?php echo $row['paid']; ?>" name="paid" id="paid0" readonly /></td></tr>
<tr><th>Balance</th><td>
	<input class="pdl05" value="<?php echo $row['balance']; ?>" id="balance0" name="balance" readonly /></td></tr>
<tr><th>Details</th><td><input class="pdl05" value="<?php echo $row['details']; ?>" name="details"  /></td></tr>
	
<tr><td colspan="2" ><input type="submit" name="update" value="Update" onclick="return confirm('Sure?');" /></td></tr>	
</table>

<h5>Payments</h5>

<?php 
if(empty($pays)){
	echo "<h4 class='brown' >No payments made.</h4>";
}

include_once('incs/invoice_payments.php');

?>


<?php endif; ?>	<!-- if row -->



<div class="hd" id="names" > </div>



<script>

var gurl="http://<?php echo GURL; ?>";

$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	
})


function redirContact(ucid){
	var url = gurl+'/invoices/add/'+ucid;	
	window.location = url;		
}

function xgetBalance(i){
	var amount = $('#amount'+i).val();
	var paid = $('#paid'+i).val();

	var balance = parseFloat(amount) - parseFloat(paid);
	$('#balance'+i).val(balance);	
}


function xgetFee(ftid,i){	
	var vurl 	= gurl+'/ajax/xinvoices.php';	
	var task	= "xgetFee";	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&ftid='+ftid,				
		async: true,
		success: function(s) { 		
			$('#amount'+i).val(s.amount);
		}		  
    });				
	
}	/* fxn */



</script>