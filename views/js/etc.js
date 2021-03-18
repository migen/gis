function timeoutLogout(minutestologout) {
	var x = minutestologout*1000;
    setTimeout(function () {
		window.location.href = "users/logout";
		timeoutLogout();
    }, x);
}



function modalCss(color){
	$('#modalDiv').css({
		'font-size' :'20',
		'padding'   :'10',
		'background-color':color			
	});		
	$('.ui-dialog-titlebar').css('background-color',color);
	$('.ui-dialog-buttonset').css('background-color',color);	
}


function modalShow(tag){	/* advanced search */
	var content = '';
	$('.hd'+tag).each(function(){
		content += $(this).html();
	});
	
	modalCss('lightblue');
	
	$('#modalDiv').html(content).dialog({	
		modal: true,
		buttons : [{
		text : "Ok",
		click : function() {
			$(this).dialog("close");
		}
		}],	
	});  

}


function modalView(){ $("#modalDiv").modal('show');	 }


function redirStatus(home){	
	var scode   = $('#status').val();
	var rurl 	= gurl + '/'+home+'/status/'+scode;		
	window.location = rurl;		
}



function xname(dbx,tbl,id){
	var vurl = gurl+'/ajax/xnames.php';			
	$.ajax({
	  type: 'POST',url: vurl,dataType: "json",	  
	  data: "dbx="+dbx+"&tbl="+tbl+"&id="+id,
	  success:function(s){ $("#display").html(s.name); } 
   });				
	
}	

function xpopname(dbx,tbl,id){
	var vurl = gurl+'/ajax/xnames.php';		
	$.ajax({
	  type: 'POST',url: vurl,dataType: "json",	  
	  data: "dbx="+dbx+"&tbl="+tbl+"&id="+id,
	  success:function(s){ alert(s.name); } 
   });					
}	

function xgetid(dbx,tbl,name){
	var vurl = gurl+'/ajax/xgetid.php';		
	$.ajax({
	  type: 'POST',url: vurl,dataType: "json",	  
	  data: "dbx="+dbx+"&tbl="+tbl+"&name="+name,
	  success:function(s){ $("#display").html(s.id); } 
	});				
	
}	
