


function syOrnoValue(orno,sy){
	var url=gurl+'/invoices/printorno/'+orno+'/'+sy;
	window.open(url, '_blank');	
	
}


function copyOrnoValue(orno){
	var url=gurl+'/invoices/printorno/'+orno;
	window.open(url, '_blank');	
	
}


function printOrno(){
	var orno=$('#orno').val();
	orno=$.trim(orno);
	var url=gurl+'/invoices/printorno/'+orno;
	window.open(url, '_blank');	
	
}	/* fxn */
