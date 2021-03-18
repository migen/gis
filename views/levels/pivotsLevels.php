<h3>
	Pivots | <?php $this->shovel('homelinks'); ?>

</h3>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Prid</th>
	<th>Name</th>
	<th>Color</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['color']; ?></td>
</tr>
<?php endfor; ?>
</table>




