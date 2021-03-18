<h5>
	Products Manager (<?php echo (!empty($_GET))? $count:null; ?>)
	

</h5>

<p>
1) get prid, suppid, order, dir <br />
</p>

<?php if(!empty($_GET)): ?>

<table class="gis-table-bordered table-altrow alt-fx" >
<tr>
<th>#</th>
<th>Edit</th>
<th>Prid-Product</th>
<th>Code</th>
<th>Barcode</th>
<th>Suppid-Supplier</th>
<th>Cost</th>
<th>Price</th>
<th>Level</th>
<th>Level Currcost</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href="<?php echo URL.'products/view/'.$rows[$i]['prid']; ?>" >Edit</a></td>	
	<td><?php echo $rows[$i]['prid'].' - '.$rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['suppid'].' - '.$rows[$i]['supplier']; ?></td>
	<td><?php echo $rows[$i]['cost']; ?></td>
	<td><?php echo $rows[$i]['price']; ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td><?php echo $rows[$i]['level_currcost']; ?></td>
	
</tr>
<?php endfor; ?>

</table>

<?php endif; ?>