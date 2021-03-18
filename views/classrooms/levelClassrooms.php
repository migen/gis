<style>


</style>


<?php 


$get = isset($_GET['get'])? true:false;	
	
?>


<?php $this->shovel('hdpdiv'); ?>



<h5>
	Level Classrooms | <?php shovel('homelinks'); ?>
	<?php echo (isset($_GET['all']))? NULL:$level['name'].' | '; ?>		
	(<?php echo $num_classrooms; ?>)
	  <?php $this->shovel('homelinks','mis'); ?>	
	| <a href="<?php echo URL.'classrooms'; ?>" >Index</a>
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" >Setup</a>
	| <a href="<?php echo URL.'dashboard/mis/'.$sy; ?>" >Dashboard</a>
	| <a href="<?php echo URL.'classrooms/add'; ?>" >Add</a>
	| <a class="u" onclick="traceshd();" >Coordinator</a>
	| <a href="<?php echo URL.'classrooms/level?all'; ?>" >All</a>	
	| <a href="<?php echo URL.'sections'; ?>" >Sections</a>	
	| <a href="<?php echo URL.'classrooms/level/'.$level_id.'?get'; ?>" >GET</a>	
	
	<select class="vc150"  >
		<option value="0">Choose One</option>
		<?php foreach($teachers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>"  >
				<?php echo '#'.$sel['id'].'-'.$sel['name'].' - '.$sel['role'].' - '.$sel['account']; ?></option>
		<?php endforeach; ?>
	</select>			
	
<?php 
	$d['sy']=$sy;$d['repage']="classrooms/level/$level_id";
	$this->shovel('sy_selector',$d); 
?>	

	
</h5>



<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."classrooms/level/".$sel['id'].DS.$sy; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>


<!----------------------------------------------------------------------------------------------------------------->
<div style="float:left;width:100%;" >	<!-- body left -->
<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>Crid</th>
	<th>Lvl</th>
	<th>Sxn</th>
	<th>Name</th>
	<th>Label</th>
	<th>Level</th>
	<th>Section</th>
	<th>Num</th>
	<th>Sxng</th>
	<th>Cls</th>
	<th>Crs</th>
	<th>Matrix</th>
	<th>PCID</th>	
	<th>Adviser</th>	
	<th class="shd" >Coordinator</th>	
	<th>&nbsp;</th>	
	<th class="shd" >Manage</th>		
	<th class="hd" >Grades</th>
</tr>
<?php for($i=0;$i<$num_classrooms;$i++): ?>
<tr class="<?php echo ($classrooms[$i]['is_active']==0)? 'red':NULL; ?>"  >
	<td> <?php echo $classrooms[$i]['crid']; ?> </td>
	<td> <?php echo $classrooms[$i]['level_id']; ?> </td>
	<td> <?php echo $classrooms[$i]['section_id']; ?> </td>
	<td> <?php echo $classrooms[$i]['name']; ?> </td>
		
	<td>
	<input type="hidden" name="posts[<?php echo $i; ?>][crid]" value="<?php echo $classrooms[$i]['crid']; ?>" />	
	<input class="vc150 pdl05" id="label<?php echo $i; ?>" name="posts[<?php echo $i; ?>][label]" 
		value="<?php echo ($get)? $classrooms[$i]['level'].'-'.$classrooms[$i]['section']:$classrooms[$i]['label']; ?>" /></td>	
	
	<td> <?php echo $classrooms[$i]['level']; ?> </a> </td>
	<td> <?php echo $classrooms[$i]['section_code']; ?> </a> </td>
	<td><input class="vc30 center" id="num<?php echo $i; ?>" value="<?php echo $classrooms[$i]['num']; ?>" /></td>	
	<td> <a href="<?php echo URL.'rosters/classroom/'.$classrooms[$i]['crid'].DS.$sy; ?>" >Sxng</a> </td>
	<td> <a href="<?php echo URL.'classlists/classroom/'.$classrooms[$i]['crid'].DS.$sy; ?>" >List</a> </td>
	<td> <a href="<?php echo URL.'mis/courses/'.$classrooms[$i]['crid'].DS.$sy; ?>" >Crs</a> </td>
	<td> <a href="<?php echo URL.'matrix/grades/'.$classrooms[$i]['crid'].DS.$sy; ?>" >Matrix</a> </td>
	<td><input class="vc50 pdl05" id="advi<?php echo $i; ?>" value="<?php echo $classrooms[$i]['acid']; ?>" 
		name="posts[<?php echo $i; ?>][acid]" tabindex=2 /></td>
	<td><?php $substr_advi = substr($classrooms[$i]['adviser'],0,12); ?>
	
		<input class="vc120 pdl05" id="part<?php echo $i; ?>" value="<?php echo $substr_advi; ?>" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPartRow(<?php echo $i; ?>);return false;" />				
	</td>
	
	<td class="shd" >
		<select id="coor<?php echo $i; ?>" class="coor vc150"  >
			<option value="0">Choose One</option>
			<?php foreach($coordinators AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$classrooms[$i]['hcid'])? 'selected':null; ?> ><?php echo $sel['name'].' - '.$sel['role'].' - '.$sel['account']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>	
	
		<td> 
			<button><a class='txt-black no-underline' href='<?php echo URL."classrooms/edit/".$classrooms[$i]['id'].DS.$sy; ?>' >Edit</a></button>
			<button id="cab<?php echo $i; ?>" onclick="xeditClsAdmin(<?php echo $i.','.$classrooms[$i]['id']; ?>);return false;" > Save </button>  
			<br /><a class="" href="<?php echo URL.'mgt/users/'.$classrooms[$i]['acid']; ?>" >Users</a>			
			| <a class="" href="<?php echo URL.'mgt/pass/'.$classrooms[$i]['acid']; ?>" >Pass</a>			
		</td>

	<td class="shd" >	
		<!-- @MISController/syncGrades -->
			<a onclick="return confirm('Are you sure?');" 
				href='<?php echo URL."mis/syncGrades/".$classrooms[$i]['id'].DS.$sy; ?>' >Sync</a>
	</td>
		
<td class="hd" > <button id="crb<?php echo $i; ?>" onclick="xeditCrig(<?php echo $i.','.$classrooms[$i]['id']; ?>);return false;" > 
	IG Open </button>  </td>
		
</tr>
<?php endfor; ?>



</table>
<p><input type="submit" name="submit" value="Save All"  /></p>

</form>


</div>	<!-- boyd left -->


<div class="fourth hd" id="names" > </div>


<br />
<div class="clear" >&nbsp;</div>

<form method="POST" >	<!-- form add subjects -->
<div class="addrows" style="width:600px;float:left;"  >
<h5> 
	  Add Classroom
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>


<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>ID</th>	
	<th>Lvl#</th>
	<th>Sxn#</th>
	<th>Label</th>
	<th>Num</th>
</tr>

<tbody>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<?php $crid+=1; ?>
<tr>
	<td><input id="crid<?php echo $i; ?>" class="vc50 pdl05" name="posts[<?php echo $i; ?>][crid]" value="<?php echo $crid; ?>" /></td>
	<td>
		<select id="lvl<?php echo $i; ?>" class="vc80 pdl05" name="posts[<?php echo $i; ?>][level_id]" >
			<?php foreach($levels AS $sel): ?>	
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['code']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	
	<td>
		<select id="sxn<?php echo $i; ?>" class="vc80 pdl05" name="posts[<?php echo $i; ?>][section_id]" >
			<?php foreach($sections AS $sel): ?>	
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['code']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	
	<td><input id="label<?php echo $i; ?>" class="vc100 pdl05" name="posts[<?php echo $i; ?>][label]" /></td>					
	<td><input id="num<?php echo $i; ?>" class="vc30 center" name="posts[<?php echo $i; ?>][num]" value="1" /></td>					
</tr>

<?php endfor; ?>			
</tbody></table>

<p>
	<input onclick="return confirm('Sure?');" type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->

<p><?php $this->shovel('numrows'); ?></p>
</div>	<!-- addrows -->

<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="crid" >CRID</option>
	<option value="lvl" >Lvl ID</option>
	<option value="sxn" >Sxn ID</option>
	<option value="label" >Label</option>
	<option value="num" >Num</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>


<div class="clear ht100" >&nbsp;</div>





<div class="clear ht100" >&nbsp;</div>







<!-- ============================================================== -->

<script>

var gurl 	= 'http://<?php echo GURL; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';
var sy 		= '<?php echo $sy; ?>';


$(function(){
	hd();
	shd();
	itago('addrows');
	itago('clipboard');
	$('#hdpdiv').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});

})

