<?php 

// pr($rows[0]);

// pr($data);

// pr($row);
// pr($_SESSION['q']);

$real_assessed=0;
foreach($rows AS $tmprow){ $real_assessed+=$tmprow['amount']; }

// pr($real_assessed);


$paid=0;
foreach($pays AS $pay){
	$paid+=$pay['amount'];
}



?>


<h5>
	Purchase Order
	| <span class="u" onclick="tracehd();" >PRID</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'purchases/viewPO/'.$poid; ?>" >Cancel</a>
	| <a href="<?php echo URL.'purchases/deletePO/'.$poid; ?>" onclick="return confirm('Sure?');" >Delete</a>	
	| <a href='<?php echo URL."delivery/view/$poid"; ?>' >Delivery</a>
	
</h5>


<form method="POST" >
<div style="float:left;width:42%;"  ><table class="gis-table-bordered" >

<tr><th>PO Reference</th><td>	
	<input class="pdl05 " name="po[reference]" 
		value="<?php echo (!empty($row['reference']))? $row['reference']:NULL; ?>" />
</td></tr>
<tr><th>Date</th><td>
	<input class="pdl05" type="date" name="po[date]" value="<?php echo isset($row['date'])? $row['date']:NULL; ?>" />
</td></tr>

<tr><th>Customer</th><td><?php echo $row['employee']; ?></td></tr>
<tr><th><a href="<?php echo URL.'purchases/editPOSupplier/'.$poid; ?>" >Supplier</a>
 #<?php echo $row['suppid']; ?></th><td><?php echo $row['supplier']; ?></td></tr>
<tr><th>Terminal</th><td>
	<select name="po[terminal]" >
		<?php foreach($terminals AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($row['terminal'])) && ($sel['id']==$row['terminal']))? 'selected':NULL; ?>  >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>	
</td></tr>

<tr><th>Invoice</th><td>
	<input class="pdl05" name="po[invoice]" value="<?php echo isset($row['invoice'])? $row['invoice']:NULL;  ?>" />
</td></tr>

<tr><th>Rcvd Date</th><td>
	<input class="pdl05" type="date" name="po[rxdate]" value="<?php echo $_SESSION['today'];  ?>" />
</td></tr>

</table></div>


<div class="third" ><table class="gis-table-bordered" >

<tr><th>Assessed</th><td>
	<input class="right pdr05" name="po[assessed]" 
		value="<?php $assessed = $real_assessed; echo number_format($assessed,2); ?>" />
</td></tr>

<tr><th>Discount</th><td>
	<input class="right pdr05" name="po[discount]" value="<?php echo isset($row['discount'])? $row['discount']:NULL; ?>" />
</td></tr>

<tr><th>Paid</th><td>
	<input class="right pdr05" name="po[paid]" value="<?php echo number_format($paid,2); ?>" />
</td></tr>


<tr><th>Total</th><td class="right pdr05" ><?php echo number_format($row['total'],2); ?></td></tr>
<tr><th>Balance</th><td class="right pdr05" ><?php echo number_format($row['balance'],2); ?></td></tr>
<tr><th>PO Remarks</th><td class="pdr05" >
<textarea name="po[remarks]" ><?php echo $row['remarks']; ?></textarea>
</td></tr>



<tr><td colspan="2" >&nbsp;</td></tr>

<tr><th>Payment</th>
<td class="right pdr05" >
<input class="right pdr05" name="payment[amount]" value="0" /></td></tr>

<tr><th>Payment Ref</th>
<td class="right pdr05" >
<input class="right pdr05" name="payment[reference]" /></td></tr>



</table></div>



<div class="clear" >&nbsp;</div>
<div class="fourth hd" id="names" >Names</div>
<div class="clear" >&nbsp;</div>



<table class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Product</th>
	<th>Order<br />Qty</th>
	<th class="right pdr05" >Cost</th>
	<th class="right pdr05" >Amount</th>
	<th>Total<br />Rcvd</th>
	<th>Axn</th>
	<th class="hd" ><span class="u" >Prid</span></th>
	<th class="right" >Rcvd</th>
</tr>

<?php 
	$total=0; 
	// pr($total);
?>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$pdid = $rows[$i]['pdid'];
	$total+=$rows[$i]['amount']; 
