<?php

// pr($_SESSION['q']);

?>

<h5>
	View Shrinkage
	

</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Prid | Price | Cost</th><td>
	<input type="" name="post[prid]" value="<?php echo $row['prid']; ?>" id="prid" class="vc50" readonly />
	<input type="type" name="post[price]" id="price" value="<?php echo $row['price']; ?>" class="vc50" readonly />
	<input type="type" name="post[cost]" id="cost" value="<?php echo $row['cost']; ?>" class="vc50" readonly />
</td></tr>

<tr><th>SK Type</th><td>
<select name="post[sktype_id]" >
	<?php foreach($sktypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo ($sel['id']==$row['sktype_id'])? 'selected':NULL; ?>
		><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Date</th><td><input type="date" name="post[date]" value="<?php echo $row['date']; ?>" />
</td></tr>
<tr><th>Product</th><td>
	<input class="vc300 pdl05" id="part" autofocus value="<?php echo $row['product']; ?>" />
	<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />
</td></tr>

<tr><th>Qty</th><td><input type="type" name="post[qty]" value="<?php echo $row['qty']; ?>" /></td></tr>





</table>
</form>


<div id="names" ></div>


<script>

var gurl="http://<?php echo GURL; ?>";


$(function(){
	$('html').live('click',function(){ $('#names').hide(); });

})


function redirLookup(ucid){ 	
	var vurl = gurl+'/ajax/xshrinkages.php';		
	var task = "xgetProduct";		
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&prid='+ucid,						
		success: function(s) { 
			$('#prid').val(ucid);$('#part').val(s.name);
			$('#price').val(s.price);$('#cost').val(s.cost);	
		}		  
    });				


	
	
	
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

