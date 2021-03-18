<h5>
	View Major | <?php $this->shovel('homelinks','College'); ?>
	| <a href="<?php echo URL.'majors/edit/'.$major_id; ?>" >Edit</a>
	| <a href="<?php echo URL.'unicolleges'; ?>" >Colleges</a>
\		
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th>Code</th><td><?php echo $row['code']; ?></td></tr>
<tr><th>Major</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>College</th><td><?php echo $row['college']; ?></td></tr>
<tr><th>Years</th><td><?php echo $row['years']; ?></td></tr>

</table>