<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Reference</th>
	<th>Status</th>
	<th>Date</th>
	<th>Src</th>
	<th>Dest</th>
	<th>Modified</th>
	<th>Action</th>
	<th>ID</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['reference']; ?></td>	
	<td><?php echo ($rows[$i]['is_delivered']==1)? 'Delivered':'Pending'; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo "T".$rows[$i]['src']; ?></td>
	<td><?php echo "T".$rows[$i]['dest']; ?></td>
	<td><?php echo $rows[$i]['modified']; ?></td>
	<td>
		<a href="<?php echo URL.'logistics/view/'.$rows[$i]['smvid']; ?>" >View</a>
		| <a href="<?php echo URL.'logistics/edit/'.$rows[$i]['smvid']; ?>" >Edit</a>
	</td>
	<td><?php echo $rows[$i]['smvid']; ?></td>	
</tr>
<?php endfor; ?>
</table>
