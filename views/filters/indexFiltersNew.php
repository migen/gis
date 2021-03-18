<?php 
	// pr($_SESSION['q']);
	$q=$_SESSION['q'];
	debug($q);
?>

<h5>
	Filters
	
</h5>

<p id="display" ></p>

<form method="POST" >
<table class="gis-table-bordered" >
	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" autofocus  />
			<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
			<input name="ucid" id="ucid" readonly class="vc50" />
		</td>
	</tr>	
</table>
<br />


<h5>Non Students Only</h5>
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Ucid</th>
</tr>

<?php for($i=0;$i<3;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td>		
		<input class="vc200 pdl05" id="rowName-<?php echo $i; ?>"   />
		<input type="submit" name="auto" value="Filter" onclick="xgetNonstudentsByPartRow(<?php echo $i; ?>);return false;" />		
	</td>	
	<td><input class="ucid vc50 pdl05" readonly name="posts[<?php echo $i; ?>][ucid]" id="rowId-<?php echo $i; ?>" tabindex="6" /></td>			
</tr>

<?php endfor; ?>

</table>


<h5>All Contacts</h5>
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Ucid</th>
</tr>

<?php for($i=3;$i<6;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td>		
		<input class="vc200 pdl05" id="rowName-<?php echo $i; ?>"   />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPartRow(<?php echo $i; ?>);return false;" />		
	</td>	
	<td><input class="ucid vc50 pdl05" readonly name="posts[<?php echo $i; ?>][ucid]" id="rowId-<?php echo $i; ?>" 
		ondblclick="xname('dbo','00_contacts',this.value);" tabindex="6" /></td>			
</tr>
<?php endfor; ?>
</table>


<p><input type="submit" name="submit" value="Submit"  /></p>
</form>

<div id="names" ></div>


<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });	
	
})

function redirContact(ucid){
	$('#names').hide();
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
	var part = $('#rowName-'+rid).val();	
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

