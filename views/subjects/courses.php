<?php 

// pr($data);

$sy = $_SESSION['sy'];
$next_year   = $sy + 1;

$get = isset($_GET['get'])? true:false;	

?>


<h5>
	Subject Courses -
	<?php echo $subject['name'].' ('.$subject['position'].')'; ?> 
	<a href="<?php echo URL.$home; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'subjects'; ?>">Subjects</a>
	| <a href="<?php echo URL.'subjects/courses/'.$subject_id.'?get'; ?>">GET</a>
	| <a href="<?php echo URL.'subjects/byLevels'; ?>" >Subj-Levels</a>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
	
</h5>


<form method="POST" >	<!-- form1 edit courses -->
<table class="table-fx gis-table-bordered">
<thead>
<tr class='headrow'>
	<th>#</th>
	<th>CrsID<br />Edit</th>
	<th>Classroom</th>
	<th>Teacher</th>
	<th class="vc50" >Subj
		<input id="isub" class="pdl05 full" >
		<br /> <input type="button" value="All" onclick="populateColumn('sub');" />						
	</th>
	<th class="vc50" >Super
		<input id="isup" class="pdl05 full" >
		<br /> <input type="button" value="All" onclick="populateColumn('sup');" />						
	</th>
	<th class="vc100" >Name
		<input id="iname" class="pdl05 full" >
		<br /> <input type="button" value="All" onclick="populateColumn('name');" />						
	</th>	
	<th class="vc50" >Code
		<input id="icode" class="pdl05 full" >
		<br /> <input type="button" value="All" onclick="populateColumn('code');" />						
	</th>
	<th>Label
		<input id="ilbl" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('lbl');" />						
	</th>	
	
	<th>
		Actv
		<br /><input id="iactv" class="center " type="number" min=0 max=1 value=1 />
		<br /> <input type="button" value="All" onclick="populateColumn('actv');" />				
	</th>	
	<th>
		W/S
		<br /><input id="iws" class="center " type="number" min=0 max=1 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('ws');" />				
	</th>
	<th>
		3-Tier
		<br /><input id="ikpup" class="center " type="number" min=0 max=1 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('kpup');" />				
	</th>	
	<th>
		Wt
		<br /><input id="iwt" class="center vc50"  />
		<br /> <input type="button" value="All" onclick="populateColumn('wt');" />				
	</th>	

	<th>
		Display
		<br /><input id="idisplay" class="center vc50" type="number" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('display');" />				
	</th>		
	
	<th>
		Genave
		<br /><input id="igenave" class="center vc50" type="number" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('genave');" />				
	</th>	
	
	<th>
		Af/Rnk
		<br /><input id="iar" class="center vc50" type="number" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('ar');" />				
	</th>	
	<th class="vc50" >Pos
		<input id="ipos" class="center full" >
		<br /> <input type="button" value="All" onclick="populateColumn('pos');" />						
	</th>

	<th>
		Aggre
		<br /><input id="iaggre" class="center vc50" type="number" value="0" />
		<br /> <input type="button" value="All" onclick="populateColumn('aggre');" />				
	</th>		
	<th>
		Trns
		<br /><input id="itrns" class="center vc50" type="number" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('trns');" />				
	</th>		
	
	<th class="vc50" >Indent
		<input id="iindent" class="center full" >
		<br /> <input type="button" value="All" onclick="populateColumn('indent');" />						
	</th>
	<th>
		Sem
		<br /><input id="isem" class="center vc50" type="number" value="0" />
		<br /> <input type="button" value="All" onclick="populateColumn('sem');" />				
	</th>		
	<th>
		Num
		<br /><input id="inum" class="center vc50" type="number" value="0" />
		<br /> <input type="button" value="All" onclick="populateColumn('num');" />				
	</th>			
	<th>
		Type
		<br /><input id="ictype" class="center vc50" type="number" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('ctype');" />				
	</th>		

	
	<th class="center" >Manage</th>
