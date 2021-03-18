<h3>
	Courses By Level | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'classrooms/courses/'.$crid; ?>" >Crs</a>
	| <a href="<?php echo URL.'courses/byLevel/'.$cr['level_id']; ?>" >Level</a>

</h3>

<?php 

	pr($lvl);

?>



<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>Subtype</th>
	<th>Classroom</th>
	<th>Subject</th>
	<th>Sem</th>
	<th>Course</th>
	<th>Teacher</th>
	<th>Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['subjtype_id']; ?></td>
	<td><?php echo $rows[$i]['classroom'].' #'.$rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['subject'].' #'.$rows[$i]['subject_id']; ?></td>
	<td><?php echo $rows[$i]['semester']; ?></td>
	<td><?php echo $rows[$i]['course'].' #'.$rows[$i]['course_id']; ?></td>
	<td><?php echo $rows[$i]['teacher'].' #'.$rows[$i]['tcid']; ?></td>
	<td><a href="#" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>

