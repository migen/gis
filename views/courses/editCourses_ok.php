<style>

</style>

<?php 

	// pr($data);
	// pr($course);
	$crs=$course_id;
?>


<h5>
	Edit Course | (Cr/edit)
	<?php 	$controller = 'mis'; $this->shovel('homelinks',$controller); ?>
	| <a href="<?php echo URL.'mis/subjects'; ?>">Subjects</a>
<span class="hd" >|<a onclick="return confirm('Dangerous!Proceed?');" href="<?php echo URL.'mis/deleteCourse/'.$course_id; ?>">Delete</a></span>

	<?php if($_SESSION['ucid']==1): ?>
		| <a href="<?php echo URL.'purge/crs/'.$crs; ?>" >Purge</a>
	<?php endif; ?>
	
	
</h5>

<p> <?php $this->shovel('hdpdiv'); ?> </p>


<form method="POST" >
<div class="third" >	<!-- left -->

<table class="gis-table-bordered table-fx" >

<tr><th class="headrow white">Is K12</th><td><?php echo ($course['is_k12'])? 'Yes':'Not K12'; ?></td></tr>
<tr><th class="headrow white">Subject</th><td><?php echo $course['subject']; ?></td></tr>
<tr><th class="headrow white">CrsID</th><td><?php echo $course_id; ?></td></tr>

<tr><th class="headrow white">Course</th><td><input class="vc200 pdl05" type="text" name="course[name]" 
value="<?php echo $course['name']; ?>" /></td></tr>

<tr><th class="headrow white">Teacher</th><td>
	<input class="vc200 pdl05" id="part" value="<?php echo $course['teacher']; ?>" />
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(30);return false;" />		
	<input class="vc50 pdl05" type="text" name="course[tcid]" id="tcid" value="<?php echo $course['tcid']; ?>" readonly />
</td></tr>

<tr><th class="headrow white">Is Active</th><td>	
	<select class="vc200" name="course[is_active]"  >
		<option value="1" <?php echo ($course['is_active']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($course['is_active']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">With Scores</th><td>	
	<select class="vc200" name="course[with_scores]"  >
		<option value="1" <?php echo ($course['with_scores']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($course['with_scores']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>



<tr><th class="headrow white">Weight</th><td><input class="vc200 pdl05" type="text" name="course[course_weight]" 
	value="<?php echo $course['course_weight']; ?>" /></td></tr>


<tr><th class="headrow white">Is Displayed</th><td>	
	<select class="vc200" name="course[is_displayed]"  >
		<option value="1" <?php echo ($course['is_displayed']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($course['is_displayed']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">In Genave</th><td>	
	<select class="vc200" name="course[in_genave]"  >
		<option value="1" <?php echo ($course['in_genave']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($course['in_genave']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Affects Ranking</th><td>	
	<select class="vc200" name="course[affects_ranking]"  >
		<option value="1" <?php echo ($course['affects_ranking']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($course['affects_ranking']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Position</th><td><input class="vc200 pdl05" type="text" name="course[position]" 
	value="<?php echo $course['position']; ?>" /></td></tr>


<tr><th class="headrow white">Is Aggregate</th><td>	
	<select class="vc200" name="course[is_aggregate]"  >
		<option value="1" <?php echo ($course['is_aggregate']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($course['is_aggregate']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Is Transmuted</th><td>	
	<select class="vc200" name="course[is_transmuted]"  >
		<option value="1" <?php echo ($course['is_transmuted']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($course['is_transmuted']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Code</th><td><input class="vc200 pdl05" type="text" name="course[code]" value="<?php echo $course['code']; ?>" /></td></tr>
<tr><th class="headrow white">Label</th><td><input class="vc200 pdl05" type="text" name="course[label]" value="<?php echo $course['label']; ?>" /></td></tr>

<tr><th class="headrow white">Type</th><td>	
	<select class="vc200" name="course[crstype_id]"  >
		<?php	foreach($crstypes as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$course['crstype_id'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>	
</td></tr>

<tr><th class="headrow white">Subject</th><td>	
	<select class="vc200" name="course[subject_id]"  >
		<?php	foreach($subjects as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$course['subject_id'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>	
</td></tr>

<tr><th class="headrow white">Classroom</th><td>	
	<select class="vc200" name="course[crid]"  >
		<?php	foreach($classrooms as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$course['crid'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>	
</td>

	
<tr><th class="headrow white">Semester</th><td><input class="vc200 pdl05" type="number" name="course[semester]" 
	value="<?php echo $course['semester']; ?>" min="0" max="2" /></td></tr>	

<tr><th class="headrow white">Is Num</th><td>	
	<select class="vc200" name="course[is_num]"  >
		<option value="1" <?php echo ($course['is_num']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($course['is_num']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

	
<tr><th class="headrow white">Parent</th><td>	
	<select class="vc200" name="course[supsubject_id]"  >
		<option value="0" >Choose One</option>
		<?php	foreach($subjects as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$course['supsubject_id'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>	
</td>



<tr><th class="headrow white">Units</th><td><input class="vc200 pdl05" type="text" name="course[units]" value="<?php echo $course['units']; ?>" <?php echo ($course['level_id']!=13)? 'readonly':NULL; ?>  /></td></tr>


<tr><th class="headrow white">Schedule</th><td><input class="vc200 pdl05" type="text" name="course[schedule]" value="<?php echo $course['schedule']; ?>" /></td></tr>

</tr>



<tr><th colspan="2" ><input class="vc100" type="submit" name="submit" value="Save" />


<button><a class="txt-black no-underline" href="<?php echo $curl; ?>" >Cancel</a></button>
<button><a class="txt-black no-underline" onclick="return confirm('Dangerous! Procees?');" 
	href='<?php echo URL."mis/deleteCourse/$course_id"; ; ?>' >Delete</a></button>
</th></tr>
</table>



</div> <!-- left -->

<div class="third" id="names" ></div>

</form>



<div class="ht100 clear" ></div>



<script>

var hdpass 	= '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';


$(function(){
	$('#hdpdiv').hide();
	hd();
	$('html').live('click',function(){  $('#names').hide();  });

})	

function redirContact(ucid){
	$('#tcid').val(ucid);

}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
