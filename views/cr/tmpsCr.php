<h5>
	Tmp Classrooms
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Lvl</th>
	<th>Sxn</th>
	<th>Name</th>
	<th>Label</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['section_id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['label']; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht50" ></div>

