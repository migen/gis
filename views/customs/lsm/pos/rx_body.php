<?php // pr($itemwidth); 


// pr($positems[0]);
// pr($data);

// pr($prxdetails);
$count=count($positems);
// pr($count);


// echo ($pos['rxid']>0)? "<h5 class='brown'>Has returned POS #".$pos['rxid']."</h5>":NULL;


?>


<h5>
	<a href="<?php echo URL.'npos/view/'.$pos['id']; ?>" >Orig POS #<?php echo $pos['id']; ?></a>
	| <a href="<?php echo URL.'npos/view/'.$pos['rxid']; ?>" >RX POS #<?php echo $pos['rxid']; ?></a>
</h5>




<form method="POST" >

<div style="float:left;width:30%;" >
<table class="gis-table-bordered table-fx <?php echo $tfsize; ?>" >
	<tr>
		<td>POS: <?php echo $pos['id']; ?></td>
		<td>Terminal: <?php echo $pos['terminal']; ?></td></tr>

	<tr><td>Time</td><td><?php echo $pos['datetime']; ?></td></tr>
	<tr><td>ID Number</td><td><?php echo $pos['customer_code']; ?></td></tr>
	<tr><td>Customer
		<br /><input type="hidden" class="vc50" id="ccid" name="pos[ccid]" value="<?php echo $pos['ccid']; ?>" />
	</td><td>	
		<input class="pdl05" id="part" value="<?php echo $pos['customer']; ?>"  />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />			
	</td></tr>
	<tr><td>Cashier</td><td><?php echo $pos['employee']; ?></td></tr>	
	<tr><th>Total</th><td><?php echo $pos['total']; ?></td></tr>	

</table></div>

<div class="third " >
<table class="gis-table-bordered" >

<input id="cbi" class="vc50 hd" />


<tr><td>Trml <input id="terminal" name="pos[terminal]" value="<?php echo $_SESSION['terminal']; ?>" class="vc30" />
</td><td>Ecid <input class="vc50" name="pos[ecid]" value="<?php echo ($_SESSION['ucid']); ?>" readonly />
IsRX<input name="pos[is_return]" value="1" class="vc50" />
</td></tr>
<tr><td>ORNO</td><td><input id="orno" name="pos[orno]" value="<?php echo ($orno); ?>" /></td></tr>

<tr><td>Datetime</td><td><input id="datetime" name="pos[datetime]" 
	value="<?php echo date('Y-m-d H:i:s'); ?>" readonly /></td></tr>
<tr><th>Total</th><td><input id="total" name="pos[total]" value='0' readonly /></td></tr>

</table>
</div>


<div class="more" style="width:32%;float:left" >
<p><table class="gis-table-bordered table-fx" >

	<tr><th>Payment</th><td>
	<select class="vc150" id="paytype" name="pos[paytype_id]" >
		
		<?php foreach($paytypes AS $sel): ?>
			<?php if($sel['id']<3): ?>
			<option value="<?php echo $sel['id']?>" <?php echo ($sel['id']==1)? 'selected':NULL; ?> >
				<?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>
	</td></tr>
	<tr class="" ><th>Bank</th><td>
	<select id="bank" onchange="changePaytype(2);return false;" class="vc150" name="pos[bank_id]" >
		<option value="0" >Choose</option>
		<?php foreach($banks AS $sel): ?>
			<option value="<?php echo $sel['id']?>"  ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
	</td></tr>	
	
	<tr>
		<th class="u" onclick="getTenderetc();" >Tender Bank</th>
		<td><input id="tenderetc" onchange="lessTendercs();" class="pdl05" name="pos[tenderetc]" value="0" /></td>
	</tr>	
	<tr>
		<th>Reference No.</th>
		<td><input class="pdl05" name="pos[etcno]" value="" /></td>
	</tr>		
</table>
</p>

</div>
<br />

<div class="third unbordered" id="names" ></div>

<div class="clear" >&nbsp;</div>

<div style="float:left;width:660px;border:1px solid white;" >	<!-- receipt paper width rpw -->

