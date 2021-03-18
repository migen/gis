<?php 

$dbg=PDBG;
$dbtable="{$dbg}.01_classrooms";

?>

<h5>
	College Advisers (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<?php 

// pr($rows[0]); 

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Classroom</th>
	<th class="center" >Acid</th>
	<th>Adviser</th>
	<th></th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $crid=$rows[$i]['crid']; ?>
<?php $acid=$rows[$i]['acid']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="center" ><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><input id="rowId-<?php echo $i; ?>" class="vc50 center" name="posts[<?php echo $i; ?>][acid]" 
		value="<?php echo $acid; ?>" readonly /></td>	
	<td><input class="vc150" id="part-<?php echo $i; ?>" value="<?php echo $rows[$i]['adviser']; ?>" ></td>
	<td><input type="submit" name="auto" value="Filter" onclick="xgetNonstudentsByPartRow(<?php echo $i; ?>);return false;" /></td>
	<td><button id="btn-<?php echo $i; ?>" onclick="xeditData(<?php echo $i; ?>);" >Save</button></td>
	<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $crid; ?>" >
	
</tr>
<?php endfor; ?>
</table>


<div id="names" ></div>


<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';
var dbtable="<?php echo $dbtable; ?>";


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });	
	nextViaEnter();
	
})

function xeditData(i){
	var id=$('input[name="posts['+i+'][id]"]').val();
	var acid=$('input[name="posts['+i+'][acid]"]').val();
	var vurl=gurl+'/ajax/xsaveData.php';	
	var task="xeditData";		
	// alert(vurl+', id: '+id+', acid: '+acid);
	
	$.ajax({
		url:vurl,type:"POST",data:"task="+task+"&dbtable="+dbtable+"&acid="+acid+"&id="+id,
		success: function() { $("#btn-"+i).hide(); }		  
    });				
	
}	/* fxn */



function redirContact(ucid){
	// $('#names').hide();
	$('#ucid').val(ucid);
}

function redirRow(ucid,rid){	
	$('input[name="posts['+rid+'][ucid]"]').val(ucid);		
	var vurl = gurl + "/ajax/xgetContacts.php";	
	var task = "xgetContactByUcid";	
	$.ajax({
	  type: 'POST',dataType: "json",url: vurl,data: "task="+task+"&ucid="+ucid,
	  success:function(s){ 
		$('#rowId-'+rid).val(ucid); 
		$('#rowName-'+rid).val(s.name);
	  } 
   });				
		
}	/* fxn */

function setRowValue(ucid,rid){	
	$('input[name="posts['+rid+'][ucid]"]').val(ucid);		
	var vurl = gurl + "/ajax/xgetContacts.php";	
	var task = "xgetContactByUcid";	
	$.ajax({
	  type: 'POST',dataType: "json",url: vurl,data: "task="+task+"&ucid="+ucid,
	  success:function(s){ 
		$('#rowId-'+rid).val(s.id);	
		$('#rowName-'+rid).val(s.name); 		
	  } 
   });				
		
}	/* fxn */


function xgetNonstudentsByPartRow(rid,limits=20){
	var part = $('#part-'+rid).val();	
	var vurl = gurl+'/ajax/xgetNonstudents.php';	
	var task = "xgetNonstudentsByPart";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&part='+part+'&limits='+limits,
		success: function(s) {
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			console.log(s);
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirRow('+s[i].id+','+rid+');return false;" >'+s[i].code+'</span> - '+(i+1)+'-'+s[i].name+' - R'+s[i].role_id+'-P'+s[i].parent_id+'-U'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';
		}		  
    });				
	
}



function xgetContactsByPartRow(rid,limits=20){
	var part = $('#rowName-'+rid).val();	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactsByPart";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,		
		data: 'task='+task+'&part='+part+'&limits='+limits,				
		success: function(s) {
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			// console.log(s);
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="setRowValue('+s[i].id+','+rid+');return false;" >'+s[i].code+'</span> - '+(i+1)+'-'+s[i].name+' - R'+s[i].role_id+'-P'+s[i].parent_id+'-U'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>