?>
<tr id="atr<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code'].' - '.$rows[$i]['product']; ?>
		<input type="hidden" name="pd[<?php echo $i; ?>][product_id]" value="<?php echo $rows[$i]['product_id']; ?>" />
	</td>
	<td>
		<input class="vc50 pdl05" name="pd[<?php echo $i; ?>][roqty]" id="roqty<?php echo $i; ?>" 
			tabindex="2" onchange="amountThis(<?php echo $i; ?>);"
			value="<?php echo (isset($rows[$i]['roqty']))? $rows[$i]['roqty']:0; ?>"  />
	</td>

	<input type="hidden" name="pd[<?php echo $i; ?>][origcost]" value="<?php echo $rows[$i]['cost']; ?>"  />	
	
	<td><input class="vc80 right pdr05" name="pd[<?php echo $i; ?>][cost]" tabindex="4" id="cost<?php echo $i; ?>"
		value="<?php echo (isset($rows[$i]['cost']))? $rows[$i]['cost']:0; ?>"  /></td>

	<td><input class="vc80 right pdr05" name="pd[<?php echo $i; ?>][amount]" tabindex="6" id="amount<?php echo $i; ?>"
		value="<?php echo (isset($rows[$i]['cost']))? $rows[$i]['amount']:0; ?>"  /></td>
		
	<td>
		<input type="hidden" class="vc50 pdl05" name="pd[<?php echo $i; ?>][oldrxqty]" 
			value="<?php echo (isset($rows[$i]['rxqty']))? $rows[$i]['rxqty']:0; ?>" readonly />	
		<?php echo $rows[$i]['rxqty']; ?>	
		<input type="hidden" class="vc50 pdl05" name="pd[<?php echo $i; ?>][rxqty]" id="rxqty<?php echo $i; ?>" tabindex="8"
			value="<?php echo (isset($rows[$i]['rxqty']))? $rows[$i]['rxqty']:0; ?>" readonly />
	</td>

	
	<td>
		<u onclick="xdeletePODetail(<?php echo $rows[$i]['pdid'].','.$i; ?>);" class='blue' >Delete</u>			
		| <a href="<?php echo URL.'products/view/'.$rows[$i]['product_id']; ?>" ><?php echo $rows[$i]['product_id']; ?></a>
	</td>
	<td class="hd" ><span><?= $rows[$i]['product_id']; ?></span></td>
	<td><input class="vc50 right pdr05" name="pd[<?php echo $i; ?>][pxqty]" tabindex="10" 
		value="0"  /></td>

		
<input type="hidden" name="pd[<?php echo $i; ?>][pdid]" 
	value="<?php echo (isset($rows[$i]['id']))? $rows[$i]['id']:0; ?>" />	
	
	
</tr>
<?php endfor; ?>

<?php 
	$numrows = isset($_POST['numrows'])? $_POST['numrows'] : 0; 
	$nr = $count+$numrows;
?>
<?php for($i=$count;$i<$nr;$i++): ?>
<tr id="trow<?php echo $i; ?>" >
	<td>#</td>
	<td>		
		<input class="vc200 pdl05" id="part<?php echo $i; ?>" value="" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetProductsByPartRow(<?php echo $i; ?>);return false;" />		
		<input class="vc50" name="pd[<?php echo $i; ?>][product_id]" 
			onchange="getSupplierProductByID(this.value,<?php echo $i; ?>)" />
	</td>
	<td>
		<input class="vc50 pdl05" name="pd[<?php echo $i; ?>][roqty]" id="roqty<?php echo $i; ?>" 
		 tabindex="2" value="0" onchange="amountThis(<?php echo $i; ?>);" />
		 
		<input type="hidden" name="pd[<?php echo $i; ?>][origcost]" id="origcost<?php echo $i; ?>"  />			 
	 </td>


		 
	<td><input id="cost<?php echo $i; ?>" class="vc80 right pdr05" name="pd[<?php echo $i; ?>][cost]" 
		value="0" tabindex="4"  /></td>
	<td><input class="vc80 right pdr05" name="pd[<?php echo $i; ?>][amount]" 
		id="amount<?php echo $i; ?>" value="0" tabindex="6"  /></td>
	<td><input class="vc50 pdl05" name="pd[<?php echo $i; ?>][rxqty]" id="rxqty<?php echo $i; ?>" 
		tabindex="8" value="0"  /></td>
	<td></td>
	<td class="hd" ></td>
	<td></td>

	
</tr>
<?php endfor; ?>


</table>


<h4>Assessed: P<?php echo number_format($total,2); ?></h4>



<p>
	<input type="submit" name="submit" value="Update" onclick="return confirm('Cannot Undo! Sure?');" />
	<button><a class="txt-black" href="<?php echo URL.'products/viewPO/'.$poid; ?>" >Cancel</a></button>
