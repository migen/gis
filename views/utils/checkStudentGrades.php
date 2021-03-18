<?php 

// pr($grades[1]);
// pr($grades[16]);

// pr($classrooms);

?>

<h5>

	<span ondblclick="tracepass();" >Student Grades</span>
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$home; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a>
	<span class="hd" >| <a onclick="return confirm('Proceed?');" href='<?php echo URL."gtools/syncGradesByStudent/$scid"; ?>' >Sync Grades</a></span>
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>


</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>

<form method="POST" >

<p><table class="gis-table-bordered" >
<tr>
<th class="bg-blue2 white" ><?php echo 'Student'; ?></th>
<td><?php echo $student['student_code']; ?></td>
<td><?php echo $student['student']; ?></td>

<th class="bg-blue2 white" >Re-Section</th>
<td>SCID &nbsp; <input class="center vc50" name="scid" onclick="xname('dbo','00_contacts',this.value);" value="<?php echo $scid; ?>" /></td>
<td>From
<select name="crf" class="vc150" >
	<option>Choose Classroom</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td>
<td class="" >To 
<select name="crt" class="vc150" >
	<option>Choose Classroom</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td>
<td><button onclick="tracepass();return false;" >Transfer</button></td>
<?php if(!isset($_GET['all'])): ?>
	<td><a onclick="return confirm('Show all classrooms. Proceed?');" 
		href='<?php echo URL."gtools/msg/$crid/$scid/$sy/$qtr?all"; ?>' >All</a></td>
<?php endif; ?>
<td class="hd" ><input onclick="return confirm('Dangerous! Proceed?');" type="submit" name="move" value="Move"  /></td>

</tr>


</table></p>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow"  >
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>G#</th>
	<th>Sub#</th>
	<th>Actv</th>
	<th>Cty</th>
	<th>CR#</th>
	<th>CRS#</th>
	<th>Course</th>
	<th>Label</th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>
	<th>FG</th>
	<th>Manage</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $i;?>]" value="<?php echo $grades[$i]['gid']; ?>" /></td>	
	<td><?php echo $grades[$i]['gid']; ?></td>
	<td><?php echo $grades[$i]['subject_id']; ?></td>
	<td><?php echo ($grades[$i]['is_active']==1)?'A':'-'; ?></td>
	<td><?php echo $grades[$i]['ctype_id']; ?></td>
	<td><?php echo $grades[$i]['crid']; ?></td>
	<td><?php echo $grades[$i]['course_id']; ?></td>
	<td><?php echo $grades[$i]['course']; ?></td>
	<td><?php echo $grades[$i]['label']; ?></td>
	<td><?php echo $grades[$i]['q1']; ?></td>
	<td><?php echo $grades[$i]['q2']; ?></td>
	<td><?php echo $grades[$i]['q3']; ?></td>
	<td><?php echo $grades[$i]['q4']; ?></td>
	<td><?php echo $grades[$i]['fg']; ?></td>
	
<td> 
<span class="hd" >
	<a onclick="return confirm('Cannot Undo! Proceed?');" href='<?php echo URL."teachers/deleteGrade/".$grades[$i]['gid'].DS.$sy; ?>' >DEL</a>
</span>
</td>
</tr>
<?php endfor; ?>
</table>


<p class="screen hd" >

<?php if($srid==RMIS): ?>
	<button><a class="txt-black no-underline" href='<?php echo URL."gtools/syncGradesByStudent/$ucid"; ?>' >Sync Grades</a></button>
	<button><a class="txt-black no-underline" href='<?php echo URL."gtools/syncGradesByStudent/$ucid/5"; ?>' >Sync Conducts</a></button>
<?php endif; ?>

	<input onclick="return confirm('DANGEROUS! CANNOT UNDO!');" type='submit' name='batch' value='DELETE' >
	<?php $this->shovel('boxes'); ?>	
</p>
</form>

<div class="ht100" ></div>


<!------------------------------------------------------------------------------------------------->

<script>
var hdpass = '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';


	$(function(){ 
		hd(); 
		$('#hdpdiv').hide();
	})
	

	// $('input[name="data[Item]['+i+'][price]"]').val(s.price);
function checkCrids(){
	var crf = $('select[name="crf"]').val();
	var crt = $('select[name="crt"]').val();
	if(crf==crt){
		alert('Error: Same classrooms!');
		location.reload();
	} 
	

	
}
	
</script>
