<?php 

?>

<h3>
	All (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'families'; ?>" >Families</a>
	

</h3>




<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
	<th></th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['pkid']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'families/members/'.$rows[$i]['pkid']; ?>" >Members</a></td>
	<td><a href="<?php echo URL.'families/edit/'.$rows[$i]['pkid']; ?>" >Edit</a></td>
	
</tr>
<?php endfor; ?>
</table>
