

<style>


.button{ font: 1em Arial; font-family: Arial,Helmet,Freesans,sans-serif; text-decoration: none;padding: 6px 8px;
	border-top: 1px solid #CCCCCC;border-right: 1px solid #333333;border-bottom: 1px solid #333333;border-left: 1px solid #CCCCCC;
	background-color: #f8f8f8;color: #080808; 
}


</style>

<?php 

// pr($data);
// pr($_SESSION['q']);

// pr($classroom);

$dbo=PDBO;
$dbg=VCPREFIX.$sy.US.DBG;
$dbcontacts="{$dbo}.00_contacts";
$dbclassrooms="{$dbg}.05_classrooms";


$is_shs=($classroom['level_id']>13)? true:false;
$sub = isset($_GET['sub'])? true:false;
$crname=$classroom['name'];
$srid=$_SESSION['srid'];
$is_mis=($srid==RMIS)? true:false;


$headrow = "<tr class='headrow'><th>#</th><th>Crs</th><th>Subj</th><th>Sup</th><th>Teacher</th><th>TCID</th><th>Type</th><th>Code</th><th>Label</th>
<th>Active</th><th>W/S</th><th>3-T</th><th>Wt</th><th>Disp</th><th>Genave</th><th>Affects<br />Rank</th><th>Pos</th><th>Aggre</th><th>Trns</th><th>Indent</th><th>Sem</th><th>Num</th><th>Sched</th><th></th></tr>
";

// pr($courses[0]);

// pr($editable);

?>



<h5>
	<span ondblclick="xxtracehd();" >Classroom Courses </span> (<?=$num_courses;?>) | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."matrix/grades/$crid/$sy"; ?>' >Matrix</a>
<?php if($_SESSION['srid']==RMIS): ?>	
	| <a href='<?php echo URL."crs/crid/$crid"; ?>' >Crid-Crs</a>
	| <a href='<?php echo URL."rosters/classroom/$crid"; ?>' >Roster</a>
	| <a href='<?php echo URL."classlists/classroom/$crid"; ?>' >Classlist</a>
	| <a href='<?php echo URL."mis/courses/$crid"; ?>' >MIS Crs</a>
	| <a href='<?php echo URL."purge/clscrs/$crid"; ?>' >Goto-Purger</a>
	<?php if($is_shs): ?>
		| <a href='<?php echo URL."crs/crid/$crid"; ?>' >CrsCrid</a>	
	<?php endif; ?>	
<?php endif; ?>		



	| <a href='<?php echo URL."classrooms/courses/$crid/$sy?sub"; ?>' >Get</a>
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>
</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" value="-" />
		<input type="submit" name="auto" value="Classrooms" onclick='getDataByTable(dbclassrooms,30);return false;' />
		
	</td></tr>
	
</table></p>

<div id="names" >names</div>

<!------ tracelogin ------------------------------------------------------->
<p> <?php $this->shovel('hdpdiv'); ?> </p>



<form method="POST" >	<!-- form add courses -->
<!------------------------------------------------------------------>

<div class="half" >
	<table class="table-fx gis-table-bordered" style="margin-bottom:10px;" >
		<tr>
			<td><?php echo $classroom['level'].' - '.$classroom['section']; ?></td>
			<td><?php echo "#".$classroom['acid']." - ".$classroom['adviser']; ?></td>
		</tr>
	</table>
</div>


<div class="fourth hd" id="names" > </div>


<?php  ?>


<table class="table-fx gis-table-bordered table-altrow">
<tr class='headrow'>
	<th>#</th>
	<th>Crs</th>
	<th>Sem
		<input id="isem" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('sem');" />						
	</th>		
	<th>Subj</th>
	<th>Sup<br />Subj<br />Prnt</th>
	<th>Teacher</th>
	<th >TCID
		<br />&nbsp;<br />	
		<input id="itcid" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('tcid');" />						
	</th>
	<th>Type</th>
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

	<th>Is<br />Num
		<input id="inum" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('num');" />						
	</th>		
	<th>Schedule</th>
	
</tr>
<!-- tbody -->
<?php for($i=0;$i<$num_courses;$i++): ?>

	<?php $active = ($courses[$i]['is_active'])? true:false;  ?>
	<tr id="tr<?php echo $i; ?>" class="<?php echo (!$active)? 'red':NULL; ?>"  >
		<td><?php echo $i+1; ?></td>
		<td><?php echo $courses[$i]['course_id']; ?></td>
	<td><input class="sem pdl05 vc30" name="courses[<?php echo $i; ?>][semester]" 
		id="sem<?php echo $i; ?>" value="<?php echo $courses[$i]['semester']; ?>"  /></td>
		
		<td><input ondblclick="xname('dbm','subjects',this.value);" id="sub<?php echo $i; ?>" class="pdl05 full" tabindex="1"
			name="courses[<?php echo $i; ?>][subject_id]" value="<?php echo $courses[$i]['subject_id']; ?>"  /></td>
		<td><input ondblclick="xname('dbm','subjects',this.value);" class="pdl05 full" tabindex="2" 
			id="supsub<?php echo $i; ?>" name="courses[<?php echo $i; ?>][supsubject_id]" 
			value="<?php echo $courses[$i]['supsubject_id']; ?>"  /></td>		
		<td>		
		<?php $substr_teac = substr($courses[$i]['teacher'],0,12); ?>	
		<input class="vc100 pdl05" id="part<?php echo $i; ?>" value="<?php echo $substr_teac; ?>"  />		

