<h5>
	Course | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Course</th><td><?php echo $row['course']; ?></td></tr>
<tr><th>Label</th><td><?php echo $row['label']; ?></td></tr>
<tr><th>Level</th><td><?php echo $row['level'].' #'.$row['level_id']; ?></td></tr>
<tr><th>Section</th><td><?php echo $row['section'].' #'.$row['section_id']; ?></td></tr>
<tr><th>Subject</th><td><?php echo $row['subject'].' #'.$row['subject_id']; ?></td></tr>
<tr><th>Grades</th><td>
	<?php for($q=1;$q<5;$q++): ?>
		<a href="<?php echo URL.'teachers/grades/'.$crs.DS.$sy.DS.$q; ?>" ><?php echo $q; ?></a> &nbsp;	
	<?php endfor; ?>
</td></tr>

<tr><th>Scores</th><td>
	<?php for($q=1;$q<5;$q++): ?>
		<a href="<?php echo URL.'teachers/scores/'.$crs.DS.$sy.DS.$q; ?>" ><?php echo $q; ?></a> &nbsp;	
	<?php endfor; ?>
</td></tr>

</table>
