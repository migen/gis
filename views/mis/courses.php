<?php 

// pr($data);
// pr($_SESSION['q']);	

$headrow = "<tr class='headrow'><th>#</th><th>ID</th><th>Type</th><th>W/S</th><th>3Tier</th><th>Disp</th><th>Genave</th><th>Affx<br />Ranks</th><th>Sub</th><th>Label</th><th>Code</th><th>Teacher</th><th>Parent</th><th>Wt</th><th>Pos</th><th>Sem</th><th>Active</th><th>Schedule</th><th>Manage</th></tr>
";



?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	<a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'subjects'; ?>" >Subjects</a> 
	| <a href="<?php echo URL.'classrooms/level/4'; ?>" >Classrooms</a> 
	| <a href="<?php echo URL.'gset/components/'.$classroom['level_id']; ?>" >Components</a> 
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >Classlist</a>
	| <a href='<?php echo URL."classrooms/courses/$crid/$sy"; ?>' >Setup</a>
	| <a href='<?php echo URL."gset/courses/".$classroom['level_id']."/$sy"; ?>' >Batch Subjects</a>
	
	
</h5>

<p><?php $this->shovel('hdpdiv'); ?></p>

<form method="POST" >	<!-- form add courses -->

<input type="hidden" name="lvlcode" value="<?php echo $classroom['lvlcode']; ?>" />
<input type="hidden" name="sxncode" value="<?php echo $classroom['sxncode']; ?>" />
<input type="hidden" name="year" value="<?php echo $sy; ?>" readonly />


<div class="third" >
<table class="table-fx gis-table-bordered">
<tr><th class="headrow white" >Classroom</th><td class="">
	<?php echo $classroom['lvlcode'].' - '.$classroom['sxncode']; ?></td></tr>
<tr><th class="headrow white" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>	
</table> 
</div>

<div class="third" >
<table class="screen gis-table-bordered table-fx">

	<?php 
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'courses';
		// pr($d);
		$this->shovel('redirect_classroom',$d); 	
	?>
</table>
</div>

<div class="clear" > </div>

<!------------------------------------------------------------------------------------------------------------------------>

<h4 ondblclick="tracehd();" class="underline" >Courses</h4>

<table class="table-fx gis-table-bordered">

<!-- data -->
<?php for($i=0;$i<$num_courses;$i++): ?>

<?php if($i%10){} else { echo $headrow; } ?>


	<tr id="tr<?php echo $i; ?>" class="<?php echo (!$courses[$i]['is_active'])? 'red':NULL; ?> "  >
		<td><?php echo $i+1; ?></td>
		<td><?php echo $courses[$i]['id']; ?></td>
		<td><?php echo $courses[$i]['crstype']; ?></td>
		<td class="center" ><?php echo ($courses[$i]['with_scores'])? 'S':'-'; ?></td>
		<td class="center" ><?php echo ($courses[$i]['is_kpup'])? 'Y':'-'; ?></td>
		<td class="center" ><?php echo ($courses[$i]['is_displayed'])? 'Y':'-'; ?></td>
		<td class="center" ><?php echo ($courses[$i]['in_genave'])? 'Y':'-'; ?></td>
		<td class="center" ><?php echo ($courses[$i]['affects_ranking'])? 'Y':'-'; ?></td>
		<td><?php echo $courses[$i]['subject_id']; ?></td>
		<td><?php echo $courses[$i]['label']; ?></td>
		<td><?php echo $courses[$i]['code']; ?></td>
		<td><a href="<?php echo URL.'loads/teacher/'.$courses[$i]['tcid'].DS.$sy; ?>" >
			<?php echo $courses[$i]['teacher']; ?></a></td>
		<td><?php echo $courses[$i]['supsubject']; ?></td>
		<td><?php echo $courses[$i]['course_weight']; ?></td>
		<td><?php echo $courses[$i]['position']; ?></td>
		<td><?php echo $courses[$i]['semester']; ?></td>
		<td id="stat<?php echo $i; ?>" class="underline"  >
			<span id="<?php echo $courses[$i]['tlogin'].'-'.$courses[$i]['tpass']; ?>" ondblclick="alert(this.id);" >
				<?php echo ($courses[$i]['is_active'])? "Active":"Not Active"; ?></span>							
		</td>						
		<td class="vc50" ><?php echo $courses[$i]['schedule']; ?></td>		
		<td>
			<button id="dcb<?php echo $i; ?>" class="vc80" ><a class="txt-black no-underline"  
				href="<?php echo URL.'courses/edit/'.$courses[$i]['id'].DS.$sy; ?>">Edit</a></button> 			
		</td>
	
		<td class="hd" ><span><?php echo $courses[$i]['tlogin'].'-'.$courses[$i]['tpass']; ?></span></td>
		<td class="hd" ><a href='<?php echo URL."mis/delcrs/".$courses[$i]['course_id']; ?>' >DEL</a></td>
	
	</tr>	
