

function closeFilter(){
	$('#names').hide();
}



function xgetPriv(tid,i){
	var vurl 	= gurl + '/ajax/xcontacts.php';	
	var task	= "xgetPriv";	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&tid='+tid,				
		async: true,
		success: function(s) { 	
			console.log(s);
			$('#tid'+i).val(s.tid);
			$('#role'+i).val(s.roleid);
			$('#priv'+i).val(s.privid);
		}		  
    });				

	
}	/* fxn */



function xgetContactsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xtestlookups.php';	
	var task = "xgetContactsByPart";
	// alert(vurl+', task: '+task);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,				
		async: true,
		success: function(s) { 
			console.log(s);
			alert(s[0].name);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].name+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}
    });				
	
}	/* fxn */



function abc(){ alert('abc'); }



function xgetPersonsByPartOK(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xtestlookups.php';	
	var task = "xgetPersonsByPart";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,				
		async: true,
		success: function(s) { 
			console.log(s);
			alert(s[0].name);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirPerson(this.id);return false;" >'+s[i].name+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}
    });				
	
}	/* fxn */



function xgetPersonsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xtestlookups.php';	
	var task = "xgetPersonsByPart";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,				
		async: true,
		success: function(s) { 
			console.log(s);
			alert(s[0].name);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {	
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirPerson(this.id);return false;" >'+s[i].name+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}
    });				
	
}	/* fxn */



