<h3>
	Pivots | <?php $this->shovel('homelinks'); ?>

</h3>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Classroom</th>
	<th>Level</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
</tr>
<?php endfor; ?>
</table>




