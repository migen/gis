function redirLookup(ucid){ 	
	var vurl = gurl+'/ajax/xshrinkages.php';		
	var task = "xgetProduct";		
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&prid='+ucid,						
		success: function(s) { 
			$('#prid').val(ucid);$('#part').val(s.name);
			$('#price').val(s.price);$('#cost').val(s.cost);	
		}		  
    });					
}
