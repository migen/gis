<style>

.name{ width:280px; }

</style>

<h5>
	Merchandise Items (<?php echo '#'.$prodtype_id.' '.$prodtype; ?>)
	
	
</h5>

<?php

// pr($data);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th class="name" >Name</th>
	<th>Price</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['price']; ?></td>
</tr>
<?php endfor; ?>
</table>
