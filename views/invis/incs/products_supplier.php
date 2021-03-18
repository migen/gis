<?php 
// echo "MIT supplier exit "; exit;
// pr($_SESSION['q']);

?>

<?php ?>
<div class="clear" ></div>
<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Prid</th>
	<th>Code</th>
	<th>Barcode<br />(Sku)</th>
	<th>Product<br />(Desc)</th>
	<th>Cost</th>
	<th>Price</th>	
	<th>Level</th>
	<th>T<?php echo $t; ?><br />Qty</th>
<?php if($editable): ?>	
	<th>Axn</th>
<?php endif; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><input class="vc50 " name="posts[<?php echo $i; ?>][cost]" id="cost<?php echo $i; ?>" 
		value="<?php echo $rows[$i]['cost']; ?>" tabindex="6"  /></td>	
	<td><input class="vc50 " name="posts[<?php echo $i; ?>][price]" id="price<?php echo $i; ?>" 
		value="<?php echo $rows[$i]['price']; ?>" tabindex="8" />
		<input type="hidden" name="posts[<?php echo $i; ?>][prid]"  
				value="<?php echo $rows[$i]['prid']; ?>" />		
	</td>		
	<td><input class="vc50 " id="level<?php echo $i; ?>" tabindex="16"
		value="<?php echo $rows[$i]['level']; ?>" readonly /></td>			
	<td><input class="vc50 " id="qty<?php echo $i; ?>" tabindex="12"
		value="<?php echo $rows[$i]['t'.$t]; ?>" /></td>
	<input type="hidden" id="qtyold<?php echo $i; ?>" value="<?php echo $rows[$i]['t'.$t]; ?>" />		
	<?php $prid=$rows[$i]['prid']; ?>
<?php if($editable): ?>	
	<td>
		  <a class="txt-blue u" id="btn<?php echo $i; ?>" onclick="xsaveTIP(<?php echo $i.','.$prid; ?>);" >Save</a>
		| <a href="<?php echo URL.'products/view/'.$prid; ?>" >Edit</a>
	</td>
<?php endif; ?>
	
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save All" onclick="return confirm('Sure?');" /></p>

</form>


<script>
var gurl="http://<?php echo GURL; ?>";
var t="<?php echo $t; ?>";

$(function(){
	nextViaEnter();
})


function xsaveTIP(i,prid){

	$('#btn'+i).hide();
	var cost = $('#cost'+i).val();	
	var price = $('#price'+i).val();	
	var qty = $('#qty'+i).val();	
	var qtyold = $('#qtyold'+i).val();	
	var vurl 	= gurl+'/ajax/xinventory.php';	
	var task	= "xsaveTIP";
	var pdata = "task="+task+"&prid="+prid+"&qty="+qty+"&t="+t+"&cost="+cost+"&price="+price+"&qtyold="+qtyold;
			
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