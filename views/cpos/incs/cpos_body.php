<?php 
$url=SITE.'views/customs/'.VCFOLDER.'/customs.php';
include_once($url);
$preapp=($pos_order=='append')? 1:0;



	
?>
<script type='text/javascript' src="<?php echo URL; ?>views/js/pos.js"></script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>



<div class="clear" >&nbsp;</div>


<div style="width:52%;float:left" >	<!-- items -->
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Product</th><th>Cost</th><th>Price</th><th>Qty</th><th>Amount</th><th>Date</th><th></th></tr>
<tbody id="posrows" >
<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<tr id="tr-<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['cost']; ?></td>
	<td><?php echo $rows[$i]['price']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo $rows[$i]['datecr']; ?></td>
	<td><span class="drow" ><a id="btn-<?php echo $i; ?>" class="u" onclick="xdelcpos(<?php echo $i.','.$rows[$i]['cposid']; ?>);" >Del</a></span></td>
</tr>
<?php $total+=$rows[$i]['amount']; ?>
<?php endfor; ?>

<tr>
	<th colspan="5" >Total</th>
	<th class="right" ><span id="total" ><?php echo number_format($total,2); ?></span></th>
	<th colspan="2" ></th>
</tr>

</tbody>
</table>

<div class="clear"><br />
	<input type="submit" name="submit" value="Update"  />
	<span id="chkoutbtn" ><input type="submit" name="checkout" value="Checkout"  /></span>
	
</div>

</div>	<!-- items -->






<script>

function addThis(){
	var prow = "<tr><td></td><td>Prodname</td><td>320</td><td>2</td><td>640</td></tr>";	
	$('#posrows').prepend(prow);	
	
	
}	/* fxn */


function addProduct(prid){
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByID";
	var qty=1;	
	
	$.post(vurl,{task:task,prodid:prid},function(s){	
		prid=s.id;cost=s.cost;price=s.price;amount=qty*price;product=s.name;
		combo=s.combo;level=s.level;pocost=s.pocost;
		prow='<tr id="trow-'+nr+'"><td><input class="vc50" readonly name="positems['+nr+'][product_id]" value="'+prid+'"  /></td><td><input class="vc200" readonly value="'+product+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][cost]" value="'+cost+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][price]" value="'+price+'"  /></td><td><input class="vc50" id="'+nr+'" onchange="amt(this.id);return false;" name="positems['+nr+'][qty]" value="'+qty+'" type="number"  /></td><td><input class="vc50 subtotal" readonly name="positems['+nr+'][amount]" value="'+amount+'"  /></td><td><input name="positems['+nr+'][datecr]" value="'+today+'"  /></td><td onclick="deltrow('+nr+');"  class="u" >Del</td><input type="hidden" name="positems['+nr+'][pocost]" value="'+pocost+'"  /><input type="hidden" name="positems['+nr+'][level]" value="'+level+'"  /></tr>';

		
		
		$('#posrows').prepend(prow); 
		
		nr++;			
		refresh();		
	},'json');	
	$('#posbarcode').val('');
	$('#pospart').val('');
	$('#posbarcode').focus();
	// refresh();
	
	
}	/* fxn */


function addPosItem(){
	var barcode = $('#posbarcode').val();			
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByBarcode";
	var qty=1;
	
	$.post(vurl,{task:task,barcode:barcode},function(s){		
		prid=s.id;cost=s.cost;price=s.price;amount=qty*price;product=s.name;
		combo=s.combo;level=s.level;pocost=s.pocost;
prow='<tr id="trow-'+nr+'"><td><input class="vc50" readonly name="positems['+nr+'][product_id]" value="'+prid+'"  /></td><td><input class="vc200" readonly value="'+product+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][cost]" value="'+cost+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][price]" value="'+price+'"  /></td><td><input id="'+nr+'" class="vc50" onchange="amt(this.id);return false;" name="positems['+nr+'][qty]" value="'+qty+'" type="number" /></td><td><input class="vc50 subtotal" readonly name="positems['+nr+'][amount]" value="'+amount+'"  /></td><td><input name="positems['+nr+'][datecr]" value="'+today+'"  /></td><td onclick="deltrow('+nr+');"  class="u" >Del</td><input type="hidden" name="positems['+nr+'][pocost]" value="'+pocost+'"  /><input type="hidden" name="positems['+nr+'][level]" value="'+level+'"  /><input type="hidden" name="positems['+nr+'][combo]" value="'+combo+'"  /></tr>';
		$('#posrows').prepend(prow);			
		nr++;			
		refresh();		
	},'json');	
	$('#posbarcode').val('');
	$('#posbarcode').focus();
	
}	/* fxn */


function xfindProductsByPart(){
	var part = $('#pospart').val();		
	var limits = 20;		
	var vurl = gurl+'/ajax/xpos.php';	
	var task = "xgetProductsByPart";
	var pdata='task='+task+'&part='+part+'&limits='+limits;
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&part='+part+'&limits='+limits,			
		success: function(s) { 
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			// console.log(s);
for (var i = 0; i < cs; i++) {			
  content+='<p><span class="txt-blue b u" onclick="addProduct('+s[i].id+');return false;" >'+s[i].code+'-'+s[i].name+'-'+s[i].barcode+'</span>-'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}



function deltrow(i){	// new row
	$('#trow-'+i).remove();
	refresh();
	
}

function xdelcpos(i,cposid){	// old row
	if (confirm('Sure?')){
		$('#tr-'+i).remove();
		$('#btn-'+i).hide();			
		var vurl = gurl+'/ajax/xcpos.php';		
		var task = "xdelCpos";				
		$.post(vurl,{task:task,cposid:cposid},function(s){},'json');		
	
	}
}




</script>