<?php if($editable): ?>	
	<input type="submit" name="auto" value="Filter" onclick="xgetEmployees(<?php echo $i; ?>);return false;" />
	<button><a class="btn<?php echo $i; ?>" 
		onclick="xeditCourse(<?php echo $i.','.$courses[$i]['course_id']; ?>);return false;" >Save</a></button>
<?php endif; ?>	
		
		</td>
		
		<td><input class="tcid pdl05 full" name="courses[<?php echo $i; ?>][tcid]" id="tcid<?php echo $i; ?>" tabindex="6"
			ondblclick="xname('dbo','00_contacts',this.value);" value="<?php echo $courses[$i]['tcid']; ?>"  /></td>		
			
		<td><input type="number" class="pdl05 full" name="courses[<?php echo $i; ?>][crstype_id]" id="ctype<?php echo $i; ?>" tabindex="8"
			value="<?php echo $courses[$i]['crstype_id']; ?>"  /></td>			

		<?php $crsname = $courses[$i]['level_code'].'-'.$courses[$i]['section_code'].'-'.$courses[$i]['subject_code']; ?>
		<td><input class="pdl05 vc50" name="courses[<?php echo $i; ?>][code]" id="code<?php echo $i; ?>" tabindex="10"
			value="<?php echo ($sub)? $courses[$i]['subject_code']:$courses[$i]['code']; ?>"  /></td>
		<td><input class="pdl05" name="courses[<?php echo $i; ?>][label]" id="label<?php echo $i; ?>" tabindex="12"
			value="<?php echo ($sub)? $courses[$i]['subject']:$courses[$i]['label']; ?>"  /></td>
		<td>
			<select id="actv<?php echo $i; ?>" name="courses[<?php echo $i; ?>][is_active]" class="active full" tabindex="14" > 
				<option value="1" <?php echo ($courses[$i]['is_active'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_active'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>
		
		<td>
			<select name="courses[<?php echo $i; ?>][with_scores]" class="ws full" id="ws<?php echo $i; ?>" tabindex="16" >
				<option value="1" <?php echo ($courses[$i]['with_scores'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['with_scores'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		


		<td><input class="wt pdl05 vc40" name="courses[<?php echo $i; ?>][course_weight]" id="wt<?php echo $i; ?>" tabindex="20"
			value="<?php echo $courses[$i]['course_weight']; ?>"  /></td>				
		
		<td>
			<select name="courses[<?php echo $i; ?>][is_displayed]" class="display full" id="disp<?php echo $i; ?>" tabindex="22" >
				<option value="1" <?php echo ($courses[$i]['is_displayed'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_displayed'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td>
			<select name="courses[<?php echo $i; ?>][in_genave]" class="ga full" id="genave<?php echo $i; ?>" tabindex="24" >
				<option value="1" <?php echo ($courses[$i]['in_genave'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['in_genave'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		
				
		<td>
			<select name="courses[<?php echo $i; ?>][affects_ranking]" class="rank full" id="ar<?php echo $i; ?>" tabindex="26" >
				<option value="1" <?php echo ($courses[$i]['affects_ranking'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['affects_ranking'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td><input id="pos<?php echo $i; ?>" class="pos pdl05 vc30" name="courses[<?php echo $i; ?>][position]" tabindex="28"
			value="<?php echo ($sub)? $courses[$i]['subpos']:$courses[$i]['position']; ?>"  /></td>		
		
		<td>
			<select name="courses[<?php echo $i; ?>][is_aggregate]" class="full" id="aggre<?php echo $i; ?>" tabindex="30" >
				<option value="1" <?php echo ($courses[$i]['is_aggregate'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_aggregate'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		
		
		<td>
			<select name="courses[<?php echo $i; ?>][is_transmuted]" class="full" id="trns<?php echo $i; ?>" tabindex="32" >
				<option value="1" <?php echo ($courses[$i]['is_transmuted'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_transmuted'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td><input class="indent pdl05 vc30" name="courses[<?php echo $i; ?>][indent]" tabindex="34"
			id="indent<?php echo $i; ?>" value="<?php echo $courses[$i]['indent']; ?>"  /></td>		

	<td>
		<select name="courses[<?php echo $i; ?>][is_num]" class="num full" id="num<?php echo $i; ?>" tabindex="36" >
			<option value="1" <?php echo ($courses[$i]['is_num'])? 'selected':NULL; ?>  >Y</option>
			<option value="0" <?php echo (!$courses[$i]['is_num'])? 'selected':NULL; ?>  >-</option>
		</select>
	</td>		
	
	<td><input id="sched<?php echo $i; ?>" class="pdl05 vc100" name="courses[<?php echo $i; ?>][schedule]" tabindex="38"
		value="<?php echo $courses[$i]['schedule']; ?>"  />
<?php if($editable): ?>		
<button><a class="btn<?php echo $i; ?>" onclick="xeditCourse(<?php echo $i.','.$courses[$i]['course_id']; ?>);return false;" >Save</a></button>

<?php if($is_mis): ?>
	<a class="button" href="<?php echo URL.'courses/edit/'.$courses[$i]['course_id']; ?>" >Edit</a>
<?php endif; ?>

<?php endif; ?>			
		
	</td>		
		
	</tr>
	
	<input type="hidden" name="courses[<?php echo $i; ?>][id]" value="<?php echo $courses[$i]['course_id']; ?>"  >
	
<?php endfor; ?>

</table>

<p class="hd" ><input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Save All"   /> </p>
</form> <!-- save -->

</table>








<div class="ht100" >&nbsp;</div>

<!------------------------------------------------------------------------->







<script>

const hdpass 	= "<?php echo HDPASS; ?>";
const gurl = "http://<?php echo GURL; ?>";
const sy	 = "<?php echo $sy; ?>";
const home = "<?php echo $home; ?>";
const crname = "<?php echo $crname; ?>";

const dbcontacts = "<?php echo $dbcontacts; ?>";
const dbclassrooms = "<?php echo $dbclassrooms; ?>";
const limit=20;


$(function(){	
	$('#hdpdiv').hide();
	hd();
	nextViaEnter();
	selectFocused();
	$('#names').hide();
	$('html').live('click',function(){  $('#names').hide();  });

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



function xgetEmployees(rid,limits=20){
	var part = $('#part'+rid).val();	
	var vurl = gurl+'/ajax/xgetNonstudents.php';	
	var task = "xgetNonstudentsByPart";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,				
		async: true,
		success: function(s) {
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			// console.log(s);
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact('+s[i].id+','+rid+');return false;" >'+s[i].code+'</span> - '+(i+1)+'-'+s[i].name+' - R'+s[i].role_id+'-P'+s[i].parent_id+'-U'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}




function showAggre(i){
	$('.hd'+i).show();
}	/* fxn */


function rowVal(i,tcid){
	$('input[name="courses['+i+'][tcid]"]').val(tcid);	
	
	
}	/* fxn */


function redirContact(pcid,rid){	
	$('input[name="courses['+rid+'][tcid]"]').val(pcid);		
	var vurl 	= gurl + "/ajax/xgetContacts.php";	
	var task	= "xgetContactByUcid";	
	$.ajax({
	  type: 'POST',dataType: "json",	  
	  url: vurl,data: "task="+task+"&ucid="+pcid,
	  success:function(s){ $('#part'+rid).val(s.name) } 
   });				
	
	
}	/* fxn */


function xeditCourse(i,crsid){
	$('.btn'+i).hide();	

	var vurl 	= gurl + '/ajax/xcourses.php';	
	var task	= "xeditCourse";
	var ws = $('#ws'+i).val();
	var code = $('#code'+i).val();
	var label = $('#label'+i).val();
	var tcid = $('#tcid'+i).val();
	var sub = $('#sub'+i).val();
	var supsub = $('#supsub'+i).val();
	var actv = $('#actv'+i).val();
	var disp = $('#disp'+i).val();
	var trns = $('#trns'+i).val();
	var indent = $('#indent'+i).val();
	var sem = $('#sem'+i).val();
	var ar = $('#ar'+i).val();
	var num = $('#num'+i).val();	
	var wt = $('#wt'+i).val();	
	var sched = $('#sched'+i).val();	
	var ctype = $('#ctype'+i).val();	
	
	var pos = $('#pos'+i).val();	
	var aggre = $('#aggre'+i).val();	
	
	var pdata = 'task='+task+'&with_scores='+ws+'&code='+code+'&label='+label+'&tcid='+tcid;
	pdata+='&subject_id='+sub+'&supsubject_id='+supsub+'&schedule='+sched+'&crstype_id='+ctype+'&crname='+crname;
	pdata+='&course_id='+crsid+'&is_active='+actv+'&is_displayed='+disp+'&is_transmuted='+trns+'&indent='+indent+'&semester='+sem+'&affects_ranking='+ar+'&is_num='+num+'&course_weight='+wt+'&position='+pos+'&is_aggregate='+aggre;	
	
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){}  });				
	
	
}	/* fxn */


function axnFilter(id){
	var url=gurl+"/classrooms/courses/"+id+"/"+sy;
	window.location=url;
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters_contacts.js"; ?>' ></script>


<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
