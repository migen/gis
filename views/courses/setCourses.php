<?php 



?>

<h5>
	All Courses (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php 
		// $sy=isset($params[0])? $params[0]:DBYR;
		// $dbg=VCPREFIX.$sy.US.DBG; 
		$dbg=PDBG;
	?>
	| <a href='<?php echo URL."records/set/{$dbg}.05_courses"; ?>' >Recordset</a>
	| <a href='<?php echo URL."records/setup/{$dbg}.05_courses"; ?>' >Setup</a>	
	| <a href='<?php echo URL."gset/renameCourses"; ?>' >Rename-Courses</a>	
	| <a href='<?php echo URL."gset/courses"; ?>' >Batch-Courses</a>	
	| <?php $this->shovel('links_gset'); ?>
	
	

</h5>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Crs</th>
	<th>Name</th>
	<th>Label</th>
	<th>Subject</th>
	<th>Teacher</th>
	<th>Crid</th>
	<th>Level</th>
	<th>Section</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crs']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['course_label']; ?></td>
	<td><?php echo '#'.$rows[$i]['subid'].'-'.$rows[$i]['subcode']; ?></td>
	<td><?php echo '#'.$rows[$i]['tcid'].'-'.$rows[$i]['teacher']; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo '#'.$rows[$i]['lvl'].'-'.$rows[$i]['lvlcode']; ?></td>
	<td><?php echo '#'.$rows[$i]['sxn'].'-'.$rows[$i]['sxncode']; ?></td>
	<td><a href="<?php echo URL.'courses/edit/'.$rows[$i]['crs']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
