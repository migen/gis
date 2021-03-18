


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
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirLookup(this.id);return false;" >'+s[i].barcode+' - '+s[i].name+' - '+s[i].code+' #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}	/* fxn */



function xgetProductsByPartRow(rid,limits=20){
	var part = $('#part'+rid).val();	
	var vurl = gurl+'/ajax/xlookups.php';	
	var task = "xgetProductsByPart";

	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,				
		async: true,
		success: function(s) { 
			// console.log(s[0]);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirLookup(this.id,'+rid+');return false;" >'+s[i].code+' - '+s[i].name+' - '+s[i].barcode+' #'+s[i].id+' supp#'+s[i].suppid+'</span></p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
	
}