</p>



<!---------------------------------------------------------------------------------------------------->

<?php $count = count($pays); ?>
<?php if($count>0): ?>
	<h4>Payments</h4>
<table class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Date</th>
	<th class="right" >Amount</th>
	<th>Reference</th>
	<th>Axn</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$ppid = $pays[$i]['ppid'];
?>
<tr id="btr<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><input class="pdl05" type="date" name="pays[<?php echo $i; ?>][date]" 
		value="<?php echo $pays[$i]['date']; ?>" ></td>
	<td><input id="amt-<?php echo $i; ?>" class="right pdr05 vc120" name="pays[<?php echo $i; ?>][amount]" 
		value="<?php echo $pays[$i]['amount']; ?>" ></td>
	<td><input id="ref-<?php echo $i; ?>" class="left pdl05 vc120" name="pays[<?php echo $i; ?>][reference]" 
		value="<?php echo $pays[$i]['reference']; ?>" ></td>		
	<input type="hidden" name="pays[<?php echo $i; ?>][ppid]" value="<?php echo $pays[$i]['ppid']; ?>" >		
	<td>
		<input id="bts-<?php echo $i; ?>" type="submit" 
			value="Save" onclick="xsavePOPayment(<?php echo $ppid.','.$i; ?>);return false;"  />		
		<input id="btr-<?php echo $i; ?>" type="submit" 
			value="Del" onclick="xdeletePOPayment(<?php echo $ppid.','.$i; ?>);return false;"  />		
	</td>

</tr>
<?php endfor; ?>
</table>
<?php else: ?>	<!-- has payments -->
	<h4>No payments made yet.</h4>
<?php endif; ?>	<!-- has payments -->

</form>


<h4> Add products to purchase:
<?php $this->shovel('numrows'); ?>
</h4>

<div class="ht100" ></div>


<!---------------------------------------------------------------------------------------------------->


<script>
var gurl = "http://<?php echo GURL; ?>";


$(function(){
	hd();
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

})


function xcopyPrid(prid,i){
	getSupplierProductByID(prid,i);
}

function getSupplierProductByID(prid,i){
	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "getSupplierProductByID";		
	$.post(vurl,{task:task,prodid:prid},function(s){
		// console.log(s);
		var amount = parseFloat(s.roqty)*parseFloat(s.cost);
		$('#part'+i).val(s.name);
		$('input[name="pd['+i+'][product_id]"]').val(s.id);		
		$('input[name="pd['+i+'][roqty]"]').val(s.roqty);		
		$('input[name="pd['+i+'][cost]"]').val(s.cost);		
		$('input[name="pd['+i+'][amount]"]').val(amount);		
		$('input[name="pd['+i+'][origcost]"]').val(s.cost);		
	},'json');
}	/* fxn */




function xdeletePOPayment(ppid,i){
	if (confirm('Sure?')){
		$('#btr-'+i).remove();
		var vurl = gurl+'/ajax/xinventory.php';		
		var task = "xdeletePOPayment";			
		// alert(vurl+' - '+task+' - '+ppid);
		$.post(vurl,{task:task,ppid:ppid},function(){});		
	}
	return false;

}	/* fxn */

function xsavePOPayment(ppid,i){
	$('#bts-'+i).remove();
	var amount = $("#amt-"+i).val();
	var reference = $("#ref-"+i).val();	
	var vurl = gurl+'/ajax/xinventory.php';		
	var task = "xsavePOPayment";			
	$.post(vurl,{task:task,ppid:ppid,amount:amount,reference:reference},function(){});		
	return false;

}	/* fxn */



function xdeletePODetail(pdid,i){

	if (confirm('Sure?')){
		$('#atr'+i).remove();
		var vurl = gurl+'/ajax/xinventory.php';		
		var task = "xdeletePODetail";			
		$.post(vurl,{task:task,pdid:pdid},function(){});		
	}
	return false;


}	/* fxn */


function redirLookup(vid,rid){	
	$('input[name="pd['+rid+'][product_id]"]').val(vid);
	getSupplierProductByID(vid,rid)
}	/* fxn */


function rcvd(i){
	var roqty=$('#roqty'+i).val();
	$('#rxqty'+i).val(roqty);		
}	/* fxn */


function amountThis(i){
	var a=$('#roqty'+i).val();
	var b=$('#cost'+i).val();
	var c= parseFloat(a)*parseFloat(b);
	$("#amount"+i).val(c.toFixed(2));

}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups_products.js"; ?>' ></script>
