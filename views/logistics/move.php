<h5>
	Move Stocks
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href="<?php echo URL.'logistics/index'; ?>">Filter</a>	
		
	
</h5>


<form method="POST" >

<div class="third" >
<table class="gis-table-bordered" >
<tr><th>Date</th><td class="vc200" ><input type="date" class="full pdl05" value="<?php echo $_SESSION['today']; ?>" 
	name="smv[date]" /></td></tr>
	
<tr><th>From (Src)</th><td>
<select id="tsrc" name="smv[src]" class="full" />
	<?php foreach($terminals AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>	
</td></tr>

<tr><th>To (Dest)</th><td>
<select id="tdest" name="smv[dest]" class="full" />
	<?php foreach($terminals AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>	
</td></tr>
</table>
</div>

<div class="third" >
<table class="gis-table-bordered" >
<tr><th>Reference</th><td class="vc300" ><input class="full pdl05" name="smv[reference]" 
	value="<?php echo $reference; ?>" /></td></tr>
<tr><th>Comments</th><td class="" ><input class="full pdl05" name="smv[comments]" /></td></tr>
</table>
</div>



<div class="clear" >&nbsp;</div>
<div class="fourth hd" id="names" >Names</div>
<div class="clear" >&nbsp;</div>

<!------------------------------------------------------------------------------------------------>

<table class="gis-table-bordered table-fx" >
<tr>
	<th>ID</th>
	<th>Code</th>
	<th>Product</th>
	<th>Order<br />Qty</th>
	<th>Rcvd<br />Qty</th>
	<th>Del</th>
	<th>Qty<br />Src</th>
	<th>Qty<br />Dest</th>
</tr>
<tbody class='children'> <!-- needed for addRow -->
<?php 
	$numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; 
	$nr = $numrows;
?>
<?php for($i=0;$i<$nr;$i++): ?>
<tr id="trow<?php echo $i; ?>" >
	<td><input class="vc50" name="smvd[<?php echo $i; ?>][prid]" tabindex="2" /></td>	
	<td><input class="vc100" id="code<?php echo $i; ?>" tabindex="3" /></td>	
	<td>		
		<input class="vc200 pdl05" id="part<?php echo $i; ?>" tabindex="4" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetProductsByPartRow(<?php echo $i; ?>);return false;" 
			tabindex="4" />		
	</td>
	<td><input class="vc50 pdl05" name="smvd[<?php echo $i; ?>][roqty]" value="0" tabindex="6" /></td>
	<td><input class="vc50 pdl05" name="smvd[<?php echo $i; ?>][rxqty]" value="0" tabindex="8" /></td>
	<td><u onclick="deltrow(<?php echo $i; ?>);" class='blue' >Del</u></td>
	<td id="qsrc<?php echo $i; ?>" ></td>
	<td id="qdest<?php echo $i; ?>" ></td>
</tr>
<?php endfor; ?>

</tbody>
</table>


<p>
	<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" />
	<a id="addrow" class="u txt-blue" onclick="newrowMove();return false;" >Add Row</a>

</p>


</form>


<h4> Add products to move:
<?php $this->shovel('numrows'); ?>
</h4>

<div class="ht100" ></div>


<!------------------------------------------------------------------------------------------------>


<script>
var gurl = "http://<?php echo GURL; ?>";
var numrows = "<?php echo $numrows; ?>";	


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

})


// total += parseFloat(eval('q'+i));

function redirLookup(prid,i){
	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "getSupplierProductByID";	
	var tsrc=$('#tsrc').val();
	var tdest=$('#tdest').val();
	$.post(vurl,{task:task,prodid:prid},function(s){
		var amount = parseFloat(s.roqty)*parseFloat(s.cost);
		var trmlsrc="s.t"+tsrc;
		var trmldest="s.t"+tdest;
		// alert(eval(trmlsrc));
		var qtsrc=eval(trmlsrc);
		var qtdest=eval(trmldest);
		$('#code'+i).val(s.code);
		$('#part'+i).val(s.name);
		$('input[name="smvd['+i+'][prid]"]').val(prid);		
		// alert(qtsrc+', qtdest: '+qtdest);
		$('#qsrc'+i).text(qtsrc);
		$('#qdest'+i).text(qtdest);
	},'json');
}	/* fxn */


function redirLookup1(vid,rid){	
	$('input[name="smvd['+rid+'][prid]"]').val(vid);
}	/* fxn */


function newrowMove(){
var nr = $('tbody.children>tr').size();	
var rowcount = nr+1; 
$('tbody.children').append('<tr id="trow'+nr+'" ><td><input class="vc50" name="smvd['+nr+'][prid]" tabindex="2" /></td><td><input class="vc100" id="code'+nr+'" tabindex="3" /></td><td><input class="vc200 pdl05" id="part'+nr+'" tabindex="4" />&nbsp;<input type="submit" name="auto" value="Filter" onclick="xgetProductsByPartRow('+nr+');return false;" /></td><td class=""><input id="'+nr+'" class="vc50 pdl05" name="smvd['+nr+'][roqty]" value="0" tabindex="6" ></td><td class=""><input id="'+nr+'" class="vc50 pdl05" name="smvd['+nr+'][rxqty]" value="0" tabindex="8" ></td><td><u class="blue" rel="'+nr+'" onclick="deltrow('+nr+');" >Del</u></td><td id="qsrc'+nr+'" ></td><td id="qdest'+nr+'" ></td></tr>');					
numrows = nr+1;

};


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups_products.js"; ?>' ></script>

