<?php 
// pr($rows[0]);
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
	<th>Date</th>
	<th>Supplier</th>
	<th>Invoice</th>
	<th>Total</th>
	<th>Balance</th>
	<th>Manage</th>
	<th>ID</th>	
</tr>

<?php $sumtotal=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $sumtotal+=$rows[$i]['total']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['supplier']; ?></td>
	<td><?php echo $rows[$i]['invoice']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['balance'],2); ?></td>
	<td>
		  <a href="<?php echo URL.'purchases/viewPO/'.$rows[$i]['poid']; ?>" >View</a>
		| <a href="<?php echo URL.'purchases/editPO/'.$rows[$i]['poid']; ?>" >Edit</a>
		| <a href="<?php echo URL.'delivery/view/'.$rows[$i]['poid']; ?>" >Rcvd</a>
		<?php if($_SESSION['srid']==RMIS): ?>
			| <a href="<?php echo URL.'purchases/deletePO/'.$rows[$i]['poid'].DS.$sy; ?>" onclick="return confirm('Sure?');" >Delete</a>
		<?php endif; ?>
	</td>
	<td><?php echo $rows[$i]['poid']; ?></td>
</tr>
<?php endfor; ?>

<tr>
<td colspan="4" ></td>
<td class="right" ><?php echo number_format($sumtotal,2); ?></td>
<td colspan="3" ></td>

</tr>

</table>