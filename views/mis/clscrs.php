<?php 

// pr($data);
// pr($_SESSION['q']);

$sub = isset($_GET['sub'])? true:false;


$headrow = "<tr class='headrow'><th>#</th><th>Crs</th><th>Subj</th><th>Sup</th><th>Teacher</th><th>TCID</th><th>Type</th><th>Name</th><th>Code</th><th>Label</th>
<th>Active</th><th>W/S</th><th>3-T</th><th>Wt</th><th>Disp</th><th>Genave</th><th>Affects<br />Rank</th><th>Pos</th><th>Aggre</th><th>Trns</th><th>Indent</th><th>Sem</th><th>Num</th><th>Sched</th><th></th></tr>
";

// pr($courses[0]);
?>



<h5>
	<span ondblclick="xxtracehd();" >Class Courses </span> | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."mis/courses/$crid/$sy"; ?>' >Manage</a>
	| <a href='<?php echo URL."matrix/grades/$crid/$sy"; ?>' >Matrix</a>
	| <a href='<?php echo URL."mis/clscrs/$crid/$sy?sub"; ?>' >Get</a>
	| <a href='<?php echo URL."gset/courses/".$classroom['level_id']."/$sy"; ?>' >Batch</a>
	| <a href='<?php echo URL."mis/lvlcrs/".$classroom['level_id']."/$sy"; ?>' >Level</a>
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>
	
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>
	
</h5>


<form method="POST" >	<!-- form add courses -->
<!------------------------------------------------------------------>

<div class="third" >
<table class="table-fx gis-table-bordered">
<tr><th class="headrow white" >Classroom</th><td><?php echo $classroom['level'].' - '.$classroom['section']; ?></td></tr>
<tr><th class="headrow white" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
</table> <br />

</div>

<div class="half" >
<table class="screen gis-table-bordered table-fx">

	<?php 
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'clscrs';
		// pr($d);
		$this->shovel('redirect_classroom',$d); 	
	?>
</table>

</div>


<div class="fourth hd" id="names" > </div>


<?php  ?>


<table class="table-fx gis-table-bordered table-altrow">
<tr class='headrow'>
	<th>#</th>
	<th>Crs<br />Edit</th>
	<th>Subj</th>
	<th>Sup<br />Subj<br />Prnt</th>
	<th>Teacher</th>
	<th >TCID
		<br />&nbsp;<br />	
		<input id="itcid" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('tcid');" />						
	</th>
	<th>Type</th>
	<th class="" >Name</th>
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
	<th>Is<br />Num
		<input id="inum" class="full" >
		<br /> <input type="button" value="All" onclick="populateColumn('num');" />						
	</th>		
	<th>Schedule</th>
	<th>&nbsp;</th>
	
</tr>
<!-- tbody -->
<?php for($i=0;$i<$num_courses;$i++): ?>

