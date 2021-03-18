<h5>
Pool Students (<?php echo $count; ?>)
|<a href="<?php echo URL.'pools/roster/'.$crid; ?>" >Roster</a>



</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>Keys</th>
<th>ID No.</th>
<th>Name</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>
