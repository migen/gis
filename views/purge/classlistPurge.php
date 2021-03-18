<h5>
	Purge Students (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><a href="<?php echo URL.'purge/contact/'.$rows[$i]['scid']; ?>" >Purge</a></td>
</tr>
<?php endfor; ?>
</table>

