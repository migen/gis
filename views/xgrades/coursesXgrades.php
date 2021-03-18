<h5>
	Expired Class Courses
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Subject</th>
	<th>Teacher</th>
	<th>Scores</th>
	<th>Grades</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<?php $crs=$rows[$i]['crs']; ?>
	<td><?php echo $rows[$i]['course_label']; ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
	<td>
		<?php if((!$rows[$i]['is_aggregate']) && ($rows[$i]['ctype_id']==1) && ($rows[$i]['with_scores']==1)): ?>
			<?php for($q=1;$q<5;$q++): ?>
				<a href='<?php echo URL."teachers/scores/$crs/$sy/$q"; ?>' >Q<?php echo $q; ?></a>			
			<?php endfor; ?>
		<?php endif; ?>
	</td>	
	<td><a href='<?php echo URL."xgrades/averages/$crs/$sy/4"; ?>' ><?php echo "Grades"; ?></a></td>

</tr>
<?php endfor; ?>
</table>
