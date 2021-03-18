<h5>
	Clubs (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/all'; ?>" >Clubs All</a>
	| <a href="<?php echo URL.'gset/setupClubs'; ?>" >Setup</a>

</h5>

<table class="gis-table-bordered" >
<tr><th>ID</th><th>Code</th><th>Name</th><th>Teacher</th><th></th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
	<td><a href="<?php echo URL.'clubs/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>


