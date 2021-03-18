

<table id="tblExport" class="table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="scid" >Scid</th>
	<th>Male</th>
	<th>Code</th>
	<th>Actv</th>
	<th>LRN</th>
	<th>Pos</th>
	<th class="vc300" >Student</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr class="<?php echo ($rows[$i]['is_active']!=1)? 'red':NULL; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['is_male']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td class="center" ><?php echo ($rows[$i]['is_active']!=1)?'-':NULL; ?></td>
	<td><?php echo $rows[$i]['lrn']; ?></td>
	<td><?php echo $rows[$i]['position']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>	
	<td><a href="<?php echo URL.'profiles/scid/'.$rows[$i]['scid']; ?>" >Profile</a></td>	
</tr>
<?php endfor; ?>
</table>
