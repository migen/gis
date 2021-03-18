function redirContact(ucid){
	$('#scid').val(ucid);	
	var vurl = gurl+'/ajax/xgetContacts.php';		
	var task = "xgetStudentByUcid";	
		
	$.post(vurl,{task:task,ucid:ucid},function(s){		
		$('#prevcrid').val(s.crid);		
		$('#part').val(s.name);		
		$('#codes').val(s.code);						
	},'json');	

	
}	/* fxn */


function releaseRoster(i,scid){
	var row = $('#tr'+i);
	var vurl = gurl+'/ajax/xrosters.php';		
	var task = "releaseRoster";			
	var pdata  = "task="+task+"&scid="+scid+"&crid="+crid+"&sy="+sy;
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,
	  success:function(){ row.remove();$('#part').focus();} 
	});				
}	/* fxn */


function addRoster1(){
	var scid = $('#scid').val();
	var stud = $('#part').val();
	var code = $('#codes').val();	
	var prevcrid = $('#prevcrid').val();	
	var vurl = gurl+'/ajax/xrosters.php';		
	var task = "xeditRoster";			
	var pdata  = "task="+task+"&scid="+scid+"&crid="+crid+"&prevcrid="+prevcrid+"&acid="+acid+"&sy="+sy;
		
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,
	  success:function(){
		$("#form")[0].reset();	$('#part').focus();
		$('#roster').append('<tr><td>'+scid+'</td><td>'+code+'</td><td>'+stud+'</td><td></td></tr>');	  
	  } 
	});				

}	/* fxn */


function addRoster(){
	var scid = $('#scid').val();
	var stud = $('#part').val();
	var code = $('#codes').val();	
	var prevcrid = $('#prevcrid').val();	
	var vurl = gurl+'/ajax/xrosters.php';		
	var task = "xeditRoster";			
	var pdata  = "task="+task+"&sy="+sy+"&scid="+scid+"&crid="+crid+"&prevcrid="+prevcrid;
			
	alert(pdata);
	
	// $.ajax({
	  // type: 'POST',url: vurl,data: pdata,
	  // success:function(){
		// $("#form")[0].reset();	$('#part').focus();
		// $('#roster').append('<tr><td>'+scid+'</td><td>'+code+'</td><td>'+stud+'</td><td></td></tr>');	  
	  // } 
	// });				

}	/* fxn */




function registerStudent(){
	var stud = $('#part').val();
	var code = $('#codes').val();		
	var prevcrid = $('#prevcrid').val();		
		
	var vurl = gurl+'/ajax/xrosters.php';		
	var task = "registerStudent";			
	var pdata  = "task="+task+"&stud="+stud+"&code="+code+"&crid="+crid+"&acid="+acid+"&sy="+sy;
	
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,
	  success:function(){
		$("#form")[0].reset();		
		$('#part').focus();
		$('#roster').append('<tr><td></td><td>'+code+'</td><td>'+stud+'</td><td></td></tr>');	  
	  } 
	});				

}	/* fxn */



function moveToTmp(i,scid){
	var row = $('#tr'+i);
	var vurl = gurl+'/ajax/xrosters.php';		
	var task = "moveToTmp";			
	var pdata  = "task="+task+"&scid="+scid+"&tmpcrid="+tmpcrid+"&crid="+crid+"&sy="+sy;
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,
	  success:function(){ row.remove();$('#part').focus();} 
	});				

}


function moveToOut(i,scid){
	var row = $('#tr'+i);
	var vurl = gurl+'/ajax/xrosters.php';		
	var task = "moveToOut";			
	var pdata  = "task="+task+"&scid="+scid+"&outcrid="+outcrid+"&crid="+crid+"&sy="+sy;	
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,
	  success:function(){ row.remove();$('#part').focus(); } 
	});				
}	/* fxn */





function xgetContactsByPartRosters(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xrosters.php';	
	var task = "xgetStudentsByPartRosters";	
	
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
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].name+' - '+s[i].account+' - '+s[i].code+' #'+s[i].id+' R#'+s[i].role_id+' Summcrid#'+s[i].crid+'</span></p>';
}	
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */

