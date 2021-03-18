<?php 

// pr($level);

$headrow = "<tr class='headrow'><th>Crs</th><th>Sub</th><th>Sup</th><th>Cls</th><th>Sxn</th><th>Teacher</th><th>TCID</th><th>Cty</th><th>Code</th><th>Label</th><th>Active</th>
<th>W/S</th><th>3-T</th><th>Wt</th><th>Disp</th><th>Genave</th><th>Affects<br />Rank</th><th>Pos</th><th>Aggre</th><th>Trns</th><th>Indent</th><th>Sem</th><th>Sched</th><th></th></tr>
";

?>



<h5>
	<span ondblclick="xxtracehd();" ><?php echo $level['name']; ?> Courses </span> | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'mis/subjects'; ?>">Subjects</a>
	| <a href="<?php echo URL.'mis/subjectLevels'; ?>" >Subj-Levels</a>	
	| <a href='<?php echo URL."gset/courses/$lvlid"; ?>' >Batch Subjects</a>
	
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>
	
	
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."mis/lvlcrs/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>



<form method="POST" >	<!-- form add courses -->
<!------------------------------------------------------------------>


<div class="half" >
<table class="screen gis-table-bordered table-fx">

	<?php 
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'clscrs';
		$this->shovel('redirect_classroom',$d); 	
	?>
</table>

</div>


<?php  ?>

<!------------------------------------------------------------------------------------------------------------------------>

<table class="table-fx gis-table-bordered table-altrow  ">
<?php // echo $headrow; ?>
<tr class='headrow'>
	<th>Crs<br />Edit</th>
	<th>Sub</th>
	<th>Sup<br />Sub</th>
	<th>Cls</th>
	<th>Sxn</th>
	<th>Teacher</th>
	<th >TCID</th>
	<th>Cty</th>
	<th class="vc50" >Code</th>
	<th>Label</th>
	<th>Is <br />Active
		<select id="iactive" class='full'>	
			<option> - </option>
			<option value="1" > Yes </option>
			<option value="0" > No </option>				
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('active');" />			
	
	</th>
	
	<th>With <br />Scores
		<select id="iws" class='full'>	
			<option> - </option>
			<option value="1" > Yes </option>
			<option value="0" > No </option>				
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('ws');" />		
	
	</th>
	<th>Is<br />3-Tier
		<select id="ikpup" class='full'>	
			<option> - </option>
			<option value="1" > Yes </option>
			<option value="0" > No </option>				
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('kpup');" />		
	</th>
	
	<th>Wt
		<br />&nbsp;<br />
		<input id="iwt" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('wt');" />					
	</th>
	
	<th>On<br />Display
		<select id="idisplay" class='full'>	
			<option> - </option>
			<option value="1" > Yes </option>
			<option value="0" > No </option>				
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('display');" />			
	</th>
	<th>In<br />Genave
		<select id="iga" class='full'>	
			<option> - </option>
			<option value="1" > Yes </option>
			<option value="0" > No </option>				
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('ga');" />			
	</th>
	<th>Affects<br />Ranking
		<select id="irank" class='full'>	
			<option> - </option>
			<option value="1" > Yes </option>
			<option value="0" > No </option>				
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('rank');" />			
	</th>

	<th>Pos
		<br />&nbsp;<br />	
		<input id="ipos" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('pos');" />						
	</th>
	
	<th>Is<br />Aggre</th>	
	<th>Is<br />TRNS</th>	

	<th>Indent
		<input id="iindent" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('indent');" />						
	</th>
	<th>Sem
		<input id="isem" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('sem');" />						
	</th>	
	<th>Schedule</th>
	<th>&nbsp;</th>
	
</tr>


<!-- tbody -->
<?php for($i=0;$i<$num_courses;$i++): ?>
	<?php $active = ($courses[$i]['is_active'])? true:false;  ?>
	
	<?php if($i%8){} else { echo $headrow; } ?>
	
