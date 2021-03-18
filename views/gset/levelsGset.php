<?php 
// pr($rows[0]);
?>
<h5>
	Levels
	| <?php $this->shovel('homelinks'); ?>	
	| <a href="<?php echo URL.'mis/levels'; ?>">*Levels</a> 	
	| <a href="<?php echo URL.'levels/set'; ?>" >Full</a>	
	| <?php $this->shovel('links_gset'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>ID</th>
<th>Code</th>
<th class="vc300" >Level</th>
<th class="" ></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td>Edit</td>
</tr>
<?php endfor; ?>
</table>