function alsped(){

	var sp = $("#sped").attr('checked');
	alert(sp);

}

function toggleThis(){
	$('.shown').hide();
	$('.hd').toggle();
}

function addClassroom(){
	
	var cfrm = confirm('Are you sure?');
	if(!cfrm) {
		location.reload();
		return false;		
	}
	
	var deptid 	= $('#deptid').val();
	var lid 	= $('#lid').val();
	var lcode 	= $('#lcode').val();
	var sxn 	= $('#sxn').val();
	var sxncode = $('#sxncode').val();
	var selsxn  = $('#selsxn').val();
	var sped	= 0;

	var sp = $("#sped").attr('checked');
	if(sp=='checked'){ sped 	= 1; } 

	if(sxn!='' && sxncode!=''){
		var vurl 	= gurl + '/mis/xaddSection/'+ lid+'/'+lcode+'/'+sxn+'/'+sxncode+ '/' + deptid+'/'+sy;
	} else {
		var vurl 	= gurl + '/mis/xaddClassroom/' + lid + '/'+lcode+ '/' + selsxn+ '/' + deptid+'/'+sy;	
	}	
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: "sped="+sped,	  	  			  	  
	  success: function() { location.reload();}		  
    });				
	

	
}	/* fxn */

/* 
	var vurl 	= gurl + '/ajax/xcontacts.php';	
	var task	= "xgetPriv";	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&tid='+tid,				
		async: true,
		success: function(s) { 			
			$('#tid'+i).val(s.tid);
			$('#role'+i).val(s.roleid);
			$('#priv'+i).val(s.privid);
		}		  
    });				
 */

function xeditClsAdmin(i,crid){
	$('#cab'+i).hide();
	var name 	= $('#name'+i).val();
	var label 	= $('#label'+i).val();	
	var advi 	= $('#advi'+i).val();
	var coor 	= $('#coor'+i).val();
	var num = $('#num'+i).val();	
	var vurl = gurl + '/ajax/xclassrooms.php';	
	var task = 'xeditClsAdmin';	
	var pdata = "task="+task+"&advi="+advi+"&coor="+coor+"&num="+num+"&name="+name+"&label="+label+"&crid="+crid+"&sy="+sy;
	
	$.ajax({
	  type: 'POST',url: vurl,
	  data: pdata,
	  success:function(){} 
   });				

	
}	

function xeditCrig(i,crid){
	$('#crb'+i).hide();	
	var vurl = gurl + '/ajax/xclassroooms.php';		
	var task = 'xeditCrig';		
	$.ajax({
	  type: 'POST',url: vurl,data: "crid="+crid+"&task="+task+"&sy="+sy,success:function(){} 
   });				
}	/* fxn */




function redirContact(pcid,rid){	
	$('#advi'+rid).val(pcid);
	
}	/* fxn */



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>