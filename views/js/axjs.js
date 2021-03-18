function getDataByTable(dbtable,limit=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/axdata.php';	
	var task = "xgetData";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&part='+part+'&limit='+limit+'&dbtable='+dbtable,async: true,
		success: function(s) {  
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnFilter(this.id);return false;" >'+s[i].name+' - #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */



// sample - loads/teacher
function getDataByTableWithCondition(dbtable,limit=20,cond=null){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/axdata.php';	
	var task = "abc";

	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&part='+part+'&limit='+limit+'&dbtable='+dbtable+'&cond='+cond,async: true,
		success: function(s) {  
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnFilter(this.id);return false;" >'+s[i].name+' - #'+s[i].id+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					

}	/* fxn */