<?php endfor; ?>

</table>

<!------------------------------------------------------------------------->

<div class="ht100"> &nbsp; </div>

<div class="hd" >
<h4> Add Courses </h4>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>Subject</th>
	<th>Code</th>
	<th>Label</th>
	<th>Type</th>
	<th>W/S</th>
	<th>KPUP</th>
	<th>Teacher</th>
	<th class="hdh" >Position</th>	
	<th class="hdh" >Is Aggre</th>
	<th class="hdh" >Parent</th>
	<th class="hdh" >Wt</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select onchange="subcode(this.value,this.id)" id="<?php echo $i; ?>" class="vc150" name="courses[<?php echo $i; ?>][subject_id]"  >
			<option>Choose One</option>
			<?php	foreach($subjects as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>
		<input id="sub<?php echo $i; ?>" type="hidden" name="courses[<?php echo $i; ?>][subject]"  />
	<td><input id="scode<?php echo $i; ?>" class="vc50" type="text" name="courses[<?php echo $i; ?>][subcode]" maxlength="6" /></td>
	<td><input class="pdl05 vc150" type="text" name="courses[<?php echo $i; ?>][label]" placeholder="optional" /></td>
		
	<td>
		<select name="courses[<?php echo $i; ?>][crstype_id]"  >
			<?php	foreach($crstypes as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>	
	
	<td>
		<select name="courses[<?php echo $i; ?>][with_scores]"  >
			<option value="1" >Y</option>
			<option value="0" >N</option>
		</select>
	</td>	
	
	<td>
		<select name="courses[<?php echo $i; ?>][is_kpup]"  >
			<option value="1" >Y</option>
			<option value="0" >N</option>
		</select>
	</td>	
	
	<td>
		<select class="vc150" name="courses[<?php echo $i; ?>][tcid]"  >
			<option value="0" >Choose One</option>
			<?php	foreach($teachers as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>	
	
	<td><input class="pdl05 vc50" type="number" name="courses[<?php echo $i; ?>][position]" value="10"  /></td>	

	<td><select class="vc80 pdl05" name="courses[<?php echo $i; ?>][is_aggregate]"  > <option value="0"  >No</option> <option value="1"  >Yes</option> </select></td>

	<td>
		<select class="vc150" name="courses[<?php echo $i; ?>][supsubject_id]"  >
			<option value="0" >Choose One</option>
			<?php	foreach($subjects as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>		
	<td><input class="pdl05 vc50" type="text" name="courses[<?php echo $i; ?>][weight]" value="100"  /></td>	
	
</tr>

<?php endfor; ?>			
</table>

<?php $level_id = isset($_SESSION['classrooms']['level_id'])? $_SESSION['classrooms']['level_id'] : "1"; ?>

<p>
	<input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis/classrooms/'.$level_id; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->

</table>

<p><?php $this->shovel('numrows'); ?></p>
</div>


<!------------------------------------------------------------------------->

<script>

var hdpass 	= '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();

})

function subcode(subid,i){	/*  subjectCode	 */
	var vurl 	= gurl + '/mis/subcode';		
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'subid='+subid,				
		async: true,
		success: function(s) { 			
			$('#sub'+i).val(s.name);
			$('#scode'+i).val(s.code);
		}		  
    });				

	
}	





function showAggre(i){
	$('.hd'+i).show();

}	


</script>




