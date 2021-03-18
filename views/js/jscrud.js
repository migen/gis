function xaddCodename(dbtable){
	var vurl=gurl+"/ajax/xcrud.php";
	var task="xaddCodename";
	var code=$('#code').val();
	var name=$('#name').val();	
	
	$.ajax({
		url:vurl,type:"POST",data:"task="+task+"&dbtable="+dbtable+"&code="+code+"&name="+name,
		success: function() {  
			$('#code').val('');
			$('#name').val('');

		}		  
    });				

	
}	/* fxn */


