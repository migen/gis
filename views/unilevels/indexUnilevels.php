<h5>
	College Levels | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'college'; ?>" >College</a>	
	| <a href="<?php echo URL.'unicolleges/'; ?>" >Colleges</a>
	| <a href="<?php echo URL.'majors/'; ?>" >Majors</a>
	| <a href="<?php echo URL.'unisections/'; ?>" >Sections</a>
	| <a href="<?php echo URL.'unicourses/'; ?>" >Courses</a>


</h5>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th class="vc100" >Code</th>
	<th class="vc200" >Name</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'unilevels/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
