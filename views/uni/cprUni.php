<h5>
	Course Prerequisites (Many to Many RDBMS) 
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Course</th>
	<th>Subject<br />Code</th>
	<th>Subject</th>
	<th class="center" >Units</th>
	<th>Prerequisite<br />List</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['subject_code']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td class="center" ><?php echo $rows[$i]['units']; ?></td>
	<td><?php echo $rows[$i]['prerequisite_list']; ?></td>
</tr>
<?php endfor; ?>
</table>