<table class="gis-table-bordered table-fx <?php echo $tfsize; ?>" >
<tr><th colspan=7 style="color:brown;" >*Return Qty should be Negative (-)</th></tr>
<tr>
<th>RX Qty</th>
<th>PRID</th>
<th>Qty</th>
<th class="vc200" >Item</th>
<th class="" >Cost</th>
<th class="" >Price</th>
<th class="vc60" >Subtotal</th>
</tr>
<?php $numitems=0; ?>
<?php $is_rx=false; ?>
<?php $i=0; ?>
<?php foreach($positems AS $row): ?>
<?php $numitems+=$row['qty']; ?>
<?php if($row['qty']<0){ $is_rx=true; } ?>
<tr>	
	<?php 
		$returnable = ($row['qty']>0)? ($row['qty']-$row['rxqty']):0; 
	?>	

	<td class="" ><input name="pds[<?php echo $i; ?>][qty]" class="vc50" id="rx-<?php echo $i; ?>" type="number" 
		value="<?php echo 0; ?>" onchange="amtpds(<?php echo $i; ?>);return false;" min="<?php echo ($returnable*-1); ?>" />
		
	</td>
		
	<td><?php echo $row['prid']; ?></td>
	<td><?php echo $row['qty']; ?></td>
	<td style="width:<?php echo $itemwidth; ?>;" ><?php echo $row['pdid'].' - '.$row['code'].' - '.$row['product']; ?></td>

	<td class="right" ><?php echo number_format($row['cost'],2); ?></td>
	<td class="right" ><?php echo number_format($row['price'],2); ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?>
		<input type="" class="subtotal vc70" value="0" name="pds[<?php echo $i; ?>][amount]" />	
	</td>
		
	<input type="hidden" id="origqty-<?php echo $i; ?>" value="<?php echo $row['qty']; ?>" />	
	<input type="hidden" name="pds[<?php echo $i; ?>][product_id]" value="<?php echo $row['product_id']; ?>" />
	<input type="hidden" name="pds[<?php echo $i; ?>][cost]" value="<?php echo $row['cost']; ?>" />
	<input type="hidden" name="pds[<?php echo $i; ?>][price]" value="<?php echo $row['price']; ?>" />
	<input type="hidden" name="pds[<?php echo $i; ?>][amount]" value="<?php echo $row['amount']; ?>" />
	<input type="hidden" name="pds[<?php echo $i; ?>][pdid]" value="<?php echo $row['pdid']; ?>" />
</tr>

<?php $i++; ?>
<?php endforeach; ?>

<tr><th colspan="7" >Exchange 
| <span class="u" onclick="newrow();" >+Row</span> 
| <span class="u" onclick="refresh();" >Refresh</span> 
</th></tr>

<tr><td></td>
<td>Prid</td><td>Qty</td><td>Code</td><td class="vc50" >Cost</td><td class="vc50" >Price</td>
<td class="vc50" >Subtotal</td></tr>

<?php foreach($prxdetails AS $row): ?>
<tr>
	<td></td>
	<td><?php echo $row['prid']; ?></td>
	<td><?php echo $row['qty']; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['cost']; ?></td>
	<td><?php echo $row['price']; ?></td>
	<td><?php ; ?></td>
	<td><?php echo number_format(($row['qty']*$row['price']),2); ?></td>
</tr>
<?php endforeach; ?>

<tbody class="children" >
<?php $numrows=$count+1; ?>
<?php for($i=$count;$i<$numrows;$i++): ?>
<tr>
<td><?php echo $count; ?></td>
<td><input class="vc50" type="" name="prx[<?php echo $i; ?>][product_id]" value="0"  /></td>
<td><input class="vc50" type="number" name="prx[<?php echo $i; ?>][qty]" value="0" onchange="amt(<?php echo $i; ?>);" /></td>
<td><input type="text" class="vc120" id="code<?php echo $i; ?>" onchange="xgetProductsByCode(<?php echo $i; ?>);" />
	<span class="u" onclick="xgetProductsByCode(<?php echo $i; ?>);" >Go</span>
	</td>
<td><input type="" class="full" name="prx[<?php echo $i; ?>][cost]"  /></td>
<td><input type="" class="full" name="prx[<?php echo $i; ?>][price]"  /></td>
<td><input type="" class="full subtotal vc70" name="prx[<?php echo $i; ?>][amount]" value=0 /></td>

</tr>

<?php endfor; ?>





</tbody>
</table>



<br />
<p><input type="submit" name="submit" value="Submit"  /></p>

<div clas="ht50" >&nbsp;</div>



</div>	<!-- receipt paper width rpw -->


</form>




<script>

var limits=<?php echo $_SESSION['settings']['limits']; ?>;
var pdcount="<?php echo $count; ?>";

$(function(){
	// nextViaEnter();
	chkAllvar('a');	
	$('html').live('click',function(){ $('#names').hide(); });

	
})

function redirContact(ucid){
	$('#ccid').val(ucid);
	// window.location = url;		
}

