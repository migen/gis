<?php 

	// pr($data);
	// pr($subjects[0]);
	// pr($_SESSION['q']);

$headrow = "<tr class='headrow'><th>Subj#</th><th>Crs</th><th>Sup</th><th>Subject</th><th>Code</th><th>CType</th><th>Actv</th><th>W/S</th>
<th>3-T</th><th>Wt</th><th>Disp</th><th>Genave</th><th>Affects<br />Rank</th><th>Pos</th><th>Aggre</th><th>Trns</th><th>Indent</th><th>Sem</th><th>Num</th><th>Save</th><th class='hd' ></th></tr>
";

?>

<!------------------------------------------------>

<h5>
	<span class="u" ondblclick="tracehd();" >Subjects</span>
	(<?php echo $subject_count; ?>)
	| <a href="<?php echo URL.'mis'; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>" >Setup</a>
	| <a onclick="return confirm('Sure?');" href="<?php echo URL.'misc/renameAllCourses'; ?>" >Rename All</a>	
	| <a href="<?php echo URL.'mis/propagateSubjects'; ?>" >Propagate</a>	
	| <a href="<?php echo URL.'gset/courses'; ?>" >Courses</a>
</h5>

<!------------------------------------------------>

<form method="POST"  >
<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>Subj#</th>
	<th>CRS</th>
	<th>Sup<br />Subj<br />Prnt</th>
	<th class="vc250" >Name</th>
	<th>Code</th>
	<th>Ctype<br />1(acad)<br />2-Tr<br />5-Cond<br />
		<input id="icty" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('cty');" >				
	</th>
	
	<th>Is<br />Actv<br />
		<input id="iactv" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('actv');" >				
	</th>			
	<th>With<br />Scores<br />
		<input id="iws" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('ws');" >				
	</th>	
	<th>Is<br />3Tier<br />
		<input id="ikpup" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('kpup');" >				
	</th>		
	<th>Wt</th>
	<th>On<br />Disp<br />layed<br />
		<input id="idisp" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('disp');" >				
	</th>				
	<th>In<br />Genave<br />
		<input id="iiga" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('iga');" >				
	</th>		
	<th>Af<br />Rank<br />
		<input id="iar" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('ar');" >				
	</th>	
	<th>Pos</th>
	<th>Is<br />Aggre<br />
		<input id="iaggre" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('aggre');" >				
	</th>				
	<th>Is<br />Trans<br />
		<input id="itrans" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('trans');" >				
	</th>			
	<th>Indent</th>
	<th>Sem<br />
		<input id="isem" class="vc40 center" value="0" />
		<br /> <input type="button" value="All" onclick="populateColumn('sem');" >				
	</th>				
	<th>Is<br />Num<br />/ DG<br />
		<input id="inum" class="vc40 center" value="1" />
		<br /> <input type="button" value="All" onclick="populateColumn('num');" >				
	</th>				
	
	<th>Save</th>
	<th class="hd" >DEL</th>
</tr>
<!----------------------- data ------------------------------------------------------------>
<?php for($i=0;$i<$subject_count;$i++): ?>
	
	<?php if($i%12){} else { echo $headrow; } ?>

	<input type="hidden" name="sub[<?php echo $i; ?>][subject_id]" value="<?php echo $subjects[$i]['subject_id']; ?>"  />

	<tr>
		<td><?php echo $subjects[$i]['subject_id']; ?></td>

		<td class="<?php echo ($subjects[$i]['is_active'])? null:'bg-salmon'; ?>" ><a 
			href="<?php echo URL.'subjects/courses/'.$subjects[$i]['id']; ?>">GO</a></td>		
		<td><input class="full pdl05 " name="sub[<?php echo $i; ?>][parent_id]"  
			id="prnt<?php echo $i; ?>" value="<?php echo $subjects[$i]['parent_id']; ?>"  /></td>			
		<td><input class="vc150 pdl05 " name="sub[<?php echo $i; ?>][subject]"  
			id="name<?php echo $i; ?>" value="<?php echo $subjects[$i]['name']; ?>"  /></td>
		<td><input class="vc70 pdl05 " name="sub[<?php echo $i; ?>][subject_code]"  
			maxlength="4" id="code<?php echo $i; ?>" value="<?php echo $subjects[$i]['code']; ?>"  /></td>
		<td><input class="center cty vc40" id="cty<?php echo $i; ?>" name="sub[<?php echo $i; ?>][crstype_id]"
			value="<?php echo $subjects[$i]['crstype_id'] ?>" /></td>		
		<td>
			<select class='actv vc50' id="actv<?php echo $i; ?>" name="sub[<?php echo $i; ?>][is_active]"  >
				<option value="1" <?php echo ($subjects[$i]['is_active']==1)? 'selected':null; ?> >Y</option>
				<option value="0" <?php echo ($subjects[$i]['is_active']!=1)? 'selected':null; ?> >N</option>
			</select>			
		</td>				
		<td><input class="center ws vc40" id="ws<?php echo $i; ?>" name="sub[<?php echo $i; ?>][with_scores]"
			value="<?php echo $subjects[$i]['with_scores'] ?>" /></td>
		<td><input class="center kpup vc40" id="kpup<?php echo $i; ?>" name="sub[<?php echo $i; ?>][is_kpup]"
			value="<?php echo $subjects[$i]['is_kpup'] ?>" /></td>
		<td><input class="center wt vc40" id="wt<?php echo $i; ?>" name="sub[<?php echo $i; ?>][weight]"
			value="<?php echo $subjects[$i]['weight'] ?>" /></td>
		<td><input class="center disp vc40" id="disp<?php echo $i; ?>" name="sub[<?php echo $i; ?>][is_displayed]"
			value="<?php echo $subjects[$i]['is_displayed'] ?>" /></td>
		<td><input class="center iga vc40" id="iga<?php echo $i; ?>" name="sub[<?php echo $i; ?>][in_genave]"
			value="<?php echo $subjects[$i]['in_genave'] ?>" /></td>
		<td><input class="center ar vc40" id="ar<?php echo $i; ?>" name="sub[<?php echo $i; ?>][affects_ranking]"
			value="<?php echo $subjects[$i]['affects_ranking'] ?>" /></td>
		<td><input tabindex="<?php echo $i+1; ?>" class="vc30 center" id="pos<?php echo $i; ?>" name="sub[<?php echo $i; ?>][position]" 
			value="<?php echo $subjects[$i]['position']; ?>"  /></td>				
		<td><input class="center aggre vc40" id="aggre<?php echo $i; ?>" name="sub[<?php echo $i; ?>][is_aggregate]"
			value="<?php echo $subjects[$i]['is_aggregate'] ?>" /></td>		
		<td><input class="center trans vc40" id="trans<?php echo $i; ?>" name="sub[<?php echo $i; ?>][is_transmuted]"
			value="<?php echo $subjects[$i]['is_transmuted'] ?>" /></td>
		<td><input class="center indt vc40" id="indt<?php echo $i; ?>" name="sub[<?php echo $i; ?>][indent]"
			value="<?php echo $subjects[$i]['indent'] ?>" /></td>
		<td><input class="center sem vc40" id="sem<?php echo $i; ?>" name="sub[<?php echo $i; ?>][semester]"
			value="<?php echo $subjects[$i]['semester'] ?>" /></td>
		<td><input class="center num vc40" id="num<?php echo $i; ?>" name="sub[<?php echo $i; ?>][is_num]"
			value="<?php echo $subjects[$i]['is_num'] ?>" /></td>
		
		
