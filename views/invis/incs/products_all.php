<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Prid</th>
	<th>Barcode<br />(Sku)</th>
	<th>Product<br />(Desc)</th>
	<th>T<?php echo $t; ?><br />Qty</th>
	<th>Axn</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><input class="vc50 " id="qty<?php echo $i; ?>" value="<?php echo $rows[$i]['t'.$t]; ?>" /></td>
	<?php $prid=$rows[$i]['prid']; ?>
	<td><a class="txt-blue u" id="btn<?php echo $i; ?>" onclick="xsaveTI(<?php echo $i.','.$prid; ?>);" >Save</a></td>
	
</tr>
<?php endfor; ?>
</table>



<script>
var gurl="http://<?php echo GURL; ?>";
var t="<?php echo $t; ?>";



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


</script>