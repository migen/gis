


<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="scid" >Scid</th>
	<th>Male</th>
	<th>Code</th>
	<th>LRN</th>
	<th>Pos</th>
	<th class="vc300" >Student</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['is_male']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['lrn']; ?></td>
	<td><?php echo $rows[$i]['position']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>	
</tr>
<?php endfor; ?>
</table>
