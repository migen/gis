
function xgetContactsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactsByPart";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,				
		async: true,
		success: function(s) { 
			// console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].code+'</span> - '+(i+1)+'-'+s[i].name+' - R'+s[i].role_id+'-P'+s[i].parent_id+'-U'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}	/* fxn */


function xgetContactsByPartRow(rid,limits=20){
	var part = $('#part'+rid).val();	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactsByPart";
	
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
			console.log(s);
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact('+s[i].id+','+rid+');return false;" >'+s[i].code+'</span> - '+(i+1)+'-'+s[i].name+' - R'+s[i].role_id+'-P'+s[i].parent_id+'-U'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}


function xgetContactsByCode(limits=20){
	var part = $('#codes').val();	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactsByCode";
	
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
			for (var i = 0; i < cs; i++) {			
				content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].code+'</span> - '+(i+1)+'-'+s[i].name+' - R'+s[i].role_id+'-P'+s[i].parent_id+'-U'+s[i].id+'</p>';
			}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}



function xgetContactByCode(){
	var scode 		= $('#scode').val();	
	var sy			= $('#sy').val();
	var fullname	= $('#fullname').val();
	var crid		= $('#crid').val();
	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";
			
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&code='+scode,				
		async: true,
		success: function(s) { 	
			if(s){
				var rurl = gurl+'/students/sectioner/'+s.id+'/'+sy;
				window.location = rurl;
			} else {
				$('#checkBtn').show();				
				$('#sy').val(sy);
				$('#tbl-1').hide();
				alert('No record found.');
			}
			
		}		  
    });				
	
}	




function closeFilter(){
	$('#names').hide();
}