function xgetProductsByCode(rid){
	var part = $('#code'+rid).val();		
	var vurl = gurl+'/ajax/xpos.php';	
	var task = "xgetProductsByPart";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&part='+part+'&limits='+limits,			
		success: function(s) { 
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
  content+='<p><span class="txt-blue b u" onclick="redirProduct('+s[i].id+','+rid+');return false;" >'+s[i].code+'-'+s[i].name+'-'+s[i].barcode+'</span>-'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}

function redirProduct(prid,rid){
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByID";		
	
	$.post(vurl,{task:task,prodid:prid},function(s){		
		$('#code'+rid).val(s.code);
		$('input[name="prx['+rid+'][product_id]"]').val(s.id);		
		$('input[name="prx['+rid+'][cost]"]').val(s.cost);		
		$('input[name="prx['+rid+'][price]"]').val(s.price);		
		$('input[name="prx['+rid+'][amount]"]').val(s.price);		
		$('input[name="prx['+rid+'][qty]"]').val(1);		
		billTotal(rid);				
	},'json');		
	newrow();		
	
}





function minZero(i){
	var rxqty = $('input[name="pds['+i+'][qty]"]').val();	
	if(rxqty<0){ alert('Cannot be negative.');$('input[name="pds['+i+'][qty]"]').val(0); } 
}

function billTotal(i){		/* bill total */
	var ip = $('input[name="prx['+i+'][price]"]').val();
	var iq = $('input[name="prx['+i+'][qty]"]').val();	
	if(iq>999){ alert('Qty too big!'); }
		
	if(iq !== ''){
		var x = ip * iq;
		$('input[name="prx['+i+'][amount]"]').val(x.toFixed(2));		
	} 
	
	var total = 0;	
	$.each($('.subtotal'),function(){
		total += parseFloat($(this).val());
	});

	var cbi = $('input.subtotal').size();
	$('#cbi').val(cbi);
	$('#total').val(total.toFixed(2));	
	$('#tender').val(total.toFixed(2));	
	
}


function newrow(){
var x = $('tbody.children>tr').size();	
var nr = x+parseInt(pdcount);
$('tbody.children').append('<tr id="trow'+nr+'" ><td>'+nr+'</td><td class="vc50"><input class="vc50" name="prx['+nr+'][product_id]" /></td><td class="vc50"><input type="number" class="full pdr05" name="prx['+nr+'][qty]" value="0" onchange="amt('+nr+');return false;"></td><td class="" ><input class="vc120" id="code'+nr+'" onchange="xgetProductsByCode('+nr+')" />&nbsp;<span class="u" onclick="xgetProductsByCode('+nr+')" >Go</span></td><td class=""><input class="full pdr05" name="prx['+nr+'][cost]" readonly /></td><td class=""><input class="full pdr05" name="prx['+nr+'][price]" readonly /></td><td class=""><input class="full  pdr05 subtotal" name="prx['+nr+'][amount]" value="0" readonly /></td></tr>');					

$('#code'+nr).focus();
numrows = nr+1;

};

function amt(i){	/* amount or item subtotal */
	billTotal(i);
}


function amtpds(i){	/* amount or item subtotal */
	billTotalpds(i);
}


function billTotalpds(i){		/* bill total */
	var ip = $('input[name="pds['+i+'][price]"]').val();
	var iq = $('input[name="pds['+i+'][qty]"]').val();	
	if(iq>999){ alert('Qty too big!'); }
		
	if(iq !== ''){
		var x = ip * iq;
		$('input[name="pds['+i+'][amount]"]').val(x.toFixed(2));		
	} 
	
	var total = 0;	
	$.each($('.subtotal'),function(){
		total += parseFloat($(this).val());
	});

	var cbi = $('input.subtotal').size();
	$('#cbi').val(cbi);
	$('#total').val(total.toFixed(2));	
	$('#tender').val(total.toFixed(2));	
	
}

function refresh(){		/* bill total */
	var total = 0.00;	
	$.each($('.subtotal'),function(){
		total += parseFloat($(this).val());
	});
	var cbi = $('input.subtotal').size();
	$('#total').val(total.toFixed(2));	
	$('#tender').val(total.toFixed(2));	
	// alert('cbi: '+cbi+', total: '+total);
	
}


function getorigqty(i){
	var qty=$('#origqty-'+i).val()*-1;
	$('#rx-'+i).val(qty);
}

function returnAll(){
	for (var i = 0; i < pdcount; i++) { getorigqty(i); amtpds(i); }

}

</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/lookups.js"></script>