</tr>
</thead>
<tbody>
<?php for($i=0;$i<$num_subcourses;$i++): ?>
<input type="hidden" name="subcourses[<?php echo $i; ?>][course_id]" 
				value="<?php echo $subcourses[$i]['id']; ?>"  />
	<tr class="<?php echo ($subcourses[$i]['is_active'])? NULL:'red'; ?>" >
		<td><?php echo $i+1; ?></td>	
		<td><a href='<?php echo URL."courses/edit/".$subcourses[$i]['id']; ?>' ><?php echo $subcourses[$i]['id']; ?></a></td>
		<td><?php echo $subcourses[$i]['classroom']; ?></td>
		<td>
			<select id="teac<?php echo $i; ?>" class="teac" name="subcourses[<?php echo $i; ?>][tcid]" >
				<option value="0" >Choose One</option>
				<?php foreach($teachers AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$subcourses[$i]['tcid'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select>	
		</td>	
		
<td><input class="sub vc50 center" name="subcourses[<?php echo $i; ?>][subject_id]" 
	value="<?php echo $subcourses[$i]['subject_id']; ?>" /></td>				
	
<td><input class="sup vc50 center" name="subcourses[<?php echo $i; ?>][supsubject_id]" 
	value="<?php echo $subcourses[$i]['supsubject_id']; ?>" /></td>				

<td><input class="pdl05 vc100 name" name="subcourses[<?php echo $i; ?>][name]" 
	value="<?php echo ($get)? $subcourses[$i]['classroom'].'-'.$subcourses[$i]['code']:$subcourses[$i]['name']; ?>" /></td>
	
<td><input class="pdl05 vc60 code" maxlength="6" name="subcourses[<?php echo $i; ?>][code]" 
	value="<?php echo $subcourses[$i]['code']; ?>" /></td>
<td><input class="pdl05 vc120 lbl" name="subcourses[<?php echo $i; ?>][label]" value="<?php echo $subcourses[$i]['label']; ?>" /></td>
		
<td><input class="vc50 center actv" name="subcourses[<?php echo $i; ?>][is_active]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['is_active']; ?>" /></td>	
	
<td><input class="vc50 center ws" name="subcourses[<?php echo $i; ?>][with_scores]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['with_scores']; ?>" /></td>	
		
<td><input class="vc50 center kpup" name="subcourses[<?php echo $i; ?>][is_kpup]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['is_kpup']; ?>" /></td>			
		
<td><input class="wt vc50 center" name="subcourses[<?php echo $i; ?>][course_weight]" 
	value="<?php echo $subcourses[$i]['course_weight']; ?>" /></td>		
	
<td><input class="vc50 center display" name="subcourses[<?php echo $i; ?>][is_displayed]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['is_displayed']; ?>" /></td>	
	
<td><input class="vc50 center genave" name="subcourses[<?php echo $i; ?>][in_genave]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['in_genave']; ?>" /></td>	
	
<td><input class="vc50 center ar" name="subcourses[<?php echo $i; ?>][affects_ranking]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['affects_ranking']; ?>" /></td>			
	
<td><input class="pos vc50 center" type="number" name="subcourses[<?php echo $i; ?>][position]" 
	value="<?php echo $subcourses[$i]['position']; ?>" /></td>		
	
		
<td><input class="vc50 center aggre" name="subcourses[<?php echo $i; ?>][is_aggregate]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['is_aggregate']; ?>" /></td>	
	
<td><input class="vc50 center trns" name="subcourses[<?php echo $i; ?>][is_transmuted]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['is_transmuted']; ?>" /></td>			

<td><input class="indent vc50 center" type="number" name="subcourses[<?php echo $i; ?>][indent]" 
	value="<?php echo $subcourses[$i]['indent']; ?>" /></td>		

<td><input class="sem vc50 center" name="subcourses[<?php echo $i; ?>][semester]" 
	type="number" min=0 max=2 value="<?php echo $subcourses[$i]['semester']; ?>" /></td>		
	
<td><input class="num vc50 center" name="subcourses[<?php echo $i; ?>][is_num]" 
	type="number" min=0 max=1 value="<?php echo $subcourses[$i]['is_num']; ?>" /></td>		
	
<td><input class="ctype vc50 center" name="subcourses[<?php echo $i; ?>][crstype_id]" 
	type="number" min=0 max=5 value="<?php echo $subcourses[$i]['crstype_id']; ?>" /></td>

<td><a href="<?php echo URL.'courses/edit/'.$subcourses[$i]['id']; ?>">Edit</a></td>
<td><?php echo $i+1; ?></td>
		
		
		
	</tr>	
<?php endfor; ?>

</tbody>
</table>

<p>
	<!-- better ajax xeditBtn -->
	<input onclick="return confirm('Dangerous! Proceed?');" type="submit" name="save" value="Save All" /> &nbsp; 
	<button><a class="no-underline" href="<?php echo URL.'mis/subjects'; ?>">Cancel</a></button>
</p>


</form>
<br />


<!----------------------------------------------------------------------------------------------------------------->
<hr/>
<!------------------------------------------------------------------>
<form method="POST" >	<!-- form2 add courses -->

<h5> Add Classes </h5>
<h4>General Attributes</h4>
<table class="gis-table-bordered table-fx" >
<tr><td>Subject ID</td><td> <input class="vc200 pdl05" type="text" name="subject_id" value="<?php echo $subject['id']; ?>" readonly /> </td></tr>
<tr><td>CODE</td><td> <input class="vc200 pdl05" type="text" name="subcode" value="<?php echo $subject['code']; ?>" readonly /> </td></tr>
<tr><td>Label</td><td> <input class="vc200 pdl05" type="text" name="label" value="<?php echo $subject['name']; ?>" /> </td></tr>
<tr><td>Is Aggregate</td><td><select class="vc200 pdl05" name="is_aggregate"  > <option value="0"  >No</option> <option value="1"  >Yes</option> </select></td></tr>

<tr><td>Parent Subject</td><td> 
	<select class="vc200" name="supsubject_id"  >
		<option value="0">None</option>
		<?php	foreach($subjects as $sel): ?><option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>
</td></tr>

<tr><td>Weight % </td><td> <input class="pdl05 vc200" type="text" name="course_weight" value="0" /> </td></tr>

<tr><td>CrsType</td><td> 
	<select class="vc200" name="crstype_id"  >
		<?php	foreach($crstypes as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$subject['crstype_id'])? 'selected':null; ?>   ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>
</td></tr>


</table>

<!------------------------------------------------------------------>

<h4>Specific Attributes
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h4>
<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>	
	<th>Classroom</th>
	<th class="vc50" >Level</th>
	<th class="vc50" >Section</th>
	<th>Teacher</th>
	<th>Position</th>
</tr>

<tbody>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select onchange="lvlsxn(this.value,<?php echo $i; ?>)" id="crid<?php echo $i; ?>" 
			name="subcourses[<?php echo $i; ?>][crid]" >
			<option>Choose One</option>
			<?php foreach($classrooms AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>
	<td><input id="lvl<?php echo $i; ?>" class="vc50" type="text" name="subcourses[<?php echo $i; ?>][lvlcode]" readonly /></td>
	<td><input id="sxn<?php echo $i; ?>" class="vc50" type="text" name="subcourses[<?php echo $i; ?>][sxncode]" readonly /></td>
		
	<td>
		<select name="subcourses[<?php echo $i; ?>][tcid]" id="teac<?php echo $i; ?>" >
			<?php	foreach($teachers as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>
	
	<td><input class="vc50 center" type="text" name="subcourses[<?php echo $i; ?>][position]" value="<?php echo $subject['position']; ?>"  /></td>
	
</tr>


<?php endfor; ?>			
</tbody></table>

<p><input type="submit" name="add" value="Add" /> &nbsp; <a href="<?php echo URL.'mis/subjects'; ?>"><button>Cancel</button></a></p>

</form> <!-- add -->



<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="crid" >Classroom</option>
	<option value="lvl" >Level</option>
	<option value="sxn" >Section</option>
	<option value="teac" >Teacher</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>

<!----------------------------------------------------------------------------------------------------------------->

<!-- form3 numrows -->
<?php $this->shovel('numrows'); ?>

<!------------------------------------------------------------------------------------------------------------------------>

<script>

var gurl = "http://<?php echo GURL; ?>";


$(function(){
	itago('clipboard');


});


function lvlsxn(crid,i){
	
	var vurl 	= gurl + '/mis/getLevelSection';	
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crid='+crid,				
		async: true,
		success: function(s) { 			
			// alert(s.lvlcode);
			$('#lvl'+i).val(s.lvlcode);
			$('#sxn'+i).val(s.sxncode);
		}		  
    });				

	
}	// fxn



</script>
