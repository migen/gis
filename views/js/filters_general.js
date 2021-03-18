	
function xgetDataByTable(dbtable){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xgetData.php';	
	var task = "xgetDataByPart";
	
	$.ajax({
		url: vurl,dataType:"json",type:"POST",async:true,
		data: 'task='+task+'&part='+part+'&dbtable='+dbtable+'&limits='+limits,
		success: function(s) {  
			var cs=s.length;
			content="";
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content+='<p><span id="'+s[i].id+'" class="txt-blue b u" onclick="axnFilter(this.id);return false;" >'+s[i].name+'</span> #'+s[i].id+'</p>';
}
			$("#names").append(content).show();content="";

		}		 
    });				

	
}	/* fxn */




function xgetDataByPartRow(row_id,limits=30){
	var part = $('#part-'+row_id).val();	
	var vurl = gurl+'/ajax/xgetData.php';	
	var task = "xgetDataByPart";
	
	$.ajax({
		url: vurl,dataType:"json",type:"POST",async: true,
		data: 'task='+task+'&part='+part+'&dbtable='+dbtable+'&limits='+limits,						
		success: function(s) {
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			console.log(s);
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnFilter('+s[i].id+','+row_id+');return false;" >'+s[i].name+'</span> - '+(i+1)+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}




function closeFilter(){
	$('#names').hide();
}

