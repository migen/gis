<?php 
// pr($rows[0]);
// pr($_SESSION['q']);

?>



<div style="float:left;width:40%;"  >
<table class="gis-table-bordered" >
	<tr><th>Reference</th><td class="vc200" ><?php echo $row['reference']; ?></td></tr>
	<tr><th>Date</th><td><?php echo $row['date']; ?></td></tr>
	<tr><th>Customer</th><td><?php echo $_SESSION['settings']['school_name']; ?></td></tr>
	<tr><th>Contact Person</th><td><?php echo $row['employee']; ?></td></tr>
	<tr><th>Terminal</th><td><?php echo $row['terminal']; ?></td></tr>
	<tr><th>Invoice</th><td><?php echo $row['invoice']; ?></td></tr>
	<tr><th>Assessed</th><td class=" vc120" ><?php echo number_format($row['assessed'],2); ?></td></tr>
	<tr><th>Discount</th><td class="" ><?php echo number_format($row['discount'],2); ?></td></tr>
	<tr><th>PO Total</th><td class="" ><?php echo number_format($row['total'],2); ?></td></tr>
	<tr><th>Total Paid</th><td class="" ><?php echo number_format($row['paid'],2); ?></td></tr>
	<tr><th>Balance</th><td class="" ><?php echo number_format($row['balance'],2); ?></td></tr>
	
</table>

</div>


<div class="third"  >
<table class="gis-table-bordered" >
	<tr><th>Supplier</th><td><?php echo $supplier['fullname']; ?></td></tr>
	<tr><th>Contact Person</th><td><?php echo $supplier['contact_person']; ?></td></tr>
	<tr><th>Mobile</th><td><?php echo $supplier['mobile']; ?></td></tr>
	<tr><th>phone</th><td><?php echo $supplier['phone']; ?></td></tr>
	<tr><th>Email</th><td><?php echo $supplier['email']; ?></td></tr>
	<tr><th>Address</th><td><?php echo $supplier['address']; ?></td></tr>
	<tr><th>PO Remarks</th><td><?php echo $row['remarks']; ?></td></tr>
</table>

</div>

<div class="clear" >&nbsp;</div>


<p class="b brown" >*CSV (comma separated values) for Qty and Dest (Trml);i.e.<br />> Qty:20,30 and Dest: 3,5 <br />
> Meaning will move 20 units to Trml#3 and move 30 units to Trml#5 </p>

<table class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Prid</th>
	<th>Code</th>
	<th>Product</th>
	<th>Cost</th>
	<th>Order</th>
	<th>Dlvd</th>
	<th>T<?php echo $t; ?></th>
	<th>Mv-Qty<br />
		<input class="pdl05 vc50" type="" id="iqty" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('qty');" >						
	</th>
	<th>Mv-Dest<br />
		<input class="pdl05 vc50" type="" id="itrml" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('trml');" >						
	</th>
	<th>Action</th>	
</tr>

<?php 
	$sumqty=0;
	for($i=0;$i<$count;$i++): 
	$sumqty+=$rows[$i]['roqty'];
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['product_id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td id="<?php echo $rows[$i]['product_id']; ?>" ondblclick="alert(this.id);" class="u" >
		<?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['cost']; ?></td>
	<td><?php echo $rows[$i]['roqty']; ?></td>
	<td><?php echo $rows[$i]['rxqty']; ?></td>	
	<td><?php echo $rows[$i]['t'.$t]; ?></td>
	<input type="hidden" id="prid<?php echo $i; ?>" value="<?php echo $rows[$i]['product_id']; ?>" />
	<input type="hidden" id="cost<?php echo $i; ?>" value="<?php echo $rows[$i]['cost']; ?>" />
	<td><input class="vc50 qty" name="sd[<?php echo $i; ?>][qty]" value="0" /></td>
	<td><input class="vc50 trml" name="sd[<?php echo $i; ?>][terminal]" value="1"  /></td>
	<td><a class="u" id="btn<?php echo $i; ?>" onclick="movePO(<?php echo $i; ?>);" >Transfer</a></td>
</tr>
<?php endfor; ?>

<tr><th colspan="5" >Total</th>
<th><?php echo number_format($sumqty,2); ?></th>
<th colspan="5" ></th>
</tr>

</table>


<br />
<?php if($numpd>0): ?>
	<h4>Transfer</h4>
<table class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Product</th>
	<th>Cost</th>
	<th>To<br />Trml</th>
	<th>Mv<br />Qty</th>
	<th>Trml<br />Qty</th>
	<th>Action</th>
</tr>

<?php 
	$sumtq=0;
	$sumamt=0;
	for($i=0;$i<$numpd;$i++): 
	$pdt=$pd[$i]['terminal'];
	$sumtq+=$pd[$i]['mvqty'];
	$sumamt+=$pd[$i]['mvqty']*$pd[$i]['cost'];
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $pd[$i]['product']; ?></td>
	<td><?php echo $pd[$i]['cost']; ?></td>
	<td><?php echo $pd[$i]['terminal']; ?></td>
	<td><?php echo $pd[$i]['mvqty']; ?></td>	
	<td><?php echo $pd[$i]['t'.$pdt]; ?></td>	
	<td><a class="u" id="btnpmv<?php echo $i; ?>" onclick="xdelPmvdid(<?php echo $pd[$i]['pdid'].','.$i; ?>);" >Del</a></td>	
</tr>
<?php endfor; ?>
<tr><th colspan="4" >Total Quantity</th>
<th><?php echo number_format($sumtq,2); ?></th>
<th colspan="2" ></th>
</tr>
<tr><th colspan="4" >Total Amount</th>
<th><?php echo number_format($sumamt,2); ?></th>
<th colspan="2" ></th>
</tr>
</table>
<?php else: ?>	<!-- has payments -->
	<h4>No transfers yet.</h4>
<?php endif; ?>	<!-- has payments -->


<div class="ht100" ></div>

<script>
var gurl="http://<?php echo GURL; ?>";
var poid="<?php echo $poid; ?>";
var tfrom="<?php echo $t; ?>";

$(function(){
	nextViaEnter();
	selectFocused();
})

function movePO(i){
	$('#btn'+i).hide();	
	var cost = $('#cost'+i).val();
	var prid = $('#prid'+i).val();
	var vurl = gurl+'/ajax/xlogistics.php';		
	var task = "movePO";				
		
 	var a1 = $('input[name="sd['+i+'][qty]"]').val();
	var a=a1.split(",");	
	var b1 = $('input[name="sd['+i+'][terminal]"]').val();
	var b=b1.split(",");
	var c = a.length;
	
	
	for(var x=0;x<c;x++){
		qty=a[x];
		t=b[x];		
		var pdata = "task="+task+"&prid="+prid+"&qty="+qty+"&t="+t+"&poid="+poid+"&tfrom="+tfrom+"&cost="+cost;
		$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){}  });						
	}	
	
	
}	/* fxn */


function xdelPmvdid(pmvdid,i,tdest){
	$('#btnpmv'+i).hide();
	var vurl = gurl+'/ajax/xlogistics.php';		
	var task = "xdelPmvdid";			
	var pdata = "task="+task+"&pmvdid="+pmvdid+"&tfrom="+tfrom;
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){}  });				
	
}	/* fxn */

</script>