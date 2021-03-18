
<h3>
	Discounted Employee Children | <?php $this->shovel('homelinks'); ?>
	
	
</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Scid</th>
	<th>Studname</th>
	<th>Feetype</th>	
	<th>Disc</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo number_format($rows[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
</table>




