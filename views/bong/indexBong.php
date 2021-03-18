<h5>
	Bong Table of Dreams

</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Who</th>
	<th>What</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['who']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>



</table>

