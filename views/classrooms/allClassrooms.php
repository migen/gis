<h5>
	All Classrooms (<?= $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Level</th>
	<th>Section</th>
	<th>Classroom</th>
	<th>Adviser</th>
	<?php if($_SESSION['srid']==RMIS): ?>
		<th>Account</th>
		<th>Pass</th>	
	<?php endif; ?>
	<th>Edit</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo '#'.$rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['adviser']; ?></td>
	<?php if($_SESSION['srid']==RMIS): ?>
		<td><?php echo $rows[$i]['account']; ?></td>
		<td><?php echo $rows[$i]['ctp']; ?></td>
	<?php endif; ?>
	<td><a href="<?php echo URL.'classrooms/adviser/'.$rows[$i]['crid']; ?>" >Adviser</a></td>
</tr>
<?php endfor; ?>
</table>
