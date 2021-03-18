<h5>
	Add / Make Payment (Cashiering)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	<?php include_once(SITE.'views/invoices/incs/last_orno.php'); ?>
	

</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
<th>Ecid | Terminal</th>
<td>
	<input class="vc50 pdl05" name="pay[ecid]" value="<?php echo $_SESSION['ucid']; ?>" readonly />
	<input class="vc50 pdl05" name="pay[terminal]" value="<?php echo $t; ?>" />
</td>
</tr>

<tr>
<th>ID No.</th>
<td><input class="vc200 pdl05" id="code" />
<input type="submit" name="auto" value="Get" onclick="xgetContactByCode();return false;" />		
</td>
</tr>

<tr><th>Customer</th><td>
<input id="part" class="vc200 pdl05" />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
<input id="scid" value="0" name="pay[scid]" class="vc50 pdl05" />
</td></tr>

<tr><th>Fee</th><td>
<input id="feepart" class="vc200 pdl05" />
<input type="submit" name="auto" value="Filter" onclick="xgetFeesByPart(limits);return false;" />		
<input id="feeid" value="0" name="pay[feetype_id]" class="vc50 pdl05" />
</td></tr>
<tr><th>Pointer</th><td><input type="" class="vc200" name="pay[pointer]" value="1" ></td></tr>

<tr><th>Bank</th><td>
<input id="bankpart" class="vc200 pdl05" />
<input type="submit" name="auto" value="Filter" onclick="xgetBanksByPart(limits);return false;" />		
<input id="bankid" value="0" name="pay[bank_id]" class="vc50 pdl05" />
</td></tr>

<tr><th>OR No</th><td><input class="vc200 pdl05" name="pay[orno]" value="<?php echo ($last_orno+1); ?>" ></td></tr>

<tr><th>Date</th><td><input type="date" class="vc200 pdl05" name="pay[date]" value="<?php echo $_SESSION['today']; ?>" ></td></tr>
<tr><th>Amount</th><td><input class="vc200 pdl05" name="pay[amount]" value="0.00" ></td></tr>
<tr><th>Payortype</th><td>
<select name="pay[payortype_id]" class="vc200" >
<?php foreach($payortypes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>


</table>

<p>
	<input type="submit" name="submit" value="Pay" onclick="return confirm('Sure?');" />
</p>
</form>


<div id="names" >Names</div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var limits='20';

$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})





function redirContact(ucid){
	$('#scid').val(ucid);	
}	/* fxn */


function redirFee(id){
	$('#feeid').val(id);	
}	/* fxn */


function redirBank(id){
	$('#bankid').val(id);	
}	/* fxn */

function xgetContactByCode(){
	var code = $('#code').val();		
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";			
	$.ajax({
		url: vurl,dataType: "json",type:'POST',data:'task='+task+'&code='+code,async:true,
		success: function(s) { 	$('#scid').val(s.id); }		  
    });					
}	/* fxn */


function xgetFeesByPart(limits){
	var part = $('#feepart').val();	
	var vurl = gurl+'/ajax/xfees.php';	
	var task = "xgetFeesByPart";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) { 
			// console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirFee(this.id);return false;" >'+s[i].name+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
}	/* fxn */


function xgetBanksByPart(limits){
	var part = $('#bankpart').val();	
	var vurl = gurl+'/ajax/xfees.php';	
	var task = "xgetBanksByPart";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) { 
			// console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirBank(this.id);return false;" >'+s[i].name+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				



}	/* fxn */


</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
