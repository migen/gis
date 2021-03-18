<h5> 
	Contacts
	
	
</h5>

















<!------------------------------------------------------------------------------------------------------------------------>


<script>

var gurl     = 'http://<?php echo GURL; ?>';

$(function(){
	alert('hahaa');
	hd();
	rc('rc');
	nextViaEnter();
	
})


function rc(cls){
	var x;
	$('.'+cls).each(function(){
		x = this.rowIndex;
		$(this).find("td:first").text(x);
	});
}

function xcheckLogin(i){

var login = $('#login'+i).val();
var vurl 	= gurl + '/mis/xcheckLogin';	
	
$.ajax({
	url: vurl,
	dataType: "json",
	type: 'POST',
	data: 'login='+login,				
	async: true,
	success: function(s) { 
		if(s.account){
			alert(s.code+': That username has been taken.');
		} else { 
			alert('Available');
		}		
	}		  
});			


}	

function xgetPriv(tid,i){
	
	var vurl 	= gurl + '/mis/xgetPriv';	
	// alert(vurl);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'tid='+tid,				
		async: true,
		success: function(s) { 			
			$('#tid'+i).val(s.tid);
			$('#role'+i).val(s.roleid);
			$('#priv'+i).val(s.privid);
		}		  
    });				

	
}	/* fxn */



</script>
