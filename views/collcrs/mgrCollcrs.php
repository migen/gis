<h5>
	College Course Manager (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'collcrs/saveName/'.$major_id; ?>" >SaveName</a>


</h5>

<?php 

pr($rows[0]);
// pr($rows);

?>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Course</th>
	<th>Units</th>
	<th>Prerequisites</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['units']; ?></td>
	<td><?php echo $rows[$i]['prerequisites']; ?></td>
</tr>
<?php endfor; ?>
</table>



