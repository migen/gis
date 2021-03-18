<?php 

// pr($data);

// pr($courses[2]);
// pr($courses[4]);
// pr($courses[1]);

$srid = $_SESSION['srid'];
$admin = ($srid==RMIS || $srid==RREG)? true:false;


function setPage($cq){
	global $settings_scores;
	switch($cq['ctype_id']){
		case 1: {
			$page = ($cq['with_scores']==1)? 'scores':'grades'; 			
			break;		
		}		
		case 2: $page = 'traits'; break;
		case 5: $page = 'conducts'; break;
		default: $page = 'scores'; break;		
	}
	return $page;
}


?>



<h5>
	<span ondblclick="xxtracehd();" >Loads (MIS Edit)</span> | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	| <a href='<?php echo URL."classrooms/courses"; ?>'>Crs</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	<?php if($all): ?>
		| <a href='<?php echo URL."loads/teacher/$tcid/$sy"; ?>'>Active</a>
	<?php else: ?>	
		| <a href='<?php echo URL."loads/teacher/$tcid/$sy?all"; ?>'>All</a>	
	<?php endif; ?>	
	
</h5>


<form method="POST" >	<!-- form add courses -->
<!------------------------------------------------------------------>
<?php if($admin): ?>
	<table class="table-fx gis-table-bordered">
	<tr><td><?php echo $teacher['tcid']; ?></td>
		<td><?php echo $teacher['teacher_code']; ?></td>
		<td><?php echo $teacher['teacher']; ?></td>
	<?php if(!empty($teacher['advisory'])): ?>
		<td>Advisory: <?php echo $teacher['advisory']; ?></td>	
	<?php endif; ?>
	</tr></table> <br />
<?php endif; ?>
<!------------------------------------------------------------------------------------------------------------------------>

<table class="table-fx gis-table-bordered table-altrow">
<tr class='headrow'>
	<th>#</th>
	<th>ID</th>
	<th>Classroom</th>
	<th>Type</th>
	<th>Course</th>
	<th class="vc50" >Code</th>
	<th>Label</th>
	<th>TCID
		<br /><input class="pdl05 vc50" id="itcid" /><br />	
		<input type="button" value="All" onclick="populateColumn('tcid');" >								
	</th>

	<th>Is <br />Active</th>	
	<th>With <br />Scores</th>
	<th>Is<br />3-Tier</th>
	<th>Wt</th>
	
	<th>On<br />Display</th>
	<th>In<br />Genave</th>
	<th>Affects<br />Ranking</th>
	<th>Pos</th>

	<th>Is<br />Aggre</th>
	<th>Is<br />Trns</th>
	<th>Sem</th>
	
	
	
	<th>Schedule</th>
	<?php if(!$is_teacher): ?>			
		<th class="vc100 center" >Manage</th>
	<?php endif; ?>
	
