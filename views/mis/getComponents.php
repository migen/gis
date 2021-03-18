<h5>
	Get Components

<?php // pr($rows[0]); ?>
	
</h5>

<table class="gis-table-bordered table-fx" >
<tr>
<th>#</th>
<th>Cri</th>
<th>Comp</th>
<th>Criteria</th>
<th>Subject</th>
<th>CTID</th>
<th>Wt</th>

</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
<td><?php echo $i+1; ?></td>
<td><?php echo $rows[$i]['criteria_id']; ?></td>
<td><?php echo $rows[$i]['component_id']; ?></td>
<td><?php echo $rows[$i]['criteria']; ?></td>
<td><?php echo $rows[$i]['subject']; ?></td>
<td><?php echo $rows[$i]['crstype_id']; ?></td>
<td><?php echo $rows[$i]['weight']; ?></td>
</tr>
<?php endfor; ?>

</table>

