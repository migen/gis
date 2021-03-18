<h5>
	<a href="<?php echo URL.'fpos'; ?>" >Find</a>
	| <?php $this->shovel('homelinks'); ?>
	
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>ID</th>
	<th>Date</th>
	<th class="right" >Total</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo date('Y-m-d',strtotime($rows[$i]['datetime'])); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>
	<td><a href="<?php echo URL.'npos/view/'.$rows[$i]['id'].DS.DBYR; ?>" >View</a></td>
</tr>
<?php endfor; ?>
</table>

