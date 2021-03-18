<h5>
	Pay Bill
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."bills/add"; ?>'>Cashier</a>			
	<?php include_once(SITE.'views/invoices/incs/last_orno.php'); ?>
	
</h5>


<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Customer</th><td><?php echo $name; ?></td></tr>
<tr><th>Feetype</th><td>
<select name="post[feetype_id]" class="vc200" onchange="xgetAmount(this.value);" >
	<option value="0" >Choose A Fee</option>
	<?php foreach($feetypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Pay type</th><td>
<select name="post[paytype_id]" class="vc200" >
	<?php foreach($paytypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Bank</th><td>
<select name="post[bank_id]" class="vc200" >
	<option value="0" >Choose</option>
	<?php foreach($banks AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Reference</th><td><input name="post[reference]" /></td></tr>
<tr><th>Date</th><td><input type="date" name="post[date]" value="<?php echo $_SESSION['today']; ?>" /></td></tr>
<tr><th>OR No</th><td><input name="post[orno]" value="<?php echo ($orno+1); ?>" /></td></tr>
<tr><th>Amount</th><td><input id="amount" name="post[amount]" value="0" /></td></tr>


<tr><th colspan="2" >
<input style="font-size:2em;" type="submit" name="submit" value="PRINT" onclick="return checkPayBill();"  /></th></tr>

</table>

</form>


<script>

var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $_SESSION['sy']; ?>";

$(function(){

})

function xgetAmount(fid){
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "auxThis";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,data:'task='+task+'&id='+fid+'&sy='+sy,		
		success: function(s) { 		
			$('#amount').val(parseFloat(s.amount).toFixed(2));			
		}		  
	});					
	

}	/* fxn */


function checkPayBill(){
	var amt = $('#amount').val();
	if(amt>0){
		if(confirm('Sure?')){ return true; } 				
	} else {
		alert('Amount cannot be empty.');
	}
	return false;

}	/* fxn */


</script>
