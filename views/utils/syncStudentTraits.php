
<h5>
	Edit Student Traits |
	<?php 	$this->shovel('homelinks',$home); ?>	
	<?php if($_SESSION['srid']==RTEAC): ?>
		| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr"; ?>' >Traits</a>
	<?php else: ?>
		| <a href='<?php echo URL."mis/dgtraits/$sy/$qtr/$is_trait/$crid"; ?>' >DG Traits</a>	
	<?php endif; ?>

</h5>

<?php 

// pr($data);
// pr($grades[0]);
// pr($home);

?>


<!---------------------------------------------------------------->

<h4>Details</h4>
<table class='gis-table-bordered table-fx'>

<tr><th class='bg-blue2'>CRID</th><td><?php echo $crid; ?></td></tr>
<tr><th class='bg-blue2'>Level-Section</th><td><?php echo $course['level'].'-'.$course['section']; ?></td></tr>
<tr><th class='bg-blue2'>SCID</th><td><?php echo $scid; ?></td></tr>
<tr><th class='bg-blue2'>ID</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th class='bg-blue2'>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class='bg-blue2'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>

</table>
<br />


<!---------------------------------------------------------------->


<?php if($num_grades>0): ?>

<form method="POST" >
<table class="gis-table-bordered table-fx vc800" style="" >
	<tr class="headrow" >
		<th>#</th>	
		<th class="" ><input type="checkbox" id="chkAlla" /></th>
		<th class="" >G#</th>
		<th>Cri</th>
		<th class="vc500" >Criteria</th>
		<th>Grade</th>
	</tr>
<?php for($i=0;$i<$num_grades;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="screen" ><input type="checkbox" class="chka" name="rows[<?php echo $i;?>]" 
		value="<?php echo $grades[$i]['gid']; ?>" /></td>	
	<td class="" ><?php echo $grades[$i]['gid']; ?></td>
	<td><?php echo $grades[$i]['criteria_id']; ?></td>
	<td><?php echo $grades[$i]['criteria_code'].' - '.$grades[$i]['criteria']; ?></td>
	<td><input class="vc50 right" type="text" name="grades[<?php echo $i; ?>][grade]" value="<?php echo $grades[$i]['grade']; ?>"   /></td>

	<!------------------------->
	<input type="hidden" name="grades[<?php echo $i; ?>][gid]" value="<?php echo $grades[$i]['gid']; ?>"   />

</tr>

<?php endfor; ?>


</table>

<p>
	<span class="" ><input onclick="return confirm('Dangerous! Proceed?');" type="submit" name="batch" value="Delete" /></span> &nbsp; 
<?php if(!$is_locked): ?>
	<input type="submit" name="edit" value="Save" />
<?php endif; ?>
</p>

</form>

<?php endif; ?>	<!-- if with grades -->


<!-------------------------------------------------------------------->

<?php // echo "numgrades - $num_grades <br />"; ?>
<?php // echo "num-courses: $num_courses <br />"; ?>

<?php if($num_grades < $num_criteria): ?>	<!-- mismatch grades-courses -->

<h4>Criteria</h4>

<?php // pr($courses[0]); ?>

<form method="POST" >

<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th class="hd" >Cri#</th>
	<th class="vc500" >Criteria</th>
	<th>Grade</th>
</tr>
<?php for($i=0;$i<$num_criteria;$i++): ?>
	<?php if(!in_array($criteria[$i]['criteria_id'],$gids)): ?> 
		<tr>
			<td><?php echo $i+1; ?></td>
			<td class="hd" ><?php echo $criteria[$i]['criteria_id']; ?></td>
			<td><?php echo $criteria[$i]['criteria']; ?></td>
			<td> 
				<input class="center vc50" type="text" name="grades[<?php echo $i; ?>][grade]" value="0" />
				<input type="hidden" name="grades[<?php echo $i; ?>][criid]" value="<?php echo $criteria[$i]['criteria_id']; ?>" />
			</td>
		</tr>
	<?php endif; ?>
<?php endfor; ?>
  
</table>


<p><input type="submit" name="add" value="Add"  /></p>
</form>


<?php endif; ?>	<!-- mismatch grades-criteria -->


<!-------------------------------------------------------------------->

<script>

$(function(){
	// hd();
	nextViaEnter();
	selectFocused();
	chkAllvar('a');
	

})



</script>
