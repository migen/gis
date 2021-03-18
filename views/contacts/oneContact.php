<?php

pr($_SESSION['q']);

?>

<h5>
	Ajax One Contact
	
	

</h5>


<p>
	<input class="pdl05" id="part"   />
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(20);return false;" />		
</p>

<?php if($ucid): ?>
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['ucid']; ?></td></tr>
<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
</table>
<?php endif; ?>

<div id="names" >names</div>


<script>

var gurl="http://<?php echo GURL; ?>"

$(function(){
	// $('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/contacts/one/'+ucid;	
	alert(url);
	// window.location = url;		
}

function xgetContactsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xcontacts.php';	
	var task = "xgetContactsByPart";		
	alert(part);
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  
			// console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].name+' - '+s[i].account+' - '+s[i].code+' #'+s[i].id+' R#'+s[i].role_id+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */



</script>