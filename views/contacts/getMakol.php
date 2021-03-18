<h5>
	Makol
	
	
</h5>



<p>
	<input class="pdl05" id="part"   />
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(20);return false;" />		
	<input type="submit" value="Makol" onclick="getMakol();return false;" />		
</p>



<div id="names" >names</div>


<script>

var gurl="http://<?php echo GURL; ?>"

$(function(){
	// $('#names').text('haha');
	// $('#names').hide();
	// $('html').live('click',function(){ $('#names').hide(); });
	
})

function getMakol(){
	var vurl = gurl+'/ajax/xmakol.php';	
	var task = "xgetMakol";		
	alert(vurl+task);
	$.ajax({
		url: vurl,dataType: "json",type:'POST',
		data: 'task='+task,async: true,
		success: function(s) {  
			alert('haha');
			// $('#names').text('haha');

		}		  
    });					
}	/* fxn */



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

