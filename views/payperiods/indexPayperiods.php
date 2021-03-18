<h5>
	Pay Periods
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'payperiods/add'; ?>" >Add</a>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Beg</th>
	<th>End</th>
	<th>Name</th>
	<th>Actv</th>
	<th>Edit</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ppid']; ?></td>
	<td><?php echo $rows[$i]['begdate']; ?></td>
	<td><?php echo $rows[$i]['enddate']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['is_active']; ?></td>
	<td><a href="<?php echo URL.'payperiods/edit/'.$rows[$i]['ppid']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
