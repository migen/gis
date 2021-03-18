<h5>
	New Invoice <span class="hd" >HD</span>
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."invoices"; ?>' >Filter</a>

	<?php include_once('incs/last_orno.php'); ?>
	
</h5>


<?php 


// pr($_SESSION['q']);
// pr($contacts);

// $d['contacts'] = $contacts;
// $d['new_customer'] = true;
// $this->shovel('filter_contacts',$d);

?>

<?php include(SITE.'views/filters/contacts.php');  ?>
<br />


<form method="POST" >

<table class="gis-table-bordered" >
<tr><th>Date</th><td><input class="pdl05 full" type="date" name="inv[date]" value="<?php echo $_SESSION['today']; ?>"  /></td></tr>
<tr><th>E|C</th><td>
	<input class="vc50 pdl05" type="text" name="inv[ecid]" value="<?php echo $_SESSION['pcid']; ?>" readonly />
	<input class="vc50 pdl05" type="text" name="inv[scid]" value="0" id="scid0" readonly />
</td></tr>
<tr><th>Guest</th><td><input id="guest" name="inv[guest]" class="pdl05 full" value=""  /></td></tr>
<tr><th>Payor Type</th><td>
	<select id="payortype" name="inv[payortype_id]" class="full" onchange="xpayorType(this.value,'0');return false;" >
		<option value="0" >Choose</option>
		<?php foreach($payortypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>
<tr><th>Fee</th><td>
	<select name="inv[feetype_id]" class="full" onchange="xgetFee(this.value,'0');return false;" >
		<option value="0" >Choose</option>
		<?php foreach($feetypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr><th>Amount</th><td><input class="pdl05 full" name="inv[amount]" id="amount0"  /></td></tr>
<tr><th>Details</th><td><input class="pdl05 full" name="inv[details]"  /></td></tr>




</table>

<p>
	<input type="submit" name="submit" value="Add" onclick="return confirm('Sure?');" />
	<button><a href='<?php echo URL."invoices"; ?>' >Cancel</a></button>
</p>




<div class="hd" id="names" > </div>



<script>

var gurl = 'http://<?php echo GURL; ?>';
var limits='20';
var page='invoices/add';


$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){ $('#names').hide(); });
	
})


function gotoPage(){
	var code = $('#code').val();		
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";			
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: 'task='+task+'&code='+code,				
		async: true,
		success: function(s) { 	
			if(s){			
				$('#scid0').val(s.id);
				if(s.role_id>1){
					$('#payortype').val(2);
				} else if(s.role=1){
					$('#payortype').val(1);				
				} else {
					$('#payortype').val(3);								
					$('#guest').focus();				
				}
			} else {
				alert('No record found.');
				$('#payortype').val(3);								
				$('#guest').focus();								
			}			
		}		  
    });				
	
}	/* fxn */


function redirContact(ucid){
	$('#scid0').val(ucid);

	var code = $('#code').val();		
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByID";			
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: 'task='+task+'&pcid='+ucid,				
		async: true,
		success: function(s) { 	
			$('#scid0').val(s.id);
			if(s.role_id>1){
				$('#payortype').val(2);
			} else {
				$('#payortype').val(1);
			}
		}		  
    });				
		
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


function xpayorType(){
	var payortype = $('#payortype').val();
	if(payortype==3){ $('#guest').focus(); }
}	/* fxn */


</script>