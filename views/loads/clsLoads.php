<?php 
// pr($_SESSION['q']);
if(isset($_GET['debug'])){ pr($_SESSION['q']); }

// pr($_SESSION['q']);
if(isset($_GET['debug'])){ pr($rows[0]); }
// pr($rows[0]);

$get = isset($_GET['get'])? true:false;	


?>

<h5>
	Cls Loads (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href="<?php echo URL.'loads/cls/'.$crid.'?get'; ?>" >GET</a>	
	| <a href="<?php echo URL.'advisers/crscfg/'.$crid; ?>" >CrsCfg</a>	
	
	<select id="crid" onchange="redirThis();" class="vc200" >
		<?php foreach($classrooms AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
				<?php echo ($sel['id']==$crid)? 'selected':NULL; ?>
			><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>	
	
</h5>

<?php if($crid>0): ?>
<p>(<?php echo $classroom['level'].' - '.$classroom['section'].' #'.$classroom['crid'];
	echo ' | Adviser: '; 
	echo $classroom['adviser'].' #'.$classroom['acid']; ?>)</p>
<?php endif; ?>

<div style="float:left;width:60%" >
<form method="POST" >
<table class="gis-table-bordered table-altrow" >

<tr>
<th>#</th>
<th>Subcode</th>
<th>Subject</th>
<th>Course</th>
<th>Teacher</th>
<th>Tcid</th>
<th>Crs</th>
<th class="center" >Pos</th>
<th>Save</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['subcode']; ?></td>
	<td class="vc150" ><?php echo $rows[$i]['subject']; ?></td>
	<td class="v300" >
		<textarea name="posts[<?php echo $i; ?>][course]"  id="course<?php echo $i; ?>" 
			><?php echo ($get)? $rows[$i]['classroom'].'-'.$rows[$i]['label']:$rows[$i]['course']; ?></textarea>
	</td>
<td class="vc200" >
	<?php $substr_teac = substr($rows[$i]['teacher'],0,50); ?>	
	<input class="full pdl05" id="part<?php echo $i; ?>" value="<?php echo $substr_teac; ?>" />		
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPartRow(<?php echo $i; ?>);return false;" />
</td>
<td><input id="tcid<?php echo $i; ?>" class="tcid pdl05 vc50" name="posts[<?php echo $i; ?>][tcid]" 
			value="<?php echo $rows[$i]['tcid']; ?>"  />
	<input type="hidden" name="posts[<?php echo $i; ?>][crs]" value="<?php echo $rows[$i]['crs']; ?>"  />			
</td>
	<td><?php echo $rows[$i]['crs']; ?></td>
<td><input id="pos-<?php echo $i; ?>" class="pos center vc50" name="posts[<?php echo $i; ?>][position]" 
			tabIndex=2 value="<?php echo $rows[$i]['position']; ?>"  />
	<input type="hidden" name="posts[<?php echo $i; ?>][crs]" value="<?php echo $rows[$i]['crs']; ?>"  />			
</td>	
	<td>
		<a id="btn<?php echo $i; ?>" class="txt-blue u" onclick="xeditCrsTeac(<?php echo $i.','.$rows[$i]['crs']; ?>);"  >Save</a>	
	</td>
	
</tr>
<?php endfor; ?>
</table>
<p><input type="submit" name="submit" value="Save All"  /></p>
</form>
</div>

<div class="borderedx" style="float:left;width:36%" id="names" >names</div>



<script>

var gurl = "http://<?php echo GURL; ?>";
var crid = "<?php echo $crid; ?>";

$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	selectFocused();


})


function redirThis(){
	var crid=$('#crid').val();
	jsredirect('loads/cls/'+crid); 	
	
}

function xgetTeacher(i){
	var code = $('#tcode'+i).val();
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";			
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&code='+code,async: true,
		success: function(s) { 	$('#tcid'+i).val(s.id); }		  
    });				
		
}	/* fxn */


function xeditCrsTeac(i,crsid){
	$('#btn'+i).hide();
	var tcid=$('#tcid'+i).val();
	var course=$('#course'+i).val();
	var pos=$('#pos-'+i).val();
	
	var vurl 	= gurl + '/ajax/xcourses.php';	
	var task	= "xeditCrsTeac";	
	var pdata = "task="+task+"&crsid="+crsid+"&tcid="+tcid+"&course="+course+"&pos="+pos+"&crid="+crid;		
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,success:function(){} 
   });				
	
}	/* fxn */


function redirContact(pcid,rid){	
	$('input[name="posts['+rid+'][tcid]"]').val(pcid);		
}	/* fxn */



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
