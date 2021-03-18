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
	<th>Date</th>
	<th>Supplier</th>
	<th>Reference</th>
	<th>Total</th>
	<th>Balance</th>
	<th>Manage</th>
	<th>POID</th>	
</tr>

<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['total']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['supplier']; ?></td>
	<td><?php echo $rows[$i]['reference']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['balance'],2); ?></td>
	<td>
		  <a href="<?php echo URL.'purchases/movePO/'.$rows[$i]['poid']; ?>" >Transfer</a>
	</td>
	<td><?php echo $rows[$i]['poid']; ?></td>
</tr>
<?php endfor; ?>
</table>


<h5>Total: <?php echo number_format($total,2); ?></h5>
