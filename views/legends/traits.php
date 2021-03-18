<h5>
	Traits Legends
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'criteria'; ?>" >Edit</a>

</h5>


<table class="gis-table-bordered table-fx table-altrow" >
<tr><th>#</th><th>ID</th><th>Code</th><th>Indicator</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>
