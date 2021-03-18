<h5>
	View | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Label</th><td><?php echo $row['label']; ?></td></tr>
<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>Value</th><td><?php echo $row['value']; ?></td></tr>
<tr><th colspan=2 ><a href="<?php echo URL.'settings/edit/'.$id; ?>" >Edit</a></th></tr>
</table>
