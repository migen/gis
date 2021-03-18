


function xgetDataByTable(dbtable,limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xgetDataByPart.php';	
	var task = "xgetDataByPart";
	
	alert('part: '+part+', vurl:'+vurl+', task:'+task+', dbtable:'+dbtable);	
	
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
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnFilter();return false;" >'+s[i].code+' - '+s[i].name+'</span>'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				

	
}	/* fxn */



function closeFilter(){
	$('#names').hide();
}

