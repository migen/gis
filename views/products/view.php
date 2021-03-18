<?php 
	// pr($count);
	// pr($rows[0]);
	// pr($row);
	// $_SESSION['q1']="";
	
?>



<h5>
	Product Details
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a onclick="return confirm('Dangerous! Sure?');" href="<?php echo URL.'products/purge/'.$prid; ?>" >Destroy</a>
	<?php endif; ?>		
		
</h5>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>Find</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="Product" />
		<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />		
	</td></tr>
	
</table></p>

<div class="hd" id="names" >names</div>


<?php 
$numterminals = $_SESSION['settings']['numterminals'];

?>

<div style="float:left;width:30%;" >
<table class="gis-table-bordered table-fx table-altrow" >

<tr><th>Prod#</th><td><?php echo $row['prid']; ?></td></tr>
<tr><th>Barcode</th><td><input id="barcode" value="<?php echo $row['barcode']; ?>" ></td></tr>
<tr><th>Comm</th><td><input id="comm" value="<?php echo $row['comm']; ?>" ></td></tr>
<tr><th>Code</th><td><input id="code" value="<?php echo $row['code']; ?>" ></td></tr>
<tr><th>Product</th><td><input id="name" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><th>Price</th><td><input id="price" value="<?php echo $row['price']; ?>" ></td></tr>


<tr><th>Supplier</th><td>
<select id="psuppid" class="vc200" >
	<option value="0" >Choose</option>
	<?php foreach($suppliers AS $sel): ?>
		<option  value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['suppid'])? 'selected':NULL; ?> 
			><?php echo $sel['name']; ?></option>		
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Cost</th><td><input id="pcost" value="<?php echo $row['cost']; ?>" ></td></tr>
<tr><th>PO Cost</th><td><input id="pocost" value="<?php echo $row['pocost']; ?>" ></td></tr>
<tr><th>Level Current Cost</th><td><input id="level_currcost" value="<?php echo $row['level_currcost']; ?>" ></td></tr>
<tr><th>RO Level</th><td><input id="rolevel" value="<?php echo $row['rolevel']; ?>" ></td></tr>
<tr><th>RO Qty</th><td><input id="roqty" value="<?php echo $row['roqty']; ?>" ></td></tr>
<tr><th>Combo</th><td><input id="combo" value="<?php echo $row['combo']; ?>" ></td></tr>
<tr><th>Is Decimal</th><td><input id="is_decimal" type="number" min=0 max=1
	value="<?php echo $row['is_decimal']; ?>" ></td></tr>


</table>

</div>


<div style="float:left;width:30%;" >
<table class="gis-table-bordered table-fx table-altrow" >
<?php for($i=1;$i<=$numterminals;$i++): ?>
	<tr>
		<th><?php echo "T$i";?></th>
		<td><input id="t<?php echo $i; ?>" value="<?php echo $row['t'.$i];?>" class="vc60" /></td>	
	</tr>
<?php endfor; ?>
<tr><th>Level (Total)</th><td><?php echo $row['level']; ?></td></tr>

</table>

</div>
<div class="clear" >&nbsp;</div>
<p><input id="btn" type="submit" name="submit" value="Update" onclick="xeditProduct();return false;" ></p>

<!------------------------------------------------------------------------------------>

<form id="form" >
<h4>Suppliers</h4>
<table id="table" class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>Suppid</th>
	<th>Supplier</th>
	<th class="right" >Cost</th>
	<th></th>
</tr>

<tr>
	<td><input readonly id="suppid" class="pdl05 vc60" value="0" /></td>
	<td class="" >
		<input class="pdl05 pdl05 vc100" id="part" autofocus />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />				
	</td>
	<td><input id="cost" value="<?php echo $row['cost']; ?>" class="vc80 right" ></td>
	<td><input id="btn" type="submit" value="Add" onclick="xaddSupplier();return false;"  /></td>
</tr>


