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

<tr><th class="headrow white">Subject</th><td><?php echo $row['subject']; ?></td></tr>
<tr><th class="headrow white">CrsID</th><td><?php echo $course_id; ?></td></tr>

<tr><th class="headrow white">Course</th><td><input class="vc200 pdl05" type="text" name="course[name]" 
value="<?php echo $row['name']; ?>" /></td></tr>

<tr><th class="headrow white">Teacher</th><td>
	<input class="vc200 pdl05" id="part" value="<?php echo $row['teacher']; ?>" />
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(30);return false;" />		
	<input class="vc50 pdl05" type="text" name="course[tcid]" id="tcid" value="<?php echo $row['tcid']; ?>" readonly />
</td></tr>

<tr><th class="headrow white">Subject</th><td>	
	<select class="vc200" name="course[subject_id]"  >
		<?php	foreach($subjects as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['subject_id'])? 'selected':null; ?> ><?php echo $sel['name'].' - #'.$sel['id']; ?></option><?php	endforeach; ?>				
	</select>	
</td></tr>

<tr><th class="headrow white">Classroom</th><td>	
	<select class="vc200" name="course[crid]"  >
		<?php	foreach($classrooms as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['crid'])? 'selected':null; ?> ><?php echo $sel['name'].' - #'.$sel['id']; ?></option><?php	endforeach; ?>				
	</select>	
</td>


<tr><th class="headrow white">Parent</th><td>	
	<select class="vc200" name="course[supsubject_id]"  >
		<option value="0" >Choose One</option>
		<?php	foreach($subjects as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['supsubject_id'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>	
</td>

	
<?php foreach($cols AS $col): ?>
<tr>
	<th class="headrow white" ><?php echo $col; ?></th>
	<td><input name="course[<?php echo $col; ?>]" value="<?php echo $row[$col]; ?>" ></td>	
</tr>
<?php endforeach; ?>



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
