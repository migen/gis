<?php 

// pr($rows);
// pr($rows[0]);
// pr($rows[1]);

?>

<script>
	$(function(){
		excel();
	})



</script>





<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Supplier</th>
	<th>Product</th>
	<th>T#</th>
	<th>Qty</th>
	<th>Poid</th>	
	<th>SuppID</th>	
	<th>Prid</th>	
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['supplier']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['terminal']; ?></td>
	<td class="right" ><?php echo round($rows[$i]['sumqty']); ?></td>
	<td><?php echo $rows[$i]['poid']; ?></td>
	<td><?php echo $rows[$i]['suppid']; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
</tr>
<?php endfor; ?>


</table>