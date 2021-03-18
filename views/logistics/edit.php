<?php

$time = date('His');
$date=preg_replace("([^0-9/])", "", $smv['date']);
$stdref=$date.$time.'-T'.$smv['src'].'-T'.$smv['dest'];


?>

<h5>
	Edit Stocks Movement
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href="<?php echo URL.'logistics/view/'.$smvid; ?>">View</a>	
	| <a href="<?php echo URL.'logistics/summary'; ?>">Summary</a>	
	| <a href="<?php echo URL.'logistics/move'; ?>">Move</a>	

<?php if($_SESSION['user']['privilege_id']==0): ?>
	| <a href="<?php echo URL.'logistics/deleteSmv/'.$smvid; ?>" 
		onclick="return confirm('Inventory Count will not be adjusted. Sure?');" >Delete</a>	
<?php endif; ?>	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Src - Dest</th><td class="vc150" ><?php echo "T".$smv['src'].' - T'.$smv['dest']; ?></td>
<th>Date</th><td><?php echo $smv['date']; ?></td></tr>
<tr><th>Status</th><td><?php echo $delivery_status; ?> Delivery</td>
<th>Reference</th><td><input class="vc200" name="smv[reference]" 
	value="<?php echo (!empty($smv['reference']))? $smv['reference']:$stdref; ?>" /></td></tr>
<tr><th>Comments</th><td colspan="3" >
<textarea cols="50" rows="2" name="smv[comments]" ><?php echo $smv['comments']; ?></textarea>
</td></tr>

</table>

<p class="clear" ></p>

<div id="names" >Names</div>

<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Code</th>
	<th>Product</th>
	<th>Order<br />Qty</th>
	<th>Rcvd<br />Qty</th>
	<th>Action</th>
</tr>
<tbody class='children'> <!-- needed for addRow -->
<?php 
	$total=0; 
?>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$sdid = $rows[$i]['sdid'];
?>
<tr id="atr<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>	
	<td><?php echo $rows[$i]['code']; ?>
	<td><?php echo $rows[$i]['product']; ?>
		<input type="hidden" name="sd[<?php echo $i; ?>][prid]" value="<?php echo $rows[$i]['prid']; ?>" />
	</td>
	<td>
		<input class="vc50 pdl05" name="sd[<?php echo $i; ?>][roqty]" id="roqty<?php echo $i; ?>" tabindex="6" 
			value="<?php echo (isset($rows[$i]['roqty']))? $rows[$i]['roqty']:0; ?>"  />
	</td>
		
	<td>
		<input type="hidden" class="vc50 pdl05" name="sd[<?php echo $i; ?>][oldrxqty]"
			value="<?php echo (isset($rows[$i]['rxqty']))? $rows[$i]['rxqty']:0; ?>" readonly />	
		<input class="vc50 pdl05" name="sd[<?php echo $i; ?>][rxqty]" id="rxqty<?php echo $i; ?>" tabindex="8"
			value="<?php echo (isset($rows[$i]['rxqty']))? $rows[$i]['rxqty']:0; ?>"  />
	</td>
	
	<td><u onclick="rcvd(<?php echo $i; ?>);" class='blue' >Rcvd</u></td>

	
	
<input type="hidden" name="sd[<?php echo $i; ?>][sdid]" 
	value="<?php echo (isset($rows[$i]['sdid']))? $rows[$i]['sdid']:0; ?>" />	
	
	
</tr>
<?php endfor; ?>

<?php 
	$numrows = isset($_POST['numrows'])? $_POST['numrows'] : 0; 
	$nr = $count+$numrows;
?>
<?php for($i=$count;$i<$nr;$i++): ?>
<tr id="trow<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><input class="vc50" name="sd[<?php echo $i; ?>][prid]" tabindex="2" /></td>	
	<td>		
		<input class="vc200 pdl05" id="part<?php echo $i; ?>" value="" tabindex="4" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetProductsByPartRow(<?php echo $i; ?>);return false;" />		
	</td>
	<td><input class="vc50 pdl05" name="sd[<?php echo $i; ?>][roqty]" id="roqty<?php echo $i; ?>" 
		tabindex="6" value="0" /></td>
	<td><input class="vc50 pdl05" name="sd[<?php echo $i; ?>][rxqty]" id="rxqty<?php echo $i; ?>" 
		tabindex="8" value="0"  /></td>
	<td>
		<u onclick="rcvd(<?php echo $i; ?>);" class='blue' >Rcvd</u>		
		<u onclick="deltrow(<?php echo $i; ?>);" class='blue' >Del</u>	
	</td>

	
</tr>
<?php endfor; ?>

</tbody>
</table>




<p>
	<input type="submit" name="submit" value="Update" onclick="return confirm('Cannot Undo! Sure?');" />
	<button><a href="<?php echo URL.'logistics/view/'.$smvid; ?>" >Cancel</a></button>
	<a id="addrow" class="u txt-blue" onclick="newrowMove();return false;" >Add Row</a>

</p>


<h4> Add products to request:
<?php $this->shovel('numrows'); ?>
</h4>

<div class="ht100" ></div>


<!---------------------------------------------------------------------------------------------------->


<script>
var gurl = "http://<?php echo GURL; ?>";


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

})


function xcopyPrid(prid,i){
	getSupplierProductByID(prid,i);
}





function xdeleteSmvDetail(sdid,i){

	if (confirm('Sure?')){
		$('#atr'+i).remove();
		var vurl = gurl+'/ajax/xlogistics.php';		
		var task = "xdeleteSmvDetail";			
		$.post(vurl,{task:task,pdid:pdid},function(){});		
	}
	return false;


}	/* fxn */


function redirLookup(prid,i){
	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "getSupplierProductByID";		
	$.post(vurl,{task:task,prodid:prid},function(s){
		var amount = parseFloat(s.roqty)*parseFloat(s.cost);
		$('#code'+i).val(s.code);
		$('#part'+i).val(s.name);
		$('input[name="sd['+i+'][prid]"]').val(prid);		
	},'json');
}	/* fxn */


function redirLookup1(vid,rid){	
	$('input[name="sd['+rid+'][prid]"]').val(vid);
	getSupplierProductByID(vid,rid)
}	/* fxn */


function rcvd(i){
	var roqty=$('#roqty'+i).val();
	$('#rxqty'+i).val(roqty);		
}	/* fxn */


function newrowMove(){
var nr = $('tbody.children>tr').size();	
var rowcount = nr+1; 
$('tbody.children').append('<tr id="trow'+nr+'" ><td>'+rowcount+'</td><td><input class="vc50" name="sd['+nr+'][prid]" tabindex="2" /></td><td><input class="vc100" id="code'+nr+'" tabindex="3" /></td><td><input class="vc200 pdl05" id="part'+nr+'" tabindex="4" />&nbsp;<input type="submit" name="auto" value="Filter" onclick="xgetProductsByPartRow('+nr+');return false;" /></td><td class=""><input id="'+nr+'" class="vc50 pdl05" name="sd['+nr+'][roqty]" value="0" tabindex="6" /></td><td class=""><input id="'+nr+'" class="vc50 pdl05" name="sd['+nr+'][rxqty]" value="0" tabindex="8" /></td><td><u class="blue" rel="'+nr+'" onclick="deltrow('+nr+');" >Del</u></td></tr>');					
numrows = nr+1;

};


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups_products.js"; ?>' ></script>
