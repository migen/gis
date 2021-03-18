<h5>
	Prereq (Many to Many RDBMS) 
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Subject</th>
	<th>Prerequisite</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td><?php echo $rows[$i]['prereq']; ?></td>
</tr>
<?php endfor; ?>
</table>