<tr id="tr<?php echo $i; ?>" 
class="<?php echo (!$active)? 'red':''; 
if($level['is_sem']!=0){
	echo ($courses[$i]['semester']==1)? 'bg-lightgreen':'';  echo ($courses[$i]['semester']==2)? 'bg-yellow':''; 			
} 
?>"  >
			
		<td><a href='<?php echo URL."mis/editCourse/".$courses[$i]['course_id']; ?>' ><?php echo $courses[$i]['course_id']; ?></a></td>
		<td><input class="pdl05 full" name="courses[<?php echo $i; ?>][subject_id]" value="<?php echo $courses[$i]['subject_id']; ?>"  /></td>
		<td><input class="pdl05 full" name="courses[<?php echo $i; ?>][supsubject_id]" value="<?php echo $courses[$i]['supsubject_id']; ?>"  /></td>		
		<td><?php echo $courses[$i]['crid']; ?></td>
		<td><?php echo $courses[$i]['section']; ?></td>
		<td>		
		<select class="vc100" onchange="rowVal(<?php echo $i; ?>,this.value);" >
			<option value="0" >Select</option>
			<?php foreach($teachers AS $sel): ?>
				<?php $ext = ($sel['id']==$sel['parent_id'])? 'UP#'.$sel['id']:'U#'.$sel['id'].'-P#'.$sel['parent_id']; ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$courses[$i]['tcid'])? 'selected':NULL; ?> >
					<?php echo $sel['name'].'-'.$ext; ?></option>
			<?php endforeach; ?>
		</select>						
		</td>
		<td><input class="pdl05 vc50" name="courses[<?php echo $i; ?>][tcid]" 
			ondblclick="xname('dbo','00_contacts',this.value);" value="<?php echo $courses[$i]['tcid']; ?>"  /></td>		
		<td><input class="pdl05 vc30" name="courses[<?php echo $i; ?>][crstype_id]" 
			value="<?php echo $courses[$i]['crstype_id']; ?>"  /></td>					
		<td><input class="pdl05 vc50" name="courses[<?php echo $i; ?>][code]" value="<?php echo $courses[$i]['code']; ?>"  /></td>
		<td><input class="pdl05" name="courses[<?php echo $i; ?>][label]" value="<?php echo $courses[$i]['label']; ?>"  /></td>
		<td>
			<select id="stat<?php echo $i; ?>" name="courses[<?php echo $i; ?>][is_active]" class="active full" >
				<option value="1" <?php echo ($courses[$i]['is_active'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_active'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>
		
		<td>
			<select name="courses[<?php echo $i; ?>][with_scores]" class="ws full" >
				<option value="1" <?php echo ($courses[$i]['with_scores'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['with_scores'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td>
			<select name="courses[<?php echo $i; ?>][is_kpup]" class="kpup full" >
				<option value="0" <?php echo (!$courses[$i]['is_kpup'])? 'selected':NULL; ?>  >-</option>
				<option value="1" <?php echo ($courses[$i]['is_kpup'])? 'selected':NULL; ?>  >Y</option>
			</select>
		</td>		

		<td><input class="wt pdl05 vc40" name="courses[<?php echo $i; ?>][course_weight]" 
			value="<?php echo $courses[$i]['course_weight']; ?>"  /></td>		
			
		<td>
			<select name="courses[<?php echo $i; ?>][is_displayed]" class="display full" >
				<option value="1" <?php echo ($courses[$i]['is_displayed'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_displayed'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td>
			<select name="courses[<?php echo $i; ?>][in_genave]" class="ga full" >
				<option value="1" <?php echo ($courses[$i]['in_genave'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['in_genave'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		
				
		<td>
			<select name="courses[<?php echo $i; ?>][affects_ranking]" class="rank full" >
				<option value="1" <?php echo ($courses[$i]['affects_ranking'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['affects_ranking'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

<td><input class="pos pdl05 vc30" name="courses[<?php echo $i; ?>][position]" value="<?php echo $courses[$i]['position']; ?>"  /></td>

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

		<td><input class="indent pos pdl05 vc30" name="courses[<?php echo $i; ?>][indent]" value="<?php echo $courses[$i]['indent']; ?>"  /></td>		
		<td><input class="sem pos pdl05 vc30" name="courses[<?php echo $i; ?>][semester]" value="<?php echo $courses[$i]['semester']; ?>"  /></td>		

		<td><input class="pdl05 vc100" name="courses[<?php echo $i; ?>][schedule]" value="<?php echo $courses[$i]['schedule']; ?>"  /></td>		
		
		
<td>
	<button class="vc60" ><a class="txt-black no-underline " 
		href='<?php echo URL."mis/editCourse/".$courses[$i]['course_id']."/$sy"; ?>'> Edit </a></button>
	<button class="vc60" ><a class="txt-black no-underline " 
		href='<?php echo URL."mis/delcrs/".$courses[$i]['course_id']; ?>'>Del</a></button>
</td>
		
	</tr>
	
	<input type="hidden" name="courses[<?php echo $i; ?>][id]" value="<?php echo $courses[$i]['course_id']; ?>"  >
	
<?php endfor; ?>

</table>





<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p class="hd" > <input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Save"   /> </p>

</form> <!-- save -->

<p> <?php $this->shovel('hdpdiv'); ?> </p>
<button onclick="tracepass();return false;" >Password</button>



<div class="ht100" >&nbsp;</div>

<!------------------------------------------------------------------------->

<!------------------------------------------------------------------------->







<script>

var hdpass 	= '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';


$(function(){
	$('#hdpdiv').hide();
	hd();

})	



function rowVal(i,tcid){
	$('input[name="courses['+i+'][tcid]"]').val(tcid);	
}	/* fxn */




</script>

<!------------------------------------------------------------------------->



