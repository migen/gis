<h5>
	Passwords (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'syncs/syncCtp'; ?>" >SyncCtp</a>
	<?php endif; ?>
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Username</th>
	<th>Password</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows{$i}['account']; ?></td>
	<td><?php echo $rows[$i]['ctp']; ?></td>
</tr>
<?php endfor; ?>
</table>
