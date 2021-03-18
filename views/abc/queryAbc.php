<h3>
	Custom Query | <?php $this->shovel('homelinks'); ?>


</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
<?php for($j=0;$j<$column_count;$j++): ?>	
	<th><?php $col=$cols[$j]; echo $col; ?></th>
<?php endfor; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
<?php for($j=0;$j<$column_count;$j++): ?>	
	<td><?php $col=$cols[$j]; echo $rows[$i][$col]; ?></td>
<?php endfor; ?>


</tr>
<?php endfor; ?>
</table>
