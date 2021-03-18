

function xgetStudentsByPartClubs(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xlookupsClubs.php';	
	var task = "xgetStudentsByPartClubs";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  // console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].name+' - '+s[i].account+' - '+s[i].code+' #'+s[i].id+' Club#'+s[i].club_id+'-'+s[i].club+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */


function removeStudentFromClub(i,scid){
	var vurl 	= gurl + '/ajax/xclubs.php';	
	var task	= "removeStudentFromClub";		
	$.ajax({
		url: vurl,type: 'POST',data: 'scid='+scid+'&task='+task,				
		success: function() { $('#btn-'+i).hide(); }		  
    });					
	
}	/* fxn */


