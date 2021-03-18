



<table id="tblExport" class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th class="hd" >Scid</th>
	<th class="vc300" >Student</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $rows[$i]['scid']; ?></td>	
	<td><?php echo $rows[$i]['name']; ?></td>	
</tr>
<?php endfor; ?>
</table>
