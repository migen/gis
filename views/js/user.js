
function xcheckLogin(i){

var login = $('#login'+i).val();
var vurl 	= gurl + '/ajax.xcontacts.php';	
var task	= "xverifyCode";

$.ajax({
	url: vurl,
	dataType: "json",
	type: 'POST',
	data: 'task='+task+'&code='+login,				
	async: true,
	success: function(s) { 
		if(s.account){
			alert(s.pcid+' : '+s.code+': taken.');
		} else { 
			alert('Available');
		}		
	}		  
});			


}	/* fxn */

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
			$('#tid'+i).val(s.tid);
			$('#role'+i).val(s.roleid);
			$('#priv'+i).val(s.privid);
		}		  
    });				

	
}	/* fxn */