</tr>
<!-- tbody -->
<?php for($i=0;$i<$num_courses;$i++): ?>
	<?php $active = ($courses[$i]['is_active'])? true:false;  ?>
	<tr id="tr<?php echo $i; ?>" class="<?php echo (!$active)? 'red':NULL; ?>"  >
		<td><?php echo $i+1; ?></td>
		<td><?php echo $courses[$i]['course_id']; ?></td>
		<td><?php echo $courses[$i]['classroom']; ?></td>
		<td><?php echo $courses[$i]['crstype']; ?></td>
		<td>
		<?php $page = setPage($courses[$i]); $ctrl = (($page=='grades') || ($page=='scores'))? 'teachers':'advisers'; ?>
		<a href='<?php echo URL."$ctrl/$page/".$courses[$i]['course_id']."/$ssy/$sqtr"; ?>'>
			<?php echo $courses[$i]['name'];  ?></a> 			
			- <?php echo $page; ?>
		</td>
		
		
		<td><input class="pdl05 vc50" name="courses[<?php echo $i; ?>][code]" value="<?php echo $courses[$i]['code']; ?>"  /></td>
		<td><input class="pdl05" name="courses[<?php echo $i; ?>][label]" value="<?php echo $courses[$i]['label']; ?>"  /></td>
		<td><input class="pdl05 vc60 tcid" name="courses[<?php echo $i; ?>][tcid]" 
			value="<?php echo $courses[$i]['tcid']; ?>"  /></td>
		<td>
			<select id="stat<?php echo $i; ?>" name="courses[<?php echo $i; ?>][is_active]" class="full" >
				<option value="1" <?php echo ($courses[$i]['is_active'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_active'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>
		
		<td>
			<select name="courses[<?php echo $i; ?>][with_scores]" class="full" >
				<option value="1" <?php echo ($courses[$i]['with_scores'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['with_scores'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td>
			<select name="courses[<?php echo $i; ?>][is_kpup]" class="full" >
				<option value="1" <?php echo ($courses[$i]['is_kpup'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_kpup'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		
		
<td><input id="<?php echo 'Supsubject_id - '.$courses[$i]['supsubject_id']; ?>" onclick="alert(this.id);" class="pdl05 vc40" 
	name="courses[<?php echo $i; ?>][course_weight]" value="<?php echo $courses[$i]['course_weight']; ?>"  /></td>		

		<td>
			<select name="courses[<?php echo $i; ?>][is_displayed]" class="full" >
				<option value="1" <?php echo ($courses[$i]['is_displayed'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_displayed'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td>
			<select name="courses[<?php echo $i; ?>][in_genave]" class="full" >
				<option value="1" <?php echo ($courses[$i]['in_genave'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['in_genave'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		
		
		<td>
			<select name="courses[<?php echo $i; ?>][affects_ranking]" class="full" >
				<option value="1" <?php echo ($courses[$i]['affects_ranking'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['affects_ranking'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

<td><input class="pdl05 vc30" name="courses[<?php echo $i; ?>][position]" value="<?php echo $courses[$i]['position']; ?>"  /></td>		
		
		<td>
			<select name="courses[<?php echo $i; ?>][is_aggregate]" class="full" >
				<option value="1" <?php echo ($courses[$i]['is_aggregate'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_aggregate'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		
		
		<td>
			<select name="courses[<?php echo $i; ?>][is_transmuted]" class="full" >
				<option value="1" <?php echo ($courses[$i]['is_transmuted'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_transmuted'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>	
		
<td><input class="pdl05 vc30" name="courses[<?php echo $i; ?>][semester]" value="<?php echo $courses[$i]['semester']; ?>"  /></td>				
	
		<td><input class="pdl05 vc100" name="courses[<?php echo $i; ?>][schedule]" 
			value="<?php echo $courses[$i]['schedule']; ?>"  /></td>		
		
		
		<?php if(!$is_teacher): ?>		
			<td>
				<button class="vc60" ><a class="no-underline txt-black" 
					href="<?php echo URL.'courses/edit/'.$courses[$i]['course_id'].DS.$sy; ?>"> Edit </a></button>  &nbsp; 
			</td>
		<?php endif; ?>
		
	</tr>
	
	<input type="hidden" name="courses[<?php echo $i; ?>][id]" value="<?php echo $courses[$i]['course_id']; ?>"  >
	
<?php endfor; ?>

</table>
<br />

<p class="" > <input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Save"   /> </p>

</form> <!-- save -->
</table>


<p> <?php $this->shovel('hdpdiv'); ?> </p>

<!------------------------------------------------------------------------->

<script>

var hdpass 	= '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $sy; ?>';


$(function(){
	$('#hdpdiv').hide();
	hd();

})	


function subcode(subid,i){	// subjectCode	
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

	
}	/* fxn */



function disableCourse(crsid,i){
	// alert(crsid+',i: '+i);

	var vurl 	= gurl + '/mis/disableCourse/'+sy;	
	$("#dcb"+i).hide();
	$('#stat'+i).val(0);			
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crsid='+crsid,				
		async: true,
		success: function() { }		  
    });				

}	/* fxn */

function enableCourse(crsid,i){	
	var vurl 	= gurl + '/mis/enableCourse/'+sy;	
	$("#ecb"+i).hide();
	$('#stat'+i).val(1);			
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crsid='+crsid,				
		async: true,
		success: function() { }		  
    });				

}	/* fxn */


function delThis(crsid,i){	// row i
	
	// alert(crsid+i);	
	var vurl 	= gurl + '/mis/xdeleteCourse';	
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crsid='+crsid,				
		async: true,
		success: function() { 			
			$('#tr'+i).remove();
		}		  
    });				

	
}	// fxn

function showAggre(i){
	$('.hd'+i).show();

}	// alert();

</script>

<!------------------------------------------------------------------------->
<!------------------------------------------------------------------------->