<td> 
	<button id="csb<?php echo $i; ?>" onclick="xeditSubject(<?php echo $i.','.$subjects[$i]['subid']; ?>);return false;" > Save </button>
</td>
<td class="hd" >
	<button><a onclick="return confirm('Dangerous! No Undo! Proceed?');" 
		href='<?php echo URL."subjects/delete/".$subjects[$i]['subid']; ?>' >Delete</a></button>
</td>
		
	</tr>	
<?php endfor; ?>

</table>

<p>
	<!-- better ajax xeditBtn -->
	<input onclick="return confirm('Are you sure?');" type="submit" name="save" value="Save All" /> &nbsp; 
	<button><a class="no-underline" href="<?php echo URL.'mis/subjects'; ?>">Cancel</a></button>
</p>

</form>
<br />

<!------------------------------------------------------------------------->
<hr />

<form method="POST" >	<!-- form add subjects -->
<!------------------------------------------------------------------>

<div style="width:600px;float:left;"  >
<h5> Add Subjects </h5>
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>Name</th>
	<th>Code</th>
	<th>
		Type<br />
		<select id="ictype" class=''>	
			<?php	foreach($crstypes as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
			<?php	endforeach; ?>						
		</select>				
		<br /><input type="button" value="All" onclick="populateColumn('ctype');" >			
	</th>	
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><input id="subj<?php echo $i; ?>" class="pdl05 vc300" type="text" name="subjects[<?php echo $i; ?>][name]" /></td>
	<td><input id="subcode<?php echo $i; ?>" class="pdl05 vc50" type="text" name="subjects[<?php echo $i; ?>][code]" /></td>
	<td>
		<select class="ctype" name="subjects[<?php echo $i; ?>][crstype_id]"  >
			<?php	foreach($crstypes as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
			<?php	endforeach; ?>				
		</select>
	</td>	
</tr>

<?php endfor; ?>			
</table>

<p>
	<input onclick="return confirm('Sure?');" type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->

</table>


<p><?php $this->shovel('numrows'); ?></p>
</div>

<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="subj" >Name</option>
	<option value="subcode" >Code</option>
</select>
</p>
<?php $d['width'] = '40'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>






<!------------------------------------------------------------------------->


<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $sy; ?>';

$(function(){
	hd();

		
})



function xeditSubject(i,sub){

	$('#csb'+i).hide();	
	
	var pos 		= $('#pos'+i).val();
	var name 		= $('#name'+i).val();
	var code 		= $('#code'+i).val();
	var cty 		= $('#cty'+i).val();
	var actv 		= $('#actv'+i).val();

	var num 		= $('#num'+i).val();
	var ws 			= $('#ws'+i).val();
	var kpup 		= $('#kpup'+i).val();
	var prnt 		= $('#prnt'+i).val();
	var wt 		= $('#wt'+i).val();
	var iga 	= $('#iga'+i).val();
	var ar 		= $('#ar'+i).val();
	var indt 	= $('#indt'+i).val();
	var aggre 	= $('#aggre'+i).val();
	var trans 	= $('#trans'+i).val();

	
	// var vurl = gurl + '/mis/xeditSubject/'+sub+'/'+sy;	
	var vurl = gurl + '/ajax/xsubjects.php';	
	var task = 'xeditSubject';	
	var pdata = "name="+name+"&code="+code+"&cty="+cty+"&actv="+actv+"&pos="+pos;
	pdata += "&num="+num+"&ws="+ws+"&kpup="+kpup+"&prnt="+prnt+"&wt="+wt+"&sub="+sub+"&sy="+sy;
	pdata += "&iga="+iga+"&ar="+ar+"&indt="+indt+"&aggre="+aggre+"&trans="+trans+"&task="+task;
	
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,success:function(){} 
   });				
	
}	



</script>


