<h5>
	Purge Employees (<?php echo isset($count)? $count:NULL; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'purge/employees/'.RTEAC; ?>" >Teachers</a>
	| <a href="<?php echo URL.'purge/employees?all'; ?>" >All</a>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Ucid</th>
	<th>Rid</th>
	<th>Student</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ucid']; ?></td>
	<td><?php echo $rows[$i]['role_id']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><a href="<?php echo URL.'purge/contact/'.$rows[$i]['ucid']; ?>" >Purge</a></td>
</tr>
<?php endfor; ?>
</table>

