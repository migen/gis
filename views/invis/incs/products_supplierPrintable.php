<?php 
// echo "MIT supplier exit "; exit;
// pr($_SESSION['q']);

?>

<?php ?>
<div class="clear" ></div>
<table id="tblExport" class="gis-table-bordered table-fx" >
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
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo $rows[$i]['cost']; ?></td>
	<td class="right" ><?php echo $rows[$i]['price']; ?></td>
	<td class="right" ><?php echo $rows[$i]['level']; ?></td>
	<td class="right" ><?php echo $rows[$i]['t'.$t]; ?></td>
	
		
</tr>
<?php endfor; ?>
</table>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>
var gurl="http://<?php echo GURL; ?>";
var t="<?php echo $t; ?>";

$(function(){
	excel();
	nextViaEnter();
})



</script>