<?php 

	// pr($data);
	// pr($subjects[0]);
	// pr($_SESSION['q']);

$headrow = "<tr class='headrow'><th>Subj#</th><th>Crs</th><th>Sup</th><th>Subject</th><th>Code</th><th>CType</th><th>Actv</th><th>W/S</th>
<th>3-T</th><th>Wt</th><th>Disp</th><th>Genave</th><th>Affects<br />Rank</th><th>Pos</th><th>Aggre</th><th>Trns</th><th>Indent</th><th>Sem</th><th>Num</th></tr>
";

?>

<!------------------------------------------------>

<h5>
	<span class="u" ondblclick="tracehd();" >Subjects</span>
	(<?php echo $subject_count; ?>) 
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'setup/grading'; ?>" >Setup</a>
	| <a onclick="return confirm('Sure?');" href="<?php echo URL.'misc/renameAllCourses'; ?>" >Rename All</a>	
	| <a href="<?php echo URL.'mis/propagateSubjects'; ?>" >Propagate</a>	
	| <a href="<?php echo URL.'gset/courses'; ?>" >Courses</a>
	<?php $dbo=PDBO; ?>
	| <a href='<?php echo URL."records/set/{$dbo}.05_subjects"; ?>' >Set</a>
	| <a href='<?php echo URL."records/setup/{$dbo}.05_subjects"; ?>' >Setup</a>
	| <a href="<?php echo URL.'subjects?edit'; ?>" >Edit</a>
	<?php if(isset($_GET['order'])): ?>
		| <a href="<?php echo URL.'subjects'; ?>" >By Name</a>	
	<?php else: ?>
		| <a href="<?php echo URL.'subjects?order=id'; ?>" >By ID</a>
	<?php endif; ?>
</h5>


<table class="table-fx gis-table-bordered">

<?php for($i=0;$i<$subject_count;$i++): ?>
	
	<?php if($i%12){} else { echo $headrow; } ?>

	<input type="hidden" name="sub[<?php echo $i; ?>][subject_id]" value="<?php echo $subjects[$i]['subject_id']; ?>"  />

	<tr>
		<td><?php echo '#'.$subjects[$i]['subject_id'].'-'; ?></td>
		<td class="<?php echo ($subjects[$i]['is_active'])? null:'bg-salmon'; ?>" ><a 
			href="<?php echo URL.'subjects/courses/'.$subjects[$i]['id']; ?>">GO</a></td>		
		<td><?php echo $subjects[$i]['parent_id']; ?></td>
		<td><?php echo $subjects[$i]['name']; ?></td>
		<td><?php echo $subjects[$i]['code']; ?></td>
		<td><?php echo $subjects[$i]['crstype_id']; ?></td>
		<td><?php echo ($subjects[$i]['is_active']==1)? 'Y':'-'; ?></td>
		<td><?php echo $subjects[$i]['with_scores']; ?></td>
		<td><?php echo ($subjects[$i]['is_kpup']==1)? 'Y':'-'; ?></td>
		<td><?php echo $subjects[$i]['weight']; ?></td>
		<td><?php echo $subjects[$i]['is_displayed']; ?></td>
		<td><?php echo $subjects[$i]['in_genave']; ?></td>
		<td><?php echo $subjects[$i]['affects_ranking']; ?></td>
		<td><?php echo $subjects[$i]['position']; ?></td>
		<td><?php echo $subjects[$i]['is_aggregate']; ?></td>
		<td><?php echo $subjects[$i]['is_transmuted']; ?></td>
		<td><?php echo $subjects[$i]['indent']; ?></td>
		<td><?php echo $subjects[$i]['semester']; ?></td>
		<td><?php echo $subjects[$i]['is_num']; ?></td>		
	</tr>	
<?php endfor; ?>

</table>

<p>
	<!-- better ajax xeditBtn -->
	<input onclick="return confirm('Are you sure?');" type="submit" name="save" value="Save All" /> &nbsp; 
	<button><a class="no-underline" href="<?php echo URL.'mis/subjects'; ?>">Cancel</a></button>
</p>

