function redirPo(){
	var poid=$('#poid').val();
	var url=gurl+'/purchases/viewPO/'+poid+'/'+sy;
	window.location=url;
}
