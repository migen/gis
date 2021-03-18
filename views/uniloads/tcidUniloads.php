<h5>
	Professor Load | <?php $this->shovel('homelinks'); ?>
	| <span>ID</span>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="shd" >Crs</th>
	<th>Tcid</th>
	<th>Professor</th>
	<th>Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $crs=$rows[$i]['crs']; ?>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php echo $rows[$i]['crs']; ?></td>
	<td><?php echo $rows[$i]['tcid']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><a href="<?php echo URL.'unicourses/edit/'.$crs; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
