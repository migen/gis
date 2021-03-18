<h5>
	Returns / Exchanges 

</h5>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>Prid</th>
	<th>Product</th>
	<th>Qty</th>	
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
</tr>
<?php endfor; ?>
</table>