<?php if($i%8){} else { echo $headrow; } ?>

	<?php $active = ($courses[$i]['is_active'])? true:false;  ?>
	<tr id="tr<?php echo $i; ?>" class="<?php echo (!$active)? 'red':NULL; ?>"  >
		<td><?php echo $i+1; ?></td>
		<td><a href='<?php echo URL."mis/editCourse/".$courses[$i]['course_id']; ?>' ><?php echo $courses[$i]['course_id']; ?></a>
			<button><a class="btn<?php echo $i; ?>" onclick="xeditCourse(<?php echo $i.','.$courses[$i]['course_id']; ?>);return false;" >Save</a></button>
		</td>
		<td><input ondblclick="xname('dbm','subjects',this.value);" id="sub<?php echo $i; ?>" class="pdl05 full" 
			name="courses[<?php echo $i; ?>][subject_id]" value="<?php echo $courses[$i]['subject_id']; ?>"  /></td>
		<td><input ondblclick="xname('dbm','subjects',this.value);" class="pdl05 full" 
			id="supsub<?php echo $i; ?>" name="courses[<?php echo $i; ?>][supsubject_id]" 
			value="<?php echo $courses[$i]['supsubject_id']; ?>"  /></td>		
		<td>		
		<?php $substr_teac = substr($courses[$i]['teacher'],0,12); ?>	
		<input class="vc100 pdl05" id="part<?php echo $i; ?>" value="<?php echo $substr_teac; ?>" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPartRow(<?php echo $i; ?>);return false;" />				
		
		</td>
		<td><input class="tcid pdl05 full" name="courses[<?php echo $i; ?>][tcid]" id="tcid<?php echo $i; ?>"
			ondblclick="xname('dbo','00_contacts',this.value);" value="<?php echo $courses[$i]['tcid']; ?>"  /></td>		
		<td><input class="pdl05 full" name="courses[<?php echo $i; ?>][crstype_id]" id="ctype<?php echo $i; ?>"
			value="<?php echo $courses[$i]['crstype_id']; ?>"  /></td>			

		<?php $crsname = $courses[$i]['level_code'].'-'.$courses[$i]['section_code'].'-'.$courses[$i]['subject_code']; ?>
		<td><input class="pdl05" name="courses[<?php echo $i; ?>][name]" id="name<?php echo $i; ?>"
			value="<?php echo ($sub)? $crsname:$courses[$i]['name']; ?>"  /></td>			
		<td><input class="pdl05 vc50" name="courses[<?php echo $i; ?>][code]" id="code<?php echo $i; ?>"
			value="<?php echo ($sub)? $courses[$i]['subject_code']:$courses[$i]['code']; ?>"  /></td>
		<td><input class="pdl05" name="courses[<?php echo $i; ?>][label]" id="label<?php echo $i; ?>"
			value="<?php echo ($sub)? $courses[$i]['subject']:$courses[$i]['label']; ?>"  /></td>
		<td>
			<select id="actv<?php echo $i; ?>" name="courses[<?php echo $i; ?>][is_active]" class="active full" >
				<option value="1" <?php echo ($courses[$i]['is_active'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_active'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>
		
		<td>
			<select name="courses[<?php echo $i; ?>][with_scores]" class="ws full" id="ws<?php echo $i; ?>" >
				<option value="1" <?php echo ($courses[$i]['with_scores'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['with_scores'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td>
			<select name="courses[<?php echo $i; ?>][is_kpup]" class="kpup full" id="kpup<?php echo $i; ?>" >
				<option value="1" <?php echo ($courses[$i]['is_kpup'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_kpup'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td><input class="wt pdl05 vc40" name="courses[<?php echo $i; ?>][course_weight]" id="wt<?php echo $i; ?>"
			value="<?php echo $courses[$i]['course_weight']; ?>"  /></td>				
		
		<td>
			<select name="courses[<?php echo $i; ?>][is_displayed]" class="display full" id="disp<?php echo $i; ?>" >
				<option value="1" <?php echo ($courses[$i]['is_displayed'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_displayed'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td>
			<select name="courses[<?php echo $i; ?>][in_genave]" class="ga full" id="genave<?php echo $i; ?>" >
				<option value="1" <?php echo ($courses[$i]['in_genave'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['in_genave'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		
				
		<td>
			<select name="courses[<?php echo $i; ?>][affects_ranking]" class="rank full" id="ar<?php echo $i; ?>" >
				<option value="1" <?php echo ($courses[$i]['affects_ranking'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['affects_ranking'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td><input id="pos<?php echo $i; ?>" class="pos pdl05 vc30" name="courses[<?php echo $i; ?>][position]" 
			value="<?php echo ($sub)? $courses[$i]['subpos']:$courses[$i]['position']; ?>"  /></td>		
		
		<td>
			<select name="courses[<?php echo $i; ?>][is_aggregate]" class="full" id="aggre<?php echo $i; ?>" >
				<option value="1" <?php echo ($courses[$i]['is_aggregate'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_aggregate'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		
		
		<td>
			<select name="courses[<?php echo $i; ?>][is_transmuted]" class="full" id="trns<?php echo $i; ?>" >
				<option value="1" <?php echo ($courses[$i]['is_transmuted'])? 'selected':NULL; ?>  >Y</option>
				<option value="0" <?php echo (!$courses[$i]['is_transmuted'])? 'selected':NULL; ?>  >-</option>
			</select>
		</td>		

		<td><input class="indent pdl05 vc30" name="courses[<?php echo $i; ?>][indent]" 
			id="indent<?php echo $i; ?>" value="<?php echo $courses[$i]['indent']; ?>"  /></td>		
	<td><input class="sem pdl05 vc30" name="courses[<?php echo $i; ?>][semester]" 
		id="sem<?php echo $i; ?>" value="<?php echo $courses[$i]['semester']; ?>"  /></td>

	<td>
		<select name="courses[<?php echo $i; ?>][is_num]" class="num full" id="num<?php echo $i; ?>" >
			<option value="1" <?php echo ($courses[$i]['is_num'])? 'selected':NULL; ?>  >Y</option>
			<option value="0" <?php echo (!$courses[$i]['is_num'])? 'selected':NULL; ?>  >-</option>
		</select>
	</td>		
	
	<td><input id="sched<?php echo $i; ?>" class="pdl05 vc100" name="courses[<?php echo $i; ?>][schedule]" 
		value="<?php echo $courses[$i]['schedule']; ?>"  /></td>		
		
		
<td>
	<button class="vc60" ><a class="txt-black no-underline " 
		href='<?php echo URL."mis/editCourse/".$courses[$i]['course_id']."/$sy"; ?>'> Edit </a></button>
	<button class="vc60" ><a class="txt-black no-underline " 
		href='<?php echo URL."mis/delcrs/".$courses[$i]['course_id']; ?>'>Del</a></button>
	<button class="vc60" ><a class="txt-black no-underline " 
		href='<?php echo URL."mgt/pass/".$courses[$i]['tcid']; ?>'>Pass</a></button>
	<button><a class="btn<?php echo $i; ?>" onclick="xeditCourse(<?php echo $i.','.$courses[$i]['course_id']; ?>);return false;" >Save</a></button>
</td>
		
	</tr>
	
	<input type="hidden" name="courses[<?php echo $i; ?>][id]" value="<?php echo $courses[$i]['course_id']; ?>"  >
	
<?php endfor; ?>

</table>


<p class="" > <input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Save"   /> </p>

</form> <!-- save -->

</table>


<!------ smartpaste ------------------------------------------------------->

<div class="clear" ></div>
<div class="clipboard" >
<p>
<select id="classbox" >
	<option value="pos" >Pos</option>
	<option value="sched" >Sched</option>
</select>
</p>
<?php $d['width'] = '40'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>




<!------ tracelogin ------------------------------------------------------->
<p> <?php $this->shovel('hdpdiv'); ?> </p>




<div class="ht100" >&nbsp;</div>

<!------------------------------------------------------------------------->







<script>

var hdpass 	= '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';


$(function(){
	$('#hdpdiv').hide();
	hd();
	itago('clipboard');
	$('html').live('click',function(){
		$('#names').hide();
	});

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

	
}	/* fxn */


function showAggre(i){
	$('.hd'+i).show();
}	/* fxn */


function rowVal(i,tcid){
	$('input[name="courses['+i+'][tcid]"]').val(tcid);	
}	/* fxn */


function redirContact(pcid,rid){	
	$('input[name="courses['+rid+'][tcid]"]').val(pcid);		
}	/* fxn */


function xeditCourse(i,crsid){
	$('.btn'+i).hide();	

	var vurl 	= gurl + '/ajax/xcourses.php';	
	var task	= "xeditCourse";
	var ws = $('#ws'+i).val();
	var name = $('#name'+i).val();
	var code = $('#code'+i).val();
	var label = $('#label'+i).val();
	var tcid = $('#tcid'+i).val();
	var sub = $('#sub'+i).val();
	var supsub = $('#supsub'+i).val();
	var actv = $('#actv'+i).val();
	var kpup = $('#kpup'+i).val();
	var disp = $('#disp'+i).val();
	var trns = $('#trns'+i).val();
	var sem = $('#sem'+i).val();
	var ar = $('#ar'+i).val();
	var num = $('#num'+i).val();	
	var wt = $('#wt'+i).val();	
	var indent = $('#indent'+i).val();	
	
	var pos = $('#pos'+i).val();	
	var aggre = $('#aggre'+i).val();	
	var sched = $('#sched'+i).val();	
	
	var pdata = 'task='+task+'&with_scores='+ws+'&name='+name+'&code='+code+'&label='+label+'&tcid='+tcid;
	pdata+='&subject_id='+sub+'&supsubject_id='+supsub+'&schedule='+sched+'&indent='+indent;
	pdata+='&course_id='+crsid+'&is_active='+actv+'&is_kpup='+kpup+'&is_displayed='+disp+'&is_transmuted='+trns;
	pdata+='&semester='+sem+'&affects_ranking='+ar+'&is_num='+num+'&course_weight='+wt+'&position='+pos+'&is_aggregate='+aggre;	
	// alert(pdata);
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){} 
   });				
	
	

}	/* fxn */

</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>


