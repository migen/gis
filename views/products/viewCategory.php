<h5>

<?php echo $prodcategory['name']; ?>


</h5>

<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th class="vc150" >Product</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $products[$i]['product']; ?></td>
</tr>
<?php endfor; ?>
</table>