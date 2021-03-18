

function xgetNamesByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xlookups.php';	
	var lookup = $('#lookup').val();
	var task = "xgetNamesByPart";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part+'&lookup='+lookup+'&limits='+limits,				
		async: true,
		success: function(s) { 
			// console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirLookup(this.id);return false;" >'+s[i].name+' - '+s[i].code+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}	/* fxn */



function closeFilter(){
	$('#names').hide();
}




function xgetProductsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xlookups.php';	
	var task = "xgetProductsByPart";
	
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
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirLookup(this.id);return false;" >'+s[i].code+' - '+s[i].name+'-'+s[i].barcode+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}	/* fxn */



function xgetContactsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xlookups.php';	
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
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].name+' - '+s[i].code+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}	/* fxn */



function xgetNameById(){
	var idno = $('#idno').val();	
	var vurl = gurl+'/ajax/xlookups.php';	
	var lookup = $('#lookup').val();
	var task = "xgetNameById";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&idno='+idno+'&lookup='+lookup,				
		success: function(s) { 
			// console.log(s);
			content = s.name;
			$('#names').html('<h4>'+content+'</h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }

			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}	/* fxn */





function abc(){ alert('abc'); }