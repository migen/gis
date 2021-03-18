<h5>
	iBook
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'ibook/add'; ?>" >Add</a>
	
	
</h5>

<p><form method="GET" ><input type="text" name="find" />&nbsp;<input type="submit" name="submit" value="Find" /></form></p>

<?php if(isset($_GET['find'])): ?>
<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>ID</th>
<?php if($srid==RMIS): ?>
	<th>User</th>
<?php endif; ?>
<th>Date</th>
<th>Name</th>
<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
<?php if($srid==RMIS): ?>	
	<td><?php echo $rows[$i]['user'].' #'.$rows[$i]['ucid']; ?></td>
<?php endif; ?>	
	<td><?php echo date('Y-m-d D',strtotime($rows[$i]['date'])); ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'ibook/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
<?php endif; ?>