<?php for($i=0;$i<$count;$i++): ?>
	<tr id="tr<?php echo $i; ?>" >
		<?php $psid = $rows[$i]['psid']; ?>
		<?php $suppid = $rows[$i]['suppid']; ?>
		<td><?php echo $rows[$i]['pcid']; ?></td>
		<td><?php echo $rows[$i]['supplier']; ?></td>
		<td class="right" ><?php echo $rows[$i]['cost']; ?></td>
		<td>
			<input type="submit" value="Del" onclick="xdeleteSupplier(<?php echo $psid.','.$i; ?>);return false;"  />
		</td>
	</tr>
<?php endfor; ?>

</table>
</form>

<div id="names" >names</div>


<?php 

$incs = SITE."views/notes/products.php";
include_once($incs);

?>



<div class="ht100" ></div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo HDPASS; ?>";
var prid = "<?php echo $prid; ?>";
			
			
$(function(){
	$('#names').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});


})	/* fxn */


function xdeleteSupplier(psid,i){

	// if (confirm('Sure?')){
	$('#tr'+i).remove();
	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "xdeleteSupplier";			
	$.post(vurl,{task:task,psid:psid},function(){});		
	// }
	return false;
	

}	/* fxn */




function redirContact(ucid){
	$('#suppid').val(ucid);	
	var vurl = gurl+'/ajax/xgetContacts.php';		
	var task = "xgetContactByUcid";	
		
	$.post(vurl,{task:task,ucid:ucid},function(s){		
		$('#part').val(s.name);		
	},'json');	

		
}	/* fxn */



function xaddSupplier(){
	var suppid = $('#suppid').val();
	var supp = $('#part').val();
	var cost = $('#cost').val();	

	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "xaddSupplier";			
	var pdata  = "task="+task+"&suppid="+suppid+"&cost="+cost+"&prid="+prid;

	if (suppid>0){		
		$.ajax({
		  type: 'POST',
		  url: vurl,
		  data: pdata,
		  success:function(){
			$("#form")[0].reset();		
			$('#table').append('<tr><td>'+suppid+'</td><td>'+supp+'</td><td class="right">'+cost+'</td><td></td></tr>');
			$('#part').focus();	  
		  } 
		});				
	}	

}	/* fxn */



function xeditProduct(){
	$('#btn').hide();
	/* m for main */
	var suppid = $('#psuppid').val();
	var cost = $('#pcost').val();
	var pocost = $('#pocost').val();
	var level_currcost = $('#level_currcost').val();
	var combo = $('#combo').val();
	var barcode = $('#barcode').val();
	var comm = $('#comm').val();
	var code = $('#code').val();
	var name = $('#name').val();
	var price = $('#price').val();
	var rolevel = $('#rolevel').val();
	var roqty = $('#roqty').val();
	var is_decimal = $('#is_decimal').val();
	var t1 = $('#t1').val();
	var t2 = $('#t2').val();
	var t3 = $('#t3').val();
	var t4 = $('#t4').val();
	var t5 = $('#t5').val();
	var t6 = $('#t6').val();
	var level = parseInt(t1)+parseInt(t2)+parseInt(t3)+parseInt(t4)+parseInt(t5)+parseInt(t6);
	
	
	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "xeditProduct";			
	var pdata  = "task="+task+"&suppid="+suppid+"&cost="+cost+"&rolevel="+rolevel+"&roqty="+roqty+"&id="+prid;
	pdata  += "&barcode="+barcode+"&comm="+comm+"&code="+code+"&name="+name+"&price="+price+"&pocost="+pocost;
	pdata  += "&t1="+t1+"&t2="+t2+"&t3="+t3+"&t4="+t4+"&t5="+t5+"&t6="+t6+"&level="+level+"&combo="+combo;
	pdata += "&is_decimal="+is_decimal+"&level_currcost="+level_currcost;
	// alert(pdata);
	
	$.ajax({
		type: 'POST',url: vurl,data: pdata,success:function(){} 
	});				
	
	


}	/* fxn */



function redirLookup(ucid){
	var url = gurl + '/products/view/' + ucid;		
	window.location = url;			
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
