<script>
	$(function(){
		excel();
	})



</script>

<?php 
	// pr($sy); 

?>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Trml</th>
	<th>Datetime</th>
	<th>Cashier</th>
	<th>Total</th>
	<th></th>
	<th>ID</th>	
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['terminal']; ?></td>
	<td><?php echo $rows[$i]['datetime']; ?></td>
	<td><?php echo $rows[$i]['cashier']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>
	<td>
		  <a href="<?php echo URL.'npos/view/'.$rows[$i]['posid'].DS.$sy; ?>" >View</a>
	</td>
	<td><?php echo $rows[$i]['posid']; ?></td>
</tr>
<?php endfor; ?>
</table>