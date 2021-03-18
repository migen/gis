<div class="clear"></div>
<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Prid</th>
	<th>Supplier</th>
	<th>Barcode<br />(Sku)</th>
	<th>Product<br />(Desc)</th>
	<th>Beg<br />Qty</th>
	<th>T<?php echo $t; ?><br />Sold</th>
	<th>Final<br />T<?php echo $t; ?><br />Qty</th>
<?php if($editable): ?>	
	<th>Axn</th>
<?php endif; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['supplier']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><input class="vc50 " id="beg<?php echo $i; ?>" value="0" onchange="xgetTerminalQty(<?php echo $i; ?>);" /></td>	
	<td><?php echo $rows[$i]['sold']; ?>
		<input type="hidden" class="vc50 " id="sold<?php echo $i; ?>" value="<?php echo $rows[$i]['sold']; ?>" /></td>
	<td><input class="vc50 " id="qty<?php echo $i; ?>" value="<?php echo $rows[$i]['t'.$t]; ?>" /></td>
	<?php $prid=$rows[$i]['prid']; ?>
<?php if($editable): ?>	
	<td>
		  <a class="txt-blue u" id="btn<?php echo $i; ?>" onclick="xsaveTI(<?php echo $i.','.$prid; ?>);" >Save</a>
		| <a href="<?php echo URL.'products/view/'.$prid; ?>" >Edit</a>
	</td>
<?php endif; ?>
	
	
</tr>
<?php endfor; ?>
</table>




<script>
var gurl="http://<?php echo GURL; ?>";
var t="<?php echo $t; ?>";

$(function(){
	nextViaEnter();
})


function xsaveTI(i,prid){
	$('#btn'+i).hide();
	var qty = $('#qty'+i).val();	
	var vurl 	= gurl+'/ajax/xinventory.php';	
	var task	= "xsaveTI";
	var pdata = "task="+task+"&prid="+prid+"&qty="+qty+"&t="+t;
			
	$.ajax({
		type: 'POST',url: vurl,data: pdata,success:function(){} 
	});				
	
}	/* fxn */


function xgetTerminalQty(i){
	var a = $('#beg'+i).val();
	var b = $('#sold'+i).val();
	var c = parseInt(a)-parseInt(b);
	$('#qty'+i).val(c);
}	/* fxn */


</script>