<h5>
	Critypes
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'hr'; ?>" >HR</a>
	| <a href="<?php echo URL.'critypes/add'; ?>" >Add</a>
	| <a href="<?php echo URL.'critypes/editCriteria'; ?>" >Edit Criteria</a>
	| <a href="<?php echo URL.'criteria/traits'; ?>" >Replace-Cri-critypes</a>
	| <?php $this->shovel('links_gset'); ?>
	
	
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
	<th>Edit</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>	
		<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" >
	<td><input class="vc500" name="posts[<?php echo $i; ?>][name]" value="<?php echo $rows[$i]['name']; ?>" ></td>
	<td><a href="<?php echo URL.'critypes/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>

<br /><input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');" >

</form